<?php

/* Функция для созданияуменьшенной копии изображения */
function createThumb($path, $width, $height){

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

    // Масштабируем ресурс исходника с помощью imagecopyresampled()
    // Широкий вариант (фиксированная высота)
    if($src_aspect < $thumb_aspect){
        $src_width = $image_size[0]*$thumb_aspect; // Изменяем ширину ресурса исходника в соответсвии с шириной ресурса аватарки
        $src_height = $image_size[1];

        // Располагаем ресурс исходника в ресурсе аватарки по центру
        $width_ratio = $thumb_aspect/$src_aspect;
        $dst_y = 0;
        $dst_x = ($width / $width_ratio) / 2;
        $src_x = 0;
        $src_y = 0;

        imagecopyresampled($image, $src_img, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $src_width, $src_height);
    }
    // Узкий вариант (фиксированная ширина)
    else if ($src_aspect > $thumb_aspect){

        $src_width = $image_size[0];
        $src_height = $image_size[1]*$thumb_aspect; // Изменяем высоту ресурса исходника в соответсвии с высотой ресурса аватарки

        // Располагаем ресурс исходника в ресурсе аватарки по центру
        $height_ratio = $thumb_aspect/$src_aspect;
        $dst_y = ($height / $height_ratio) / 2;
        $dst_x = 0;
        $src_x = 0;
        $src_y = 0;

        imagecopyresampled($image, $src_img, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $src_width, $src_height);
    }
    // При равном отношении ширины и высоты
    else if ($src_aspect = $thumb_aspect){
        $src_width = $image_size[0];
        $src_height = $image_size[1];

        // Располагаем ресурс исходника в ресурсе аватарки
        $dst_y = 0;
        $dst_x = 0;
        $src_x = 0;
        $src_y = 0;

        imagecopyresampled($image, $src_img, $dst_x, $dst_y, $src_x, $src_y, $width, $height, $src_width, $src_height);
    }

    // Сохраняем файл с аватаркой
    imagepng($image, "images/thumbs/image.png");

    // Чистим память от созданных изображений
    imagedestroy($image);
    imagedestroy($src_img);
}