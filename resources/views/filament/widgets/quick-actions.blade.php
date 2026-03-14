<x-filament-widgets::widget>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($this->getActions() as $action)
            <a href="{{ $action['url'] }}" class="flex flex-col p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 rounded-lg bg-{{ $action['color'] }}-100 dark:bg-{{ $action['color'] }}-900/30 text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-400 group-hover:scale-110 transition-transform">
                        @svg($action['icon'], 'w-6 h-6')
                    </div>
                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ $action['label'] }}</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $action['description'] }}</p>
            </a>
        @endforeach
    </div>
</x-filament-widgets::widget>
