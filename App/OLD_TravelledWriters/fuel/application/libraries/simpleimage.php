<?php
/*
* File: SimpleImage.php (EXTENDED)
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*/

class SimpleImage {

    var $image;
    var $image_type;

    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }  elseif( $this->image_type == IMAGETYPE_BMP ) {
            $this->image = imagecreatefrombmp($filename);
        }
    }
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_BMP ) {
            imagebmp($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }
    function output($image_type=IMAGETYPE_JPEG) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image);
        } elseif( $image_type == IMAGETYPE_BMP ) {
            imagebmp($this->image);
        }
    }
    function getWidth() {
        return imagesx($this->image);
    }
    function getHeight() {
        return imagesy($this->image);
    }
    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }
    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }
    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }
    function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        if( $this->image_type == IMAGETYPE_GIF || $this->image_type == IMAGETYPE_PNG ) {
            $current_transparent = imagecolortransparent($this->image);
            if($current_transparent != -1) {
                $transparent_color = @imagecolorsforindex($this->image, $current_transparent);
                $current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($new_image, 0, 0, $current_transparent);
                imagecolortransparent($new_image, $current_transparent);
            } elseif( $this->image_type == IMAGETYPE_PNG) {
                imagealphablending($new_image, false);
                $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                imagefill($new_image, 0, 0, $color);
                imagesavealpha($new_image, true);
            }
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}

// Read & Save 24bit BMP files

// Author: de77
// Licence: MIT
// Webpage: de77.com
// Version: 07.02.2010

class BMP
{
    public static function imagebmp(&$img, $filename = false)
    {
        return imagebmp($img, $filename);
    }

    public static function imagecreatefrombmp($filename)
    {
        return imagecreatefrombmp($filename);
    }
}

function imagebmp(&$img, $filename = false)
{
    $wid = imagesx($img);
    $hei = imagesy($img);
    $wid_pad = str_pad('', $wid % 4, "\0");

    $size = 54 + ($wid + $wid_pad) * $hei;

    //prepare & save header
    $header['identifier']      = 'BM';
    $header['file_size']    = dword($size);
    $header['reserved']        = dword(0);
    $header['bitmap_data']     = dword(54);
    $header['header_size']     = dword(40);
    $header['width']        = dword($wid);
    $header['height']       = dword($hei);
    $header['planes']       = word(1);
    $header['bits_per_pixel']  = word(24);
    $header['compression']     = dword(0);
    $header['data_size']    = dword(0);
    $header['h_resolution']    = dword(0);
    $header['v_resolution']    = dword(0);
    $header['colors']       = dword(0);
    $header['important_colors']   = dword(0);

    if ($filename)
    {
        $f = fopen($filename, "wb");
        foreach ($header AS $h)
        {
            fwrite($f, $h);
        }

        //save pixels
        for ($y=$hei-1; $y>=0; $y--)
        {
            for ($x=0; $x<$wid; $x++)
            {
                $rgb = imagecolorat($img, $x, $y);
                fwrite($f, byte3($rgb));
            }
            fwrite($f, $wid_pad);
        }
        fclose($f);
    }
    else
    {
        foreach ($header AS $h)
        {
            echo $h;
        }

        //save pixels
        for ($y=$hei-1; $y>=0; $y--)
        {
            for ($x=0; $x<$wid; $x++)
            {
                $rgb = imagecolorat($img, $x, $y);
                echo byte3($rgb);
            }
            echo $wid_pad;
        }
    }
}

function imagecreatefrombmp($filename)
{
    $f = fopen($filename, "rb");

    //read header
    $header = fread($f, 54);
    $header = unpack(   'c2identifier/Vfile_size/Vreserved/Vbitmap_data/Vheader_size/' .
    'Vwidth/Vheight/vplanes/vbits_per_pixel/Vcompression/Vdata_size/'.
    'Vh_resolution/Vv_resolution/Vcolors/Vimportant_colors', $header);

    if ($header['identifier1'] != 66 or $header['identifier2'] != 77)
    {
        die('Not a valid bmp file');
    }

    if ($header['bits_per_pixel'] != 24)
    {
        die('Only 24bit BMP images are supported');
    }

    $wid2 = ceil((3*$header['width']) / 4) * 4;

    $wid = $header['width'];
    $hei = $header['height'];

    $img = imagecreatetruecolor($header['width'], $header['height']);

    //read pixels
    for ($y=$hei-1; $y>=0; $y--)
    {
        $row = fread($f, $wid2);
        $pixels = str_split($row, 3);
        for ($x=0; $x<$wid; $x++)
        {
            imagesetpixel($img, $x, $y, dwordize($pixels[$x]));
        }
    }
    fclose($f);

    return $img;
}

function dwordize($str)
{
    $a = ord($str[0]);
    $b = ord($str[1]);
    $c = ord($str[2]);
    return $c*256*256 + $b*256 + $a;
}

function byte3($n)
{
    return chr($n & 255) . chr(($n >> 8) & 255) . chr(($n >> 16) & 255);
}
function dword($n)
{
    return pack("V", $n);
}
function word($n)
{
    return pack("v", $n);
}

function crop_image($save_path, $image_path, $width, $height, $start_width, $start_height, $scale)
{
    list($imagewidth, $imageheight, $imageType) = getimagesize($image_path);
    $imageType = image_type_to_mime_type($imageType);

    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

    switch($imageType)
    {
        case "image/gif":
            $source = imagecreatefromgif($image_path);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source = imagecreatefromjpeg($image_path);
            break;
        case "image/png":
        case "image/x-png":
            $source = imagecreatefrompng($image_path);
            break;
    }

    imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);

    switch($imageType)
    {
        case "image/gif":
            imagegif($newImage, $save_path);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage, $save_path, 90);
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage, $save_path);
            break;
    }
    chmod($save_path, 0777);
    return $save_path;
}