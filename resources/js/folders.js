// resources/js/folders.js

// === Переключение между списком и сеткой ===
document.addEventListener('DOMContentLoaded', () => {
    const listBtn = document.getElementById('listViewBtn');
    const gridBtn = document.getElementById('gridViewBtn');
    const listView = document.getElementById('listView');
    const gridView = document.getElementById('gridView');

    if (listBtn && gridBtn && listView && gridView) {
        listBtn.addEventListener('click', () => {
            listView.classList.remove('hidden');
            gridView.classList.add('hidden');
        });

        gridBtn.addEventListener('click', () => {
            listView.classList.add('hidden');
            gridView.classList.remove('hidden');
        });
    }
});

// === Мультиселект пользователей (AlpineJS совместимый) ===
window.userMultiSelect = function(initialUsers) {
    return {
        open: false,
        users: initialUsers || [],
        selected: [],
        search: '',

        get filteredUsers() {
            if (this.search.trim() === '') return this.users;
            return this.users.filter(u =>
                u.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        toggleUser(user) {
            const exists = this.selected.some(u => u.id === user.id);
            if (exists) {
                this.selected = this.selected.filter(u => u.id !== user.id);
            } else {
                this.selected.push(user);
            }
        },

        removeUser(user) {
            this.selected = this.selected.filter(u => u.id !== user.id);
        }
    };
};
