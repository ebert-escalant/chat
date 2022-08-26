@props(['type'=>'','title'=>''])

@php
    switch ($type) {
        case 'success':
            $color="bg-emerald-500";
            $textcolor="text-emerald-500";
            $darkcolor="textemerald-400";
            break;
        case 'info':
            $color="bg-blue-500";
            $textcolor="text-blue-500";
            $darkcolor="text-blue-400";
            break;
        case 'danger':
            $color="bg-red-500";
            $textcolor="text-dark-500";
            $darkcolor="text-dark-400";
            break;
        case 'warning' :
            $color="bg-yellow-400";
            $textcolor="text-yellow-400";
            $darkcolor="text-yellow-300";
            break;
        default:
            $color="bg-white";
            $textcolor="text-dark";
            $darkcolor="text-dark";
            break;
    }
@endphp

<div class="flex w-full {{-- max-w-sm --}} mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
    <div class="flex items-center justify-center w-12 {{ $color }}">
        @if ($type=='success')
                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"></path>
                </svg>
            @elseif ($type=='info')
                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            @elseif ($type=='danger')
                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                    <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                </svg>
            @elseif ($type=='warning')
                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            @endif
    </div>
    
    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-bold {{ $textcolor }} dark:{{ $darkcolor }}">{{ $title }}</span>
            <p class="text-sm text-gray-600 dark:text-gray-200">{{ $slot }}</p>
        </div>
    </div>
</div>