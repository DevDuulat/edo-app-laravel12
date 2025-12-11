const ACTIVE_CLASSES = 'bg-white text-gray-900 shadow-sm dark:bg-zinc-800 dark:text-gray-100 dark:hover:bg-zinc-700';
const INACTIVE_CLASSES = 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-zinc-600';
const VIEW_STORAGE_KEY = 'foldersView';

function setActiveButton(activeBtn, inactiveBtn) {

    inactiveBtn.classList.remove(...ACTIVE_CLASSES.split(' '));
    inactiveBtn.classList.add(...INACTIVE_CLASSES.split(' '));

    activeBtn.classList.remove(...INACTIVE_CLASSES.split(' '));
    activeBtn.classList.add(...ACTIVE_CLASSES.split(' '));
}

function showView(viewToShow, viewToHide, activeBtn, inactiveBtn) {
    viewToHide.classList.add('hidden');
    viewToShow.classList.remove('hidden');

    setActiveButton(activeBtn, inactiveBtn);

    localStorage.setItem(VIEW_STORAGE_KEY, viewToShow.id === 'gridView' ? 'grid' : 'list');
}

function initFoldersView() {
    const listBtn = document.getElementById('listViewBtn');
    const gridBtn = document.getElementById('gridViewBtn');
    const listView = document.getElementById('listView');
    const gridView = document.getElementById('gridView');

    if (!listBtn || !gridBtn || !listView || !gridView) return;

    const savedView = localStorage.getItem(VIEW_STORAGE_KEY);

    if (savedView === 'list') {
        showView(listView, gridView, listBtn, gridBtn);
    } else if (savedView === 'grid' || savedView === null) {
        showView(gridView, listView, gridBtn, listBtn);
    }

    listBtn.onclick = (e) => {
        e.preventDefault();
        showView(listView, gridView, listBtn, gridBtn);
    };

    gridBtn.onclick = (e) => {
        e.preventDefault();
        showView(gridView, listView, gridBtn, listBtn);
    };
}

function initAll() {
    initFoldersView();
}

document.addEventListener('DOMContentLoaded', initAll);
document.addEventListener('livewire:navigated', initAll);