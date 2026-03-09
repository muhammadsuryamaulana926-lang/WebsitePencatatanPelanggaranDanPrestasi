<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateCustomPages extends Command
{
    protected $signature = 'filament:generate-custom-pages';
    protected $description = 'Generate all custom pages for role-based access';

    public function handle()
    {
        $this->info('Generating custom pages...');

        $pages = $this->getPageDefinitions();

        foreach ($pages as $page) {
            $this->generatePage($page);
        }

        $this->info('All custom pages generated successfully!');
    }

    private function getPageDefinitions()
    {
        return [
            // Guru Pages
            ['role' => 'Guru', 'name' => 'ViewDataSendiri', 'label' => 'View Data Sendiri', 'icon' => 'heroicon-o-eye', 'sort' => 2],
            ['role' => 'Guru', 'name' => 'ExportLaporan', 'label' => 'Export Laporan', 'icon' => 'heroicon-o-arrow-down-tray', 'sort' => 3],
            
            // Wali Kelas Pages
            ['role' => 'WaliKelas', 'name' => 'InputPelanggaran', 'label' => 'Input Pelanggaran', 'icon' => 'heroicon-o-exclamation-triangle', 'sort' => 1],
            ['role' => 'WaliKelas', 'name' => 'ViewDataSendiri', 'label' => 'View Data Sendiri', 'icon' => 'heroicon-o-eye', 'sort' => 2],
            ['role' => 'WaliKelas', 'name' => 'ExportLaporan', 'label' => 'Export Laporan', 'icon' => 'heroicon-o-arrow-down-tray', 'sort' => 3],
            
            // Kesiswaan Pages
            ['role' => 'Kesiswaan', 'name' => 'InputPelanggaran', 'label' => 'Input Pelanggaran', 'icon' => 'heroicon-o-exclamation-triangle', 'sort' => 1],
            ['role' => 'Kesiswaan', 'name' => 'InputPrestasi', 'label' => 'Input Prestasi', 'icon' => 'heroicon-o-trophy', 'sort' => 2],
            ['role' => 'Kesiswaan', 'name' => 'ViewDataSendiri', 'label' => 'View Data Sendiri', 'icon' => 'heroicon-o-eye', 'sort' => 3],
            ['role' => 'Kesiswaan', 'name' => 'ViewDataAnak', 'label' => 'View Data Anak', 'icon' => 'heroicon-o-users', 'sort' => 4],
            
            // BK Pages
            ['role' => 'BK', 'name' => 'ViewDataSendiri', 'label' => 'View Data Sendiri', 'icon' => 'heroicon-o-eye', 'sort' => 2],
            
            // Kepala Sekolah Pages
            ['role' => 'KepalaSekolah', 'name' => 'MonitoringAll', 'label' => 'Monitoring All', 'icon' => 'heroicon-o-chart-bar', 'sort' => 1],
            ['role' => 'KepalaSekolah', 'name' => 'ViewDataSendiri', 'label' => 'View Data Sendiri', 'icon' => 'heroicon-o-eye', 'sort' => 2],
            ['role' => 'KepalaSekolah', 'name' => 'RiwayatPelanggaran', 'label' => 'Riwayat Pelanggaran', 'icon' => 'heroicon-o-clock', 'sort' => 3],
            
            // Orang Tua Pages
            ['role' => 'OrangTua', 'name' => 'ViewDataAnak', 'label' => 'Data Anak', 'icon' => 'heroicon-o-user-group', 'sort' => 1],
        ];
    }

    private function generatePage($page)
    {
        $role = $page['role'];
        $name = $page['name'];
        $label = $page['label'];
        $icon = $page['icon'];
        $sort = $page['sort'];

        $roleFolder = str_replace('_', '-', \Illuminate\Support\Str::kebab($role));
        $viewPath = str_replace('_', '-', \Illuminate\Support\Str::kebab($name));

        $phpContent = $this->getPhpTemplate($role, $name, $label, $icon, $sort, $roleFolder, $viewPath);
        $bladeContent = $this->getBladeTemplate();

        // Create PHP file
        $phpPath = app_path("Filament/Pages/{$role}/{$name}.php");
        File::ensureDirectoryExists(dirname($phpPath));
        File::put($phpPath, $phpContent);

        // Create Blade file
        $bladePath = resource_path("views/filament/pages/{$roleFolder}/{$viewPath}.blade.php");
        File::ensureDirectoryExists(dirname($bladePath));
        File::put($bladePath, $bladeContent);

        $this->info("Generated: {$role}/{$name}");
    }

    private function getPhpTemplate($role, $name, $label, $icon, $sort, $roleFolder, $viewPath)
    {
        $roleLevel = strtolower($role);
        if ($role === 'WaliKelas') $roleLevel = 'walikelas';
        if ($role === 'KepalaSekolah') $roleLevel = 'kepalasekolah';
        if ($role === 'OrangTua') $roleLevel = 'ortu';

        return <<<PHP
<?php

namespace App\Filament\Pages\\{$role};

use Filament\Pages\Page;

class {$name} extends Page
{
    protected string \$view = 'filament.pages.{$roleFolder}.{$viewPath}';
    protected static ?string \$navigationLabel = '{$label}';
    protected static ?string \$title = '{$label}';
    protected static ?int \$navigationSort = {$sort};

    public static function getNavigationIcon(): string
    {
        return '{$icon}';
    }

    public static function canAccess(): bool
    {
        \$user = auth()->user();
        return \$user && \$user->level === '{$roleLevel}';
    }
}
PHP;
    }

    private function getBladeTemplate()
    {
        return <<<'BLADE'
<x-filament-panels::page>
    <div class="space-y-4">
        <p>Halaman ini sedang dalam pengembangan.</p>
    </div>
</x-filament-panels::page>
BLADE;
    }
}
