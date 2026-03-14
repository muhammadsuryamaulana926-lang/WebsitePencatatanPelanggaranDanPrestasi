<?php

namespace App\Filament\Resources\Siswas;

use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama_siswa';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas', 'kepalasekolah']);
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas', 'kepalasekolah']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas', 'kepalasekolah']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'guru', 'walikelas', 'kepalasekolah']);
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
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
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}
