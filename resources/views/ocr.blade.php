<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>OCR Laravel — INN и ID</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<h2>Загрузите паспорт для OCR</h2>

<input type="file" id="imageInput" accept="image/*">
<button id="uploadBtn">Распознать</button>
<p id="status">Выберите изображение</p>

<h3>Результат</h3>
<pre id="result"></pre>
<pre id="fio"></pre>
<pre id="inn"></pre>
<pre id="docId"></pre>

<script>
    document.getElementById('uploadBtn').addEventListener('click', async () => {
        const fileInput = document.getElementById('imageInput');
        const file = fileInput.files[0];
        const statusEl = document.getElementById('status');
        const resultEl = document.getElementById('result');
        const innEl = document.getElementById('inn');
        const docIdEl = document.getElementById('docId');

        if (!file) {
            statusEl.textContent = '❗ Пожалуйста, выберите изображение.';
            return;
        }

        statusEl.textContent = '⏳ Отправка на сервер...';
        resultEl.textContent = '';
        innEl.textContent = '';
        docIdEl.textContent = '';

        const formData = new FormData();
        formData.append('image', file);

        try {
            const res = await axios.post("{{ route('ocr.process') }}", formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            const data = res.data;

            if (data.success) {
                statusEl.textContent = '✅ Готово';
                resultEl.textContent = data.text || 'Текст не распознан';
                document.getElementById('fio').textContent = data.fio || 'ФИО не найдено';
                innEl.textContent = data.inn || 'ИНН не найден';
                docIdEl.textContent = data.docId || 'ID документа не найден';
            } else {
                statusEl.textContent = '❌ Ошибка OCR';
                resultEl.textContent = data.error || 'Не удалось распознать изображение';
            }

        } catch (err) {
            console.error(err);
            statusEl.textContent = '⚠️ Ошибка запроса';
            resultEl.textContent = err.message;
        }
    });
</script>
</body>
</html>
