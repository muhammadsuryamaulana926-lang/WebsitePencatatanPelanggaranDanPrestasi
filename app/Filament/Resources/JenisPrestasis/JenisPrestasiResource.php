<?php

namespace App\Filament\Resources\JenisPrestasis;

use App\Filament\Resources\JenisPrestasis\Pages\CreateJenisPrestasi;
use App\Filament\Resources\JenisPrestasis\Pages\EditJenisPrestasi;
use App\Filament\Resources\JenisPrestasis\Pages\ListJenisPrestasis;
use App\Filament\Resources\JenisPrestasis\Schemas\JenisPrestasiForm;
use App\Filament\Resources\JenisPrestasis\Tables\JenisPrestasisTable;
use App\Models\JenisPrestasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JenisPrestasiResource extends Resource
{
    protected static ?string $model = JenisPrestasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static string|UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 51;

    protected static ?string $recordTitleAttribute = 'nama_prestasi';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canViewAny(): bool
    {
        return true;
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
        return $user && $user->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return JenisPrestasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisPrestasisTable::configure($table);
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
            'index' => ListJenisPrestasis::route('/'),
            'create' => CreateJenisPrestasi::route('/create'),
            'edit' => EditJenisPrestasi::route('/{record}/edit'),
        ];
    }
}
