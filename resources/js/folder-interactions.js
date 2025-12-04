function initFolders() {
    const listBtn = document.getElementById('listViewBtn')
    const gridBtn = document.getElementById('gridViewBtn')
    const listView = document.getElementById('listView')
    const gridView = document.getElementById('gridView')
    const container = document.getElementById('foldersContainer')
    const dropdown = document.getElementById('dropdown')
    const modal = document.getElementById('createDocumentModal')
    const closeModal = document.getElementById('closeCreateDocumentModal')
    const folderInput = document.getElementById('document_folder_id')
    const createDocBtn = document.getElementById('createDocBtn')
    const renameBtn = document.getElementById('renameBtn')
    const deleteBtn = document.getElementById('deleteBtn')

    if (
        !listBtn || !gridBtn || !listView || !gridView ||
        !container || !dropdown || !modal || !closeModal ||
        !folderInput || !createDocBtn || !renameBtn || !deleteBtn
    ) return

    listBtn.onclick = () => {
        listView.classList.remove('hidden')
        gridView.classList.add('hidden')
    }

    gridBtn.onclick = () => {
        listView.classList.add('hidden')
        gridView.classList.remove('hidden')
    }

    container.onmouseup = e => {
        const folderEl = e.target.closest('[data-folder-id]')
        if (!folderEl) return
        const folderId = folderEl.dataset.folderId
        switch (e.button) {
            case 0:
            case 1:
                dropdown.style.display = 'none'
                break
            case 2:
                e.preventDefault()
                const rect = container.getBoundingClientRect()
                const x = e.clientX - rect.left
                const y = e.clientY - rect.top + container.scrollTop
                dropdown.dataset.folderId = folderId
                dropdown.style.left = `${x}px`
                dropdown.style.top = `${y}px`
                dropdown.style.display = 'block'
                break
        }
    }

    container.oncontextmenu = e => e.preventDefault()

    document.onclick = e => {
        if (!dropdown.contains(e.target)) dropdown.style.display = 'none'
    }

    createDocBtn.onclick = () => {
        folderInput.value = dropdown.dataset.folderId
        modal.classList.remove('hidden')
        dropdown.style.display = 'none'
    }

    renameBtn.onclick = () => {
        console.log('rename', dropdown.dataset.folderId)
        dropdown.style.display = 'none'
    }

    deleteBtn.onclick = () => {
        console.log('delete', dropdown.dataset.folderId)
        dropdown.style.display = 'none'
    }

    closeModal.onclick = () => modal.classList.add('hidden')

    modal.onclick = e => {
        if (e.target === modal) modal.classList.add('hidden')
    }

    document.onkeydown = e => {
        if (e.key === 'Escape') modal.classList.add('hidden')
    }

    window.onscroll = () => dropdown.style.display = 'none'
}

document.addEventListener('DOMContentLoaded', initFolders)
document.addEventListener('livewire:navigated', initFolders)
