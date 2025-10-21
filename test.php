<?php
require 'vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

$imagePath = __DIR__ . '/storage/app/public/passport.png';

$text = (new TesseractOCR($imagePath))
    ->executable('/usr/bin/tesseract') // проверь путь к бинарнику tesseract
    ->lang('rus+eng')
    ->run();

echo $text;

