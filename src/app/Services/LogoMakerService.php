<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Imagick;
use ImagickPixel;

class LogoMakerService
{

    const LARGE_IMAGE_WIDTH = 560;
    const LARGE_IMAGE_HEIGHT = 340;
    const LARGE_PADDING = 10;

    const SMALL_IMAGE_WIDTH = 217;
    const SMALL_IMAGE_HEIGHT = 132;
    const SMALL_PADDING = 5;


    public function getLogo(string $srcUrl, int $backgroundColor)
    {
        return Cache::remember(
            'img_bin_'.md5($srcUrl).$backgroundColor,
            3600,
            function () use ($srcUrl, $backgroundColor)  {
               return $this->makeLogo($srcUrl, $backgroundColor);
            }
        );
    }


    public function makeLogo(string $srcUrl, int $backgroundColor)
    {
        $smallMode = false;
        $fileType = strtolower(substr($srcUrl, strrpos($srcUrl, '.')+1, 3));
        $imageStr = file_get_contents($srcUrl);

        if ($fileType == 'svg') {
            $im = new Imagick();

            //TODO: set svg size here, fix this
            //$imageStr = $this->svgScale($imageStr, self::LARGE_IMAGE_HEIGHT, self::LARGE_IMAGE_HEIGHT);

            //set transparent
            $im->setBackgroundColor(new ImagickPixel('transparent'));
            $im->readImageBlob($imageStr);

            //$im->resizeImage($size, $size, imagick::FILTER_LANCZOS, 1);//????

            $im->setImageFormat("png32");
            $imageStr = $im->getimageblob();

            $im->clear();
            $im->destroy();
        }

        //echo $imageStr; die();

        $image = imagecreatefromstring( $imageStr );

        /*
        switch($fileType) {
            case('gif'):
                $image = imagecreatefromgif($srcUrl);
                break;

            case('png'):
                $image = imagecreatefrompng($srcUrl);
                break;

            default:
                return null;
                //$image = imagecreatefromjpeg($srcUrl);

            //imagealphablending($image, true);
            //imagejpeg($image);die();
        }*/

        //imagealphablending($image, FALSE);
        imagesavealpha($image, TRUE);


        $imageW = imagesx($image);
        $imageH = imagesy($image);


        if (
            $imageW > ( self::LARGE_IMAGE_WIDTH - self::LARGE_PADDING) ||
            $imageH > ( self::LARGE_IMAGE_HEIGHT - self::LARGE_PADDING)
        )
        {
            $image = $this->createThumbnail(
                $image,
                self::LARGE_IMAGE_WIDTH - self::LARGE_PADDING,
                self::LARGE_IMAGE_HEIGHT - self::LARGE_PADDING
            );
        } elseif (
        (
            $imageW < ( self::SMALL_IMAGE_WIDTH - self::SMALL_PADDING) &&
            $imageH < ( self::SMALL_IMAGE_HEIGHT - self::SMALL_PADDING)
        )
        ) {
            $smallMode = true;
        }


        $destW = $smallMode ? self::SMALL_IMAGE_WIDTH : self::LARGE_IMAGE_WIDTH;
        $destH = $smallMode ? self::SMALL_IMAGE_HEIGHT : self::LARGE_IMAGE_HEIGHT;

        $sourceW = imagesx($image);
        $sourceH = imagesy($image);


        $newImage = imagecreatetruecolor($destW, $destH) or die("unable to create image");
        $color = imagecolorallocatealpha($newImage, $backgroundColor, $backgroundColor, $backgroundColor, 0);
        imagefill($newImage, 0, 0, $color);

        $this->imageCopyMergeAlpha (
            $newImage,
            $image,
            ($destW - $sourceW)/2,
            ($destH - $sourceH)/2,
            0,
            0,
            $sourceW,
            $sourceH,
            90
        );

        imagesavealpha($newImage,true);

        ob_start();
        imagepng($newImage);
        $imagevar = ob_get_contents();
        ob_end_clean();
        imageDestroy($newImage);

        return $imagevar;
    }

    private function createThumbnail($image, $newMaxWidth, $newMaxHeight)
    {

        //list($old_x, $old_y) = getimagesize($image);
        $width_orig = imagesx($image);
        $height_orig = imagesy($image);

        $ratio_orig = $width_orig/$height_orig;

        if ($newMaxWidth/$newMaxHeight > $ratio_orig) {
            $newMaxWidth = $newMaxHeight * $ratio_orig;
        } else {
            $newMaxHeight = $newMaxWidth / $ratio_orig;
        }

        $dst_img  = imagecreatetruecolor( $newMaxWidth, $newMaxHeight );
        imagealphablending( $dst_img, false );
        imagesavealpha( $dst_img, true );

        imagecopyresampled($dst_img, $image,0,0,0,0,$newMaxWidth,$newMaxHeight,$width_orig,$height_orig);

        return $dst_img;
    }

