import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
import Highlight from 'https://esm.sh/@tiptap/extension-highlight@2.6.6';
import Underline from 'https://esm.sh/@tiptap/extension-underline@2.6.6';
import Link from 'https://esm.sh/@tiptap/extension-link@2.6.6';
import TextAlign from 'https://esm.sh/@tiptap/extension-text-align@2.6.6';
import Image from 'https://esm.sh/@tiptap/extension-image@2.6.6';

export function initDocumentTemplatesEditor() {
    let editor;

    try {
        const initialContent = window.editorContent || '<p>Начните вводить текст здесь...</p>';

        editor = new Editor({
            element: document.querySelector('#wysiwyg-example'),
            extensions: [
                StarterKit,
                Highlight,
                Underline,
                Link.configure({
                    openOnClick: false,
                    autolink: true,
                    defaultProtocol: 'https',
                }),
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                Image,
            ],
            content: initialContent,
            onUpdate: ({ editor }) => {
                const content = editor.getHTML();
                const contentInput = document.getElementById('contentInput');
                if (contentInput) {
                    contentInput.value = content;
                }
            },
            onBlur: ({ editor }) => {
                const content = editor.getHTML();
                const contentInput = document.getElementById('contentInput');
                if (contentInput) {
                    contentInput.value = content;
                }
            }
        });

        console.log('Editor initialized successfully with content:', initialContent);

        const bindButton = (id, command) => {
            const button = document.getElementById(id);
            if (button) {
                button.addEventListener('click', () => editor.chain().focus()[command]().run());
            }
        };

        bindButton('toggleBoldButton', 'toggleBold');
        bindButton('toggleItalicButton', 'toggleItalic');
        bindButton('toggleUnderlineButton', 'toggleUnderline');
        bindButton('toggleStrikeButton', 'toggleStrike');
        bindButton('toggleListButton', 'toggleBulletList');
        bindButton('toggleOrderedListButton', 'toggleOrderedList');

        document.getElementById('toggleLeftAlignButton')?.addEventListener('click', () =>
            editor.chain().focus().setTextAlign('left').run()
        );
        document.getElementById('toggleCenterAlignButton')?.addEventListener('click', () =>
            editor.chain().focus().setTextAlign('center').run()
        );
        document.getElementById('toggleRightAlignButton')?.addEventListener('click', () =>
            editor.chain().focus().setTextAlign('right').run()
        );

        document.getElementById('addImageButton')?.addEventListener('click', () => {
            const url = window.prompt('Введите URL изображения:');
            if (url) {
                editor.chain().focus().setImage({ src: url }).run();
            }
        });

        document.getElementById('toggleLinkButton')?.addEventListener('click', () => {
            const previousUrl = editor.getAttributes('link').href;
            const url = window.prompt('Введите URL:', previousUrl);

            if (url === null) {
                return;
            }

            if (url === '') {
                editor.chain().focus().unsetLink().run();
                return;
            }

            editor.chain().focus().setLink({ href: url }).run();
        });

    } catch (error) {
        console.error('Error initializing editor:', error);
        const editorElement = document.querySelector('#wysiwyg-example');
        const contentInput = document.getElementById('contentInput');

        if (editorElement && contentInput) {
            const initialContent = window.editorContent || '<p>Начните вводить текст здесь...</p>';
            editorElement.innerHTML = initialContent;
            editorElement.setAttribute('contenteditable', 'true');
            editorElement.classList.add('prose', 'max-w-none');

            editorElement.addEventListener('input', function() {
                contentInput.value = this.innerHTML;
            });
        }
    }

    const form = document.getElementById('templateForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (editor) {
                const content = editor.getHTML();
                const contentInput = document.getElementById('contentInput');
                if (contentInput) {
                    contentInput.value = content;
                }
            }
        });
    }

    return editor;
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('#wysiwyg-example')) {
        initDocumentTemplatesEditor();
    }
});