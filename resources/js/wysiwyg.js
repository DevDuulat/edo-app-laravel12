document.addEventListener('DOMContentLoaded', function () {
    const editor = document.getElementById('wysiwyg-example');

    const commands = {
        toggleBoldButton: 'bold',
        toggleItalicButton: 'italic',
        toggleUnderlineButton: 'underline',
        toggleStrikeButton: 'strikeThrough',
        toggleLeftAlignButton: 'justifyLeft',
        toggleCenterAlignButton: 'justifyCenter',
        toggleRightAlignButton: 'justifyRight',
        toggleListButton: 'insertUnorderedList',
        toggleOrderedListButton: 'insertOrderedList'
    };

    Object.keys(commands).forEach(id => {
        const btn = document.getElementById(id);
        if (btn) {
            btn.addEventListener('click', () => {
                document.execCommand(commands[id], false, null);
                editor.focus();
            });
        }
    });

    if (editor) {
        editor.addEventListener('input', () => {
            const hiddenInput = document.querySelector('input[name="content"]');
            if (hiddenInput) hiddenInput.value = editor.innerHTML;
        });
    }
});
