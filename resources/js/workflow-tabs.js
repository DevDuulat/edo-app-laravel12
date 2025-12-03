export function workflowTabs() {
    return {
        tabs: [
            { id: 'overview', label: 'Обзор' },
            { id: 'users', label: 'Пользователи' },
            { id: 'files', label: 'Файлы' },
            { id: 'comments', label: 'Комментарии' },
            { id: 'history', label: 'История' },
        ],
        active: 'overview',

        init() {
            const hash = window.location.hash?.substring(1);
            const saved = localStorage.getItem('workflow-active-tab');
            this.active = this.tabs.some(t => t.id === (hash || saved)) ? (hash || saved) : 'overview';
            this.updateUrl();

            window.addEventListener('workflow:refresh', () => {
                this.refreshActiveTab();
            });

            window.addEventListener('comment-added', () => {
                if (this.active === 'comments') this.scrollToBottom();
            });
        },

        selectTab(id) {
            this.active = id;
            localStorage.setItem('workflow-active-tab', id);
            this.updateUrl();
            if (id === 'comments') this.scrollToBottom();
        },

        tabClasses(id) {
            return this.active === id
                ? 'text-blue-600 border-blue-600 hover:text-blue-700 hover:border-blue-700'
                : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300';
        },

        updateUrl() {
            window.history.replaceState(null, '', '#' + this.active);
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = document.getElementById('commentsContainer');
                if (container) container.scrollTop = container.scrollHeight;
            });
        },

        refreshActiveTab() {
            if (this.active === 'comments') {
                this.scrollToBottom();
            }
            Livewire.emit('refresh-' + this.active);
        }
    }
}
