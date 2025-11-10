        @php
            $colors = ['red','orange','amber','yellow','lime','green','emerald','teal','cyan','sky','blue','indigo','violet','purple','fuchsia','pink','rose'];
            $colorIndex = crc32($user->name) % count($colors);
            $color = $colors[$colorIndex];
        @endphp
        <flux:avatar name="{{ $user->name }}" color="{{ $color }}" size="10" />