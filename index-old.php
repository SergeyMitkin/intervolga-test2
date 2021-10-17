<?php
// Увеличиваем оперативную память и время работы скрипта для работы с изображением
ini_set('memory_limit', '6000M');
ini_set('max_execution_time', 200);

// Путь доизображения
$path="images/wood.png";

// Размеры уменьшенного изображения
$width=200;
$height=100;

// Функция изменения размера
resizeimg($path, $width, $height);

// выводим картинку на экран
?>

<img src="small.png">

<?

function resizeimg($filename, $width, $height)
{
    // Определим коэффициент сжатия изображения
    $ratio = $width/$height;

    // Создадим пустое изображение по заданным размерам
    $dest_img = imagecreatetruecolor($width, $height);
    // зальём его белым цветом
    imagefill($dest_img, 0, 0, 0xFFFFFF);

    // получим размеры исходного изображения
    $size_img = getimagesize($filename);
    // получим коэффициент сжатия исходного изображения
    $src_ratio=$size_img[0]/$size_img[1];

    // здесь вычисляем размеры, чтобы при масштабировании сохранились
    // 1. Пропорции исходного изображения
    // 2. Исходное изображение полностью помещалось на маленькой копии
    // (не обрезалось)
    if ($src_ratio>$ratio)
    {
        $old_h=$size_img[1];
        $size_img[1]=floor($size_img[0]/$ratio);
        $old_h=floor($old_h*$height/$size_img[1]);
    }
    else
    {
        $old_w=$size_img[0];
        $size_img[0]=floor($size_img[1]*$ratio);
        $old_w=floor($old_w*$width/$size_img[0]);
    }

    // исходя из того какой тип имеет изображение
    // выбираем функцию создания

    $src_img = imagecreatefrompng($filename);

    //$ext="png";
    /*
    switch ($size_img['mime'])
    {
        // если тип файла JPEG
        case 'image/jpeg':
            // создаем jpeg из файла
            $src_img = imagecreatefromjpeg($filename);
            $ext="jpg";
            break;

        // если тип файла JPEG
        case 'image/png':
            // создаем jpeg из файла
            $src_img = imagecreatefrompng($filename);
            $ext="png";
            break;
        // если тип файла GIF
        case 'image/gif':
            // создаем gif из файла
            $src_img = imagecreatefromgif($filename);
            $ext="gif";
            break;
    }
    */
    // масштабируем изображение    функцией imagecopyresampled()
    // $dest_img - уменьшенная копия
    // $src_img - исходное изображение
    // $w - ширина уменьшенной копии
    // $h - высота уменьшенной копии
    // $size_img[0] - ширина исходного изображения
    // $size_img[1] - высота исходного изображения
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $size_img[0], $size_img[1]);

    imagepng($dest_img, "small.png");
    // в зависимости от типа файла выбирвем функцию сохранения в файл
    /*
    switch ($size_img['mime'])
    {
        case 'image/jpeg':
            // сохраняем в файл small.jpg
            imagejpeg($dest_img, "small.$ext");
            break;

        case 'image/png':
            // сохраняем в файл small.jpg
            imagepng($dest_img, "small.$ext");
            break;
        case 'image/gif':
            // сохраняем в файл small.gif
            imagegif($dest_img, "small.$ext");
            break;
    }
    */

    // чистим память от созданных изображений
    imagedestroy($dest_img);
    imagedestroy($src_img);
}
?>