<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;
use Imagick;

class LogoMakerService
{

    const LARGE_IMAGE_WIDTH = 560;
    const LARGE_IMAGE_HEIGHT = 340;
    const LARGE_PADDING = 10;

    const SMALL_IMAGE_WIDTH = 217;
    const SMALL_IMAGE_HEIGHT = 132;
    const SMALL_PADDING = 5;

    public function makeLogo(string $srcUrl, int $backgroundColor)
    {
        $smallMode = false;
        $fileType = strtolower(substr($srcUrl, strlen($srcUrl)-3));
        $imageStr = file_get_contents($srcUrl);

        if ($fileType == 'svg') {
            $im = new Imagick();
            $im->readImageBlob($imageStr);
            $im->setImageFormat("png24");
            $imageStr = $im->getimageblob();
        }

        //echo $imageStr; die();

        $image = imagecreatefromstring( $imageStr
            //file_get_contents($imageStr)
            //Http::get('https://' . $srcUrl)->body()
        );



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

        $this->imagecopymerge_alpha (
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

        //imagepng($imagevar);
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

    private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
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


}
