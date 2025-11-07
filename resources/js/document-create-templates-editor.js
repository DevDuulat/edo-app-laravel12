import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
import Highlight from 'https://esm.sh/@tiptap/extension-highlight@2.6.6';
import Underline from 'https://esm.sh/@tiptap/extension-underline@2.6.6';
import Link from 'https://esm.sh/@tiptap/extension-link@2.6.6';
import TextAlign from 'https://esm.sh/@tiptap/extension-text-align@2.6.6';
import Image from 'https://esm.sh/@tiptap/extension-image@2.6.6';

document.addEventListener('DOMContentLoaded', function() {
    let editor;

    try {
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
            content: document.querySelector('#contentInput').value || '<p>Начните вводить текст здесь...</p>',
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

        document.getElementById('toggleBoldButton').addEventListener('click', () => editor.chain().focus().toggleBold().run());
        document.getElementById('toggleItalicButton').addEventListener('click', () => editor.chain().focus().toggleItalic().run());
        document.getElementById('toggleUnderlineButton').addEventListener('click', () => editor.chain().focus().toggleUnderline().run());
        document.getElementById('toggleStrikeButton').addEventListener('click', () => editor.chain().focus().toggleStrike().run());
        document.getElementById('toggleLeftAlignButton').addEventListener('click', () => editor.chain().focus().setTextAlign('left').run());
        document.getElementById('toggleCenterAlignButton').addEventListener('click', () => editor.chain().focus().setTextAlign('center').run());
        document.getElementById('toggleRightAlignButton').addEventListener('click', () => editor.chain().focus().setTextAlign('right').run());
        document.getElementById('toggleListButton').addEventListener('click', () => editor.chain().focus().toggleBulletList().run());
        document.getElementById('toggleOrderedListButton').addEventListener('click', () => editor.chain().focus().toggleOrderedList().run());
        document.getElementById('addImageButton').addEventListener('click', () => {
            const url = window.prompt('Введите URL изображения:');
            if (url) {
                editor.chain().focus().setImage({ src: url }).run();
            }
        });
        document.getElementById('toggleLinkButton').addEventListener('click', () => {
            const url = window.prompt('Введите URL:');
            if (url) {
                editor.chain().focus().toggleLink({ href: url }).run();
            }
        });

    } catch (error) {
        console.error('Error initializing editor:', error);
        const editorElement = document.querySelector('#wysiwyg-example');
        const contentInput = document.getElementById('contentInput');
        editorElement.setAttribute('contenteditable', 'true');
        editorElement.classList.add('prose', 'max-w-none');

        editorElement.addEventListener('input', function() {
            contentInput.value = this.innerHTML;
        });
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
});