<x-filament-widgets::widget>
    <div style="height:450px;overflow:hidden;background:#111827;position:relative;border-radius:0.75rem;"
         x-data="{ active: 0, init() { setInterval(() => { this.active = (this.active + 1) % 4; }, 4000); } }">

        @php
        $slides = [
            ['img' => 'jujur.jpeg',  'text' => 'SANTUN'],
            ['img' => 'santun.jpeg', 'text' => 'JUJUR'],
            ['img' => 'taat.jpeg',   'text' => 'TAAT'],
            ['img' => 'sajuta.jpeg', 'text' => 'SAJUTA'],
        ];
        @endphp

        @foreach($slides as $i => $slide)
        <div style="position:absolute;inset:0;background:#111827;"
             :class="active === {{ $i }} ? 'slide-in' : 'slide-out'">
            <img src="{{ asset('img/' . $slide['img']) }}" alt="{{ $slide['text'] }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.3);"></div>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                <h2 style="color:white;font-size:clamp(2.5rem,8vw,5rem);font-weight:900;text-transform:uppercase;letter-spacing:0.2em;text-shadow:3px 5px 20px rgba(0,0,0,1);">{{ $slide['text'] }}</h2>
            </div>
        </div>
        @endforeach

        <!-- Indicators -->
        <div style="position:absolute;bottom:1rem;left:0;right:0;display:flex;justify-content:center;gap:0.75rem;z-index:10;">
            @foreach($slides as $i => $slide)
            <button @click="active = {{ $i }}"
                style="width:0.75rem;height:0.75rem;border-radius:50%;border:none;cursor:pointer;transition:all 0.3s;"
                :style="active === {{ $i }} ? 'background:#f59e0b;transform:scale(1.25);' : 'background:rgba(255,255,255,0.5);'">
            </button>
            @endforeach
        </div>
    </div>

    <style>
        .slide-in {
            opacity: 1;
            z-index: 2;
            transition: opacity 0.8s ease;
        }
        .slide-out {
            opacity: 0;
            z-index: 1;
            transition: opacity 0.8s ease;
        }
    </style>
</x-filament-widgets::widget>
