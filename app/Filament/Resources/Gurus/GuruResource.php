<?php

namespace App\Filament\Resources\Gurus;

use App\Filament\Resources\Gurus\Pages\CreateGuru;
use App\Filament\Resources\Gurus\Pages\EditGuru;
use App\Filament\Resources\Gurus\Pages\ListGurus;
use App\Filament\Resources\Gurus\Schemas\GuruForm;
use App\Filament\Resources\Gurus\Tables\GurusTable;
use App\Models\Guru;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama_guru';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'admin';
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->level, ['admin', 'kesiswaan', 'kepalasekolah']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'admin';
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'admin';
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        return $user && $user->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return GuruForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GurusTable::configure($table);
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
            'index' => ListGurus::route('/'),
            'create' => CreateGuru::route('/create'),
            'edit' => EditGuru::route('/{record}/edit'),
        ];
    }
}
