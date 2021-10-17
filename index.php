<?php

ini_set('memory_limit', '6000M');
ini_set('max_execution_time', 200);

$path = 'images/wood.png';

$width=200;
$height=100;

createImage($path, $width, $height);
?>

<img src="small.png">

<?php

function createImage($path, $width, $height){

    $image_size = getimagesize($path); // Размеры исходного изображения
    $src_img = imagecreatefrompng($path);

    // Создаём пустое изображение для аватарки
    $image = imagecreatetruecolor($width, $height);

    // Создаём фон изображения
    $background = imagecolorallocate($image, 0, 0, 0);

    // Делаем фон прозрачным
    imagecolortransparent($image, $background);

    $src_aspect = $image_size[0]/$image_size[1]; // Отношение ширины к высоте исходного изображения
    $thumb_aspect = $width/$height; // Отношение ширины к высоте аватарки

    // Широкий вариант (фиксированная высота)
    if($src_aspect < $thumb_aspect) {

        $src_width = $image_size[0]*$thumb_aspect;
        $src_height = $image_size[1];

        $width_ratio = $thumb_aspect/$src_aspect;

        // Располагаем ресурс исходника в ресурсе аватарки по центру
        $dst_y = 0;
        $dst_x = ($width / $width_ratio) / 2;
        $src_x = 0;
        $src_y = 0;

        // Помещаем исходное изображение в ресурс для аватарки
        imagecopyresampled($image, $src_img, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $src_width, $src_height);

    }
    // Узкий вариант (фиксированная ширина)
    else if ($src_aspect > $thumb_aspect) {

        $scale = $height / $image_size[1];
        $new_size = array($height * $src_aspect, $height);
        $src_pos = array(($image_size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
    }
    // Другое
    else {
        $new_size = array($width, $height);
        $src_pos = array(0,0);
    }

    // Выводим аватарку
    imagepng($image, "small.png");

    // Чистим память от созданных изображений
    imagedestroy($image);
    imagedestroy($src_img);
}