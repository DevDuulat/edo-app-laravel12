@props(['file', 'canDelete' => false])

@php
    use Illuminate\Support\Str;

    $url = asset('storage/' . $file->file_url);
    $name = $file->file_name ?? basename($file->file_url);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']);
@endphp

<a href="{{ $url }}"
   @if($isImage)
       data-pswp-width="1600"
       data-pswp-height="1200"
       data-cropped="true"
       data-caption="{{ $name }}"
   @endif
   target="_blank"
   class="group relative w-24 h-24 border border-zinc-200 dark:border-zinc-700
          rounded-xl overflow-hidden bg-white dark:bg-zinc-900
          shadow-sm hover:shadow-md transition-all duration-200
          flex flex-col items-center justify-center cursor-pointer">

    @if($isImage)
        <img src="{{ $url }}" alt="{{ $name }}"
             class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200" />
    @else
        <div class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300">
            @switch($ext)
                @case('pdf')
                    <x-pdf-file-text class="w-8 h-8 text-red-500 group-hover:scale-110 transition-transform duration-200" />
                    @break
                @case('doc')
                @case('docx')
                    <x-doc-file-text class="w-8 h-8 text-blue-500 group-hover:scale-110 transition-transform duration-200" />
                    @break
                @case('xls')
                @case('xlsx')
                    <x-xls-file-text class="w-8 h-8 text-green-500 group-hover:scale-110 transition-transform duration-200" />
                    @break
                @default
                    <x-file class="w-8 h-8 text-gray-500 group-hover:scale-110 transition-transform duration-200" />
            @endswitch

            <span class="text-[10px] text-center truncate w-full px-1 text-gray-500 dark:text-gray-400"
                  title="{{ $name }}">
                {{ Str::limit($name, 15) }}
            </span>
        </div>
    @endif

    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0
                group-hover:opacity-100 transition-opacity duration-200">
        <div class="flex flex-col items-center gap-1 text-white">
            <x-open-icon/>
            <span class="text-[11px] font-medium">Открыть</span>
        </div>
    </div>

        @if($canDelete)
            <div class="absolute top-1 right-1 z-10">
                <input type="checkbox"
                       name="files_to_delete[]"
                       value="{{ $file->id }}"
                       onclick="event.stopPropagation();"
                       class="rounded text-red-600 shadow-sm focus:ring-red-500
                      dark:bg-zinc-800 dark:border-zinc-700"/>
            </div>
        @endif

</a>
