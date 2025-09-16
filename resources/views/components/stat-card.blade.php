@props([
    'title' => '',
    'sub_title' => '',
    'value' => '',
    'icon' => '',
    'color'=>'blue'
])

<div {{ $attributes->merge(['class' => ' rounded-2xl shadow-sm  p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-800']) }}>
    <div class="flex items-center">
          @if ($icon)
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-blue-500 text-white dark:bg-gray-800 dark:text-green-500 rounded-xl  flex items-center justify-center">
                <i data-lucide="{{ $icon }}" class="w-5 h-5 dark:w-8 dark:h-8"></i>
            </div>             
        </div>
        @endif
        <div class="ml-4">
                  {{-- Only display if value is provided --}}
            @if ($value)
                <p class="text-2xl font-bold ">{{ $value }}</p>
            @endif

            {{-- Only display if title is provided --}}
            @if ($title)
                <h3 class="text-1xl font-semibold ">{{ $title }}</h3>
                
            @endif
      
            {{-- Only display if sub_title is provided --}}
            @if ($sub_title)
                <p class="text-sm text-muted ">{{ $sub_title }}</p>
            @endif
        </div>
    </div>


</div>
