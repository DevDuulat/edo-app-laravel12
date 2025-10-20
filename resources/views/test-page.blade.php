<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>OCR — INN и ID документа</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 900px; }
        pre { background:#f6f6f6; padding:10px; white-space:pre-wrap; }
        .row { display:flex; gap:10px; align-items:flex-start; margin-top:10px; }
        button { padding:6px 10px; border-radius:6px; border:1px solid #ccc; background:#fff; cursor:pointer; }
        #innResult, #docIdResult { font-weight:600; font-size:1.1rem; }
    </style>
</head>
<body>
<h2>Извлечение INN (14 цифр) и ID документа (2 буквы + 7 цифр) из паспорта</h2>

<input type="file" id="imageInput" accept="image/*">
<p id="status">Выберите изображение паспорта</p>

<div class="row">
    <div style="flex:1">
        <h3>OCR текст</h3>
        <pre id="result"></pre>
    </div>
    <div style="width:320px">
        <h3>Найденный INN (14 цифр)</h3>
        <pre id="innResult">—</pre>
        <h3>ID документа (2 буквы + 7 цифр)</h3>
        <pre id="docIdResult">—</pre>
        <div style="margin-top:8px;">
            <button id="copyInnBtn" disabled>Скопировать INN</button>
            <button id="copyIdBtn" disabled>Скопировать ID документа</button>
            <button id="clearBtn">Очистить</button>
        </div>
        <p style="font-size:0.9rem; color:#555; margin-top:8px;">
            INN: ровно 14 слитных цифр.<br>
            ID документа: 2 буквы + 7 цифр (например AB1234567), обычно после штрих-кода.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.2/dist/tesseract.min.js"></script>
<script>
    document.getElementById('imageInput').addEventListener('change', async (e) => {
        const file = e.target.files[0];
        const statusEl = document.getElementById('status');
        const resultEl = document.getElementById('result');
        const innEl = document.getElementById('innResult');
        const docIdEl = document.getElementById('docIdResult');
        const copyInnBtn = document.getElementById('copyInnBtn');
        const copyIdBtn = document.getElementById('copyIdBtn');

        innEl.textContent = '—';
        docIdEl.textContent = '—';
        resultEl.textContent = '';
        copyInnBtn.disabled = true;
        copyIdBtn.disabled = true;

        if (!file) {
            statusEl.textContent = 'Файл не выбран';
            return;
        }

        statusEl.textContent = 'Распознавание...';
        try {
            const { data: { text } } = await Tesseract.recognize(
                file,
                'rus+kir+eng',
                { logger: info => console.log(info) }
            );

            statusEl.textContent = 'OCR завершён';
            resultEl.textContent = text || '';

            // ==== INN ====
            const exact14Pattern = /\d{14}/g;
            const labelsINN = [
                'Жеке номер','Жеке нөмөр','Жеке №','ИНН','INN','Жеке номер:','Жеке нөмөр:','Жеке №:',
                'Персональный номер','Personal number','Personal Number','Персональный №'
            ];

            let foundINN = null;
            const textLower = text.toLowerCase();
            for (const label of labelsINN) {
                const idx = textLower.indexOf(label.toLowerCase());
                if (idx !== -1) {
                    const snippet = text.substring(idx, Math.min(text.length, idx + label.length + 80));
                    const m = snippet.match(exact14Pattern);
                    if (m && m.length > 0) { foundINN = m[0]; break; }
                }
            }
            if (!foundINN) {
                const all = text.match(exact14Pattern);
                if (all && all.length > 0) { foundINN = all[0]; }
            }
            if (foundINN) {
                innEl.textContent = foundINN;
                copyInnBtn.disabled = false;
            } else {
                innEl.textContent = 'Не найдено: ровно 14 цифр';
            }

            // ==== ID документа ====
            // Формат: 2 буквы + 7 цифр, ищем после штрих-кода
            // Предполагаем, что штрих-код — это длинная последовательность цифр (может быть найдено OCR как "||| ||||" и т.п.)
            // Простейший вариант: ищем первый паттерн 2буквы+7цифр после последовательности цифр ≥ 10
            const digitsLongPattern = /\d{10,}/g;
            const idPattern = /[A-Z]{2}\d{7}/g; // строго 2 буквы заглавные + 7 цифр

            let foundID = null;

            // ищем все длинные цифровые последовательности (штрих-код)
            const barcodeMatches = text.match(digitsLongPattern) || [];
            if (barcodeMatches.length > 0) {
                // Берём позицию конца последнего штрих-кода
                const lastBarcode = barcodeMatches[barcodeMatches.length-1];
                const idx = text.indexOf(lastBarcode) + lastBarcode.length;
                // Берём кусок текста после штрих-кода
                const snippet = text.substring(idx, idx + 100); // берем 100 символов после штрих-кода
                const idMatches = snippet.match(idPattern);
                if (idMatches && idMatches.length>0) { foundID = idMatches[0]; }
            }

            // Если не нашли после штрих-кода, ищем по всему тексту (резерв)
            if (!foundID) {
                const allID = text.match(idPattern);
                if (allID && allID.length>0) { foundID = allID[0]; }
            }

            if (foundID) {
                docIdEl.textContent = foundID;
                copyIdBtn.disabled = false;
            } else {
                docIdEl.textContent = 'Не найдено (2 буквы + 7 цифр)';
            }

            statusEl.textContent = 'Готово ✅';

        } catch (err) {
            console.error(err);
            statusEl.textContent = 'Ошибка распознавания';
            resultEl.textContent = String(err);
        }
    });

    // ==== Копирование ====
    document.getElementById('copyInnBtn').addEventListener('click', () => {
        const val = document.getElementById('innResult').textContent;
        if (!val || val.includes('Не найдено') || val === '—') return;
        navigator.clipboard.writeText(val).then(() => alert('INN скопирован'));
    });

    document.getElementById('copyIdBtn').addEventListener('click', () => {
        const val = document.getElementById('docIdResult').textContent;
        if (!val || val.includes('Не найдено') || val === '—') return;
        navigator.clipboard.writeText(val).then(() => alert('ID документа скопирован'));
    });

    document.getElementById('clearBtn').addEventListener('click', () => {
        document.getElementById('result').textContent = '';
        document.getElementById('innResult').textContent = '—';
        document.getElementById('docIdResult').textContent = '—';
        document.getElementById('status').textContent = 'Выберите изображение паспорта';
        document.getElementById('copyInnBtn').disabled = true;
        document.getElementById('copyIdBtn').disabled = true;
        document.getElementById('imageInput').value = '';
    });
</script>
</body>
</html>