    private function imageCopyMergeAlpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
    {
        if(!isset($pct)){
            return false;
        }
        $pct /= 100;
        // Get image width and height
        $w = imagesx( $src_im );
        $h = imagesy( $src_im );
        // Turn alpha blending off
        imagealphablending( $src_im, false );
        // Find the most opaque pixel in the image (the one with the smallest alpha value)
        $minalpha = 127;
        for( $x = 0; $x < $w; $x++ )
            for( $y = 0; $y < $h; $y++ ){
                $alpha = ( imagecolorat( $src_im, $x, $y ) >> 24 ) & 0xFF;
                if( $alpha < $minalpha ){
                    $minalpha = $alpha;
                }
            }
        //loop through image pixels and modify alpha for each
        for( $x = 0; $x < $w; $x++ ){
            for( $y = 0; $y < $h; $y++ ){
                //get current alpha value (represents the TANSPARENCY!)
                $colorxy = imagecolorat( $src_im, $x, $y );
                $alpha = ( $colorxy >> 24 ) & 0xFF;
                //calculate new alpha
                if( $minalpha !== 127 ){
                    $alpha = 127 + 127 * $pct * ( $alpha - 127 ) / ( 127 - $minalpha );
                } else {
                    $alpha += 127 * $pct;
                }
                //get the color index with new alpha
                $alphacolorxy = imagecolorallocatealpha( $src_im, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
                //set pixel with the new color + opacity
                if( !imagesetpixel( $src_im, $x, $y, $alphacolorxy ) ){
                    return false;
                }
            }
        }
        // The image copy
        imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
    }

    protected function svgScale($svg, $minWidth, $minHeight)
    {
        $reW = '/(.*<svg[^>]* width=")([\d.]+px)(.*)/si';
        $reH = '/(.*<svg[^>]* height=")([\d.]+px)(.*)/si';
        preg_match($reW, $svg, $mw);
        preg_match($reH, $svg, $mh);
        $width = floatval($mw[2]);
        $height = floatval($mh[2]);
        if (!$width || !$height) return false;

        // scale to make width and height big enough
        $scale = 1;
        if ($width < $minWidth)
            $scale = $minWidth/$width;
        if ($height < $minHeight)
            $scale = max($scale, ($minHeight/$height));

        $width *= $scale*2;
        $height *= $scale*2;

        $svg = preg_replace($reW, "\${1}{$width}px\${3}", $svg);
        $svg = preg_replace($reH, "\${1}{$height}px\${3}", $svg);

        return $svg;
    }


    public function __makeLogoNew(string $srcUrl, int $backgroundColor)
    {
        $img = new Imagick();
        $imageStr = file_get_contents($srcUrl);
        $img->readImageBlob($imageStr);
        $size = $img->getSize();
        $imageW = $size['columns'];
        $imageH = $size['rows'];

        var_dump($size); die();

        header("Content-Type: image/png"); echo $img->getImageBlob(); die();

        if (
            $imageW > ( self::LARGE_IMAGE_WIDTH - self::LARGE_PADDING) ||
            $imageH > ( self::LARGE_IMAGE_HEIGHT - self::LARGE_PADDING)
        )
        {
            /*$image = $this->createThumbnail(
                $image,
                self::LARGE_IMAGE_WIDTH - self::LARGE_PADDING,
                self::LARGE_IMAGE_HEIGHT - self::LARGE_PADDING
            );*/

            $img->resizeImage(320,240,Imagick::FILTER_LANCZOS,1);

        } elseif (
        (
            $imageW < ( self::SMALL_IMAGE_WIDTH - self::SMALL_PADDING) &&
            $imageH < ( self::SMALL_IMAGE_HEIGHT - self::SMALL_PADDING)
        )
        ) {
            $smallMode = true;
        }

        $img->setImageFormat("png24");
    }

    private function __imageCopyMergeAlpha($dst_im, $src_im, $dst_x, $dst_y)
    {
        $im1 = new Imagick();
        $im1->readImageBlob($dst_im);
        $im1->setImageFormat("png24");

        $im2 = new Imagick();
        $im2->readImageBlob($dst_im);
        $im2->setImageFormat("$src_im");

        $im1->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
        $im1->setImageArtifact('compose:args', "1,0,-0.5,0.5");

        $im1->compositeImage($im2, Imagick::COMPOSITE_MATHEMATICS, $dst_x, $dst_y);

        return $im1->getimageblob();
    }


}
