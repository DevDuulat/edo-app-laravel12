function initFoldersView() {
    const listBtn = document.getElementById('listViewBtn')
    const gridBtn = document.getElementById('gridViewBtn')
    const listView = document.getElementById('listView')
    const gridView = document.getElementById('gridView')

    if (!listBtn || !gridBtn || !listView || !gridView) return

    listBtn.onclick = () => {
        listView.classList.remove('hidden')
        gridView.classList.add('hidden')
    }

    gridBtn.onclick = () => {
        listView.classList.add('hidden')
        gridView.classList.remove('hidden')
    }
}

function initUserMultiSelect() {
    window.userMultiSelect = function(initialUsers) {
        return {
            open: false,
            users: initialUsers || [],
            selected: [],
            search: '',
            get filteredUsers() {
                if (this.search.trim() === '') return this.users
                return this.users.filter(u =>
                    u.name.toLowerCase().includes(this.search.toLowerCase())
                )
            },
            toggleUser(user) {
                const exists = this.selected.some(u => u.id === user.id)
                this.selected = exists
                    ? this.selected.filter(u => u.id !== user.id)
                    : [...this.selected, user]
            },
            removeUser(user) {
                this.selected = this.selected.filter(u => u.id !== user.id)
            }
        }
    }
}

function initAll() {
    initFoldersView()
    initUserMultiSelect()
}

document.addEventListener('DOMContentLoaded', initAll)
document.addEventListener('livewire:navigated', initAll)
