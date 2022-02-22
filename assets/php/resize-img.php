<?php

// Compress image & Solve Rotate
function compressImage($source, $quality)
{

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    if (file_exists($source)) {

        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($source);

            if (!empty($exif['Orientation'])) {
                $imageResource = imagecreatefromjpeg($source); // provided that the image is jpeg. Use relevant function otherwise
                switch ($exif['Orientation']) {
                    case 3:
                        $image = imagerotate($imageResource, 180, 0);
                        break;
                    case 6:
                        $image = imagerotate($imageResource, -90, 0);
                        break;
                    case 8:
                        $image = imagerotate($imageResource, 90, 0);
                        break;
                    default:$image = $imageResource;
                }
            }

        }

    }


    $original_width         = imagesx($image);
    $original_height        = imagesy($image);

    $new_width          = $original_width / 2.5;
    $new_height         = $original_height / 2.5;



    $imgResized = imagescale($image , $new_width, $new_height );

    imagejpeg($imgResized, $source, $quality);

}


