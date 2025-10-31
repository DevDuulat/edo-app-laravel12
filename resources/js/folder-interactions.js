const listBtn = document.getElementById('listViewBtn');
const gridBtn = document.getElementById('gridViewBtn');
const listView = document.getElementById('listView');
const gridView = document.getElementById('gridView');
const container = document.getElementById("foldersContainer");
const dropdown = document.getElementById("dropdown");
const modal = document.getElementById("createDocumentModal");
const closeModal = document.getElementById("closeCreateDocumentModal");
const folderInput = document.getElementById('document_folder_id');

listBtn.addEventListener('click', () => {
    listView.classList.remove('hidden');
    gridView.classList.add('hidden');
});
gridBtn.addEventListener('click', () => {
    listView.classList.add('hidden');
    gridView.classList.remove('hidden');
});

container.addEventListener("mouseup", (e) => {
    const folderEl = e.target.closest("[data-folder-id]");
    if (!folderEl) return;

    const folderId = folderEl.dataset.folderId;

    switch (e.button) {
        case 0:
        case 1:
            dropdown.style.display = "none";
            break;
        case 2:
            e.preventDefault();

            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top + container.scrollTop;

            dropdown.dataset.folderId = folderId;
            dropdown.style.left = `${x}px`;
            dropdown.style.top = `${y}px`;
            dropdown.style.display = "block";
            break;
    }
});


container.addEventListener("contextmenu", (e) => e.preventDefault());

document.addEventListener("click", (e) => {
    if (!dropdown.contains(e.target)) dropdown.style.display = "none";
});

document.getElementById("createDocBtn").addEventListener("click", () => {
    folderInput.value = dropdown.dataset.folderId;
    modal.classList.remove('hidden');
    dropdown.style.display = "none";
});

document.getElementById("renameBtn").addEventListener("click", () => {
    console.log("Переименовываем папку:", dropdown.dataset.folderId);
    dropdown.style.display = "none";
});
document.getElementById("deleteBtn").addEventListener("click", () => {
    console.log("Удаляем папку:", dropdown.dataset.folderId);
    dropdown.style.display = "none";
});

closeModal.addEventListener('click', () => modal.classList.add('hidden'));
modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.add('hidden'); });
document.addEventListener('keydown', (e) => { if(e.key === 'Escape') modal.classList.add('hidden'); });

window.addEventListener("scroll", () => { dropdown.style.display = "none"; });