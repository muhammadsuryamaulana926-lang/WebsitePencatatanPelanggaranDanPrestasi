<?php

namespace App\Filament\Resources\JenisPelanggarans;

use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\JenisPelanggarans\Pages\CreateJenisPelanggaran;
use App\Filament\Resources\JenisPelanggarans\Pages\EditJenisPelanggaran;
use App\Filament\Resources\JenisPelanggarans\Pages\ListJenisPelanggarans;
use App\Filament\Resources\JenisPelanggarans\Schemas\JenisPelanggaranForm;
use App\Filament\Resources\JenisPelanggarans\Tables\JenisPelanggaransTable;
use App\Models\JenisPelanggaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JenisPelanggaranResource extends Resource
{
    protected static ?string $model = JenisPelanggaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static string|UnitEnum|null $navigationGroup = 'Konfigurasi Sistem';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'nama_pelanggaran';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return JenisPelanggaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisPelanggaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJenisPelanggarans::route('/'),
            'create' => CreateJenisPelanggaran::route('/create'),
            'edit' => EditJenisPelanggaran::route('/{record}/edit'),
        ];
    }
}
