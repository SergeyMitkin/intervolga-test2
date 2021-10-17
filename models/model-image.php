<?php

// На лету. Можно настроить кэширование
$flname  = isset($_GET["fn"]) ? $flname = $_GET["fn"] : $flname = "";
$fsize   = isset($_GET["fs"]) ? $fsize  = $_GET["fs"] : $fsize  = 100;
if (file_exists($flname) && $flname != "") {
    $flsize = filesize($flname);
    $imageproperties = getimagesize($flname) or die ("Не допустимый тип файла.");
    $mimetype = image_type_to_mime_type($imageproperties[2]);
    switch($imageproperties[2]) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($flname);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($flname);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($flname);
            break;
        default:
            die ("Не возможно создать изображение.");}
    $srcW = $imageproperties[0];
    $srcH = $imageproperties[1];
    if ($srcW > $fsize || $srcH > $fsize) {
        if ($srcW <= $srcH) $reduction = $srcH/$fsize;
        else $reduction = $srcW/$fsize;
        $desW = $srcW/$reduction;
        $desH = $srcH/$reduction;
        $copy = imagecreatetruecolor($desW, $desH);
        imagecopyresampled($copy,$image,0,0,0,0,$desW, $desH, $srcW, $srcH)
        or die ("Ошибка при копировании изображения.");
        imagedestroy($image);
        $image = $copy;
    }

    header("Content-type: $mimetype");
    switch($imageproperties[2]){
        case IMAGETYPE_JPEG:
            imagejpeg($image,"",75);
            break;
        case IMAGETYPE_GIF:
            imagegif($image);
            break;
        case IMAGETYPE_PNG:
            imagepng($image,"",75);
            break;
        default:
            die ("Не возможно создать изображение.");}
} else die ("Файл: $flname не существует.");

?>