<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrController extends Controller
{
    public function index()
    {
        // Возвращаем Blade-шаблон из resources/views/ocr.blade.php
        return view('ocr');
    }

    public function process(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // до 10MB
        ]);

        $uploadedFile = $request->file('image');
        $imagePath = $uploadedFile->getRealPath();

        try {
            // === OCR на русском + английском ===
            $text = (new TesseractOCR($imagePath))
                ->lang('rus+eng')
                ->run();

            // === OCR MRZ (латиница, цифры, <) ===
            $mrz = (new TesseractOCR($imagePath))
                ->lang('eng')
                ->allowlist(range('A', 'Z'), range('0', '9'), '<')
                ->run();

            // === Очистка текста от шумов ===
            $cleanText = preg_replace('/\s+/', ' ', $text);
            $cleanMrz = preg_replace('/\s+/', '', $mrz);

            // === Поиск ИНН (10 или 12 цифр — для физ./юр. лиц) ===
            preg_match('/\b\d{10,12}\b/', $cleanText, $innMatch);
            $inn = $innMatch[0] ?? null;

            // === Поиск ID документа (2 буквы + 7 цифр, пример: AB1234567) ===
            preg_match('/\b[A-Z]{2}\d{7}\b/', $cleanMrz . $cleanText, $idMatch);
            $docId = $idMatch[0] ?? null;

            // === Поиск ФИО (если есть стандартные поля) ===
            $fio = null;
            if (preg_match('/Фамилия[:\s]*([А-ЯЁA-Z][а-яёa-z]+)/u', $cleanText, $lastName) &&
                preg_match('/Имя[:\s]*([А-ЯЁA-Z][а-яёa-z]+)/u', $cleanText, $firstName)) {
                $fio = trim(($lastName[1] ?? '') . ' ' . ($firstName[1] ?? ''));
                if (preg_match('/Отчество[:\s]*([А-ЯЁA-Z][а-яёa-z]+)/u', $cleanText, $middleName)) {
                    $fio .= ' ' . $middleName[1];
                }
            }

            // === Результат ===
            return response()->json([
                'success' => true,
                'text' => $cleanText,
                'mrz' => $cleanMrz,
                'fio' => $fio,
                'inn' => $inn,
                'docId' => $docId,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
