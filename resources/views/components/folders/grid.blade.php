@props(['folders', 'documents'])

<div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    @foreach($folders as $folder)
        <x-folders.card :folder="$folder" />
    @endforeach

    @foreach($documents as $document)
            <x-document.card :document="$document" />
    @endforeach
</div>
