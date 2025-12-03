function documentForm(templates = []) {
    return {
        templates,
        selectedTemplate: '',
        editorContent: '',

        applyTemplateContent() {
            const selected = this.templates.find(t => t.id == this.selectedTemplate);
            if (selected) {
                this.editorContent = selected.content || '';
                const editor = document.getElementById('wysiwyg-example');
                if (editor) editor.innerHTML = this.editorContent;
            }
        }
    };
}