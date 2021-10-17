<?php

// Увеличиваем оперативную память и время работы скрипта для работы с изображением
ini_set('memory_limit', '6000M');
ini_set('max_execution_time', 200);

// Подключаем модель
require_once ('models/model-image.php');

// Путь до изображения
$filename = 'image.png';
$path = 'images/' . $filename;

// Создаём дирректорию для уменьшенных копий изображений, если её не существует
if (!file_exists('images/thumbs')) {
    mkdir('images/thumbs', 0777, false);
}

// Размеры баннера
$width=200;
$height=100;

// Выводим изображение как баннер
// Если нет сохранённой уменьшенной копии изображения, создаём его
if (!array_search($filename, scandir('images/thumbs'))){
    createThumb($path, $width, $height);
}

// Подключаем шаблон
require_once('templates/index.php');



