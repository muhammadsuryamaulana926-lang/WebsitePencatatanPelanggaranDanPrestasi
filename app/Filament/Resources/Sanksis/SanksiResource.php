<?php

namespace App\Filament\Resources\Sanksis;

use App\Filament\Resources\Sanksis\Pages\CreateSanksi;
use App\Filament\Resources\Sanksis\Pages\EditSanksi;
use App\Filament\Resources\Sanksis\Pages\ListSanksis;
use App\Filament\Resources\Sanksis\Schemas\SanksiForm;
use App\Filament\Resources\Sanksis\Tables\SanksisTable;
use App\Models\Sanksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SanksiResource extends Resource
{
    protected static ?string $model = Sanksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = 'Pelanggaran & Sanksi';

    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'nama_sanksi';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah', 'siswa']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function form(Schema $schema): Schema
    {
        return SanksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SanksisTable::configure($table);
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
            'index' => ListSanksis::route('/'),
            'create' => CreateSanksi::route('/create'),
            'edit' => EditSanksi::route('/{record}/edit'),
        ];
    }
}
