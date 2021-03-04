<?php

//URL or Local path
$srcUrl = urldecode($_GET['img']);
$backgroundColor = $_GET['color'];

const LARGE_IMAGE_WIDTH = 560;
const LARGE_IMAGE_HEIGHT = 340;
const LARGE_PADDING = 20;

const SMALL_IMAGE_WIDTH = 217;
const SMALL_IMAGE_HEIGHT = 132;
const SMALL_PADDING = 10;

$smallMode = false;

header('Content-Type: image/png');



$targetW = LARGE_IMAGE_WIDTH  - LARGE_PADDING;
$targetH = LARGE_IMAGE_HEIGHT - LARGE_PADDING;

//$image = imagecreatefromstring(file_get_contents($srcUrl));imagejpeg($image);die();

$fileType = strtolower(substr($srcUrl, strlen($srcUrl)-3));
switch($fileType) {
    case('gif'):
        $image = imagecreatefromgif($srcUrl);
        break;

    case('png'):
        $image = imagecreatefrompng($srcUrl);
        break;

    default:
        $image = imagecreatefromjpeg($srcUrl);
        //imagealphablending($image, true);
        //imagejpeg($image);die();


}



//imagealphablending($image, FALSE);
imagesavealpha($image, TRUE);


$imageW = imagesx($image);
$imageH = imagesy($image);


if (
    $imageW > ( LARGE_IMAGE_WIDTH - LARGE_PADDING) ||
    $imageH > ( LARGE_IMAGE_HEIGHT - LARGE_PADDING)
)
{
    $image = createThumbnail(
        $image,
        LARGE_IMAGE_WIDTH - LARGE_PADDING,
        LARGE_IMAGE_HEIGHT - LARGE_PADDING
    );
} elseif (
    (
        $imageW < ( SMALL_IMAGE_WIDTH - SMALL_PADDING) &&
        $imageH < ( SMALL_IMAGE_HEIGHT - SMALL_PADDING)
    )
) {
    $smallMode = true;
}


$destW = $smallMode ? SMALL_IMAGE_WIDTH : LARGE_IMAGE_WIDTH;
$destH = $smallMode ? SMALL_IMAGE_HEIGHT : LARGE_IMAGE_HEIGHT;

$sourceW = imagesx($image);
$sourceH = imagesy($image);

//list($sourceW, $sourceH) = getimagesize($image);

$newImage = imagecreatetruecolor($destW, $destH) or die("unable to create image");
$color = imagecolorallocatealpha($newImage, $backgroundColor, $backgroundColor, $backgroundColor, 0);
imagefill($newImage, 0, 0, $color);

imagecopymerge_alpha (
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
imagepng($newImage);



function createThumbnail($image, $newMaxWidth, $newMaxHeight) {

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


function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
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



