<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Folder;

class DocumentsList extends Component
{
    public $folders;
    public $documents;

    public $selectedFolders = [];
    public $selectedDocuments = [];

    public function mount($folders, $documents)
    {
        $this->folders = $folders;
        $this->documents = $documents;
    }

    public function toggleSelectAll()
    {
        $totalItems = $this->folders->pluck('id')->merge($this->documents->pluck('id'))->toArray();
        $allSelected = count($this->selectedFolders) + count($this->selectedDocuments) === count($totalItems);

        $this->selectedFolders = $allSelected ? [] : $this->folders->pluck('id')->toArray();
        $this->selectedDocuments = $allSelected ? [] : $this->documents->pluck('id')->toArray();

        $this->emitSelectionUpdated();
    }

    public function archiveFolder(Folder $folder)
    {
        $folder->markArchived();
        $this->folders = $this->folders->filter(fn($f) => $f->id !== $folder->id);
        $this->selectedFolders = array_diff($this->selectedFolders, [$folder->id]);

        $this->emitSelectionUpdated();
    }

    public function deleteFolder(Folder $folder)
    {
        $folder->markTrashed();
        $this->folders = $this->folders->filter(fn($f) => $f->id !== $folder->id);
        $this->selectedFolders = array_diff($this->selectedFolders, [$folder->id]);

        $this->emitSelectionUpdated();
    }

    private function emitSelectionUpdated()
    {
        $this->emit('selectionUpdated', [
            'folders' => $this->selectedFolders,
            'documents' => $this->selectedDocuments,
        ]);
    }

    public function render()
    {
        return view('livewire.documents-list');
    }
}
