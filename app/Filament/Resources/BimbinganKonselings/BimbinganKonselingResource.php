<?php

namespace App\Filament\Resources\BimbinganKonselings;

use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\BimbinganKonselings\Pages\CreateBimbinganKonseling;
use App\Filament\Resources\BimbinganKonselings\Pages\EditBimbinganKonseling;
use App\Filament\Resources\BimbinganKonselings\Pages\ListBimbinganKonselings;
use App\Filament\Resources\BimbinganKonselings\Schemas\BimbinganKonselingForm;
use App\Filament\Resources\BimbinganKonselings\Tables\BimbinganKonselingsTable;
use App\Models\BimbinganKonseling;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BimbinganKonselingResource extends Resource
{
    protected static ?string $model = BimbinganKonseling::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|UnitEnum|null $navigationGroup = 'Layanan Kesiswaan';

    protected static ?int $navigationSort = 14;

    protected static ?string $recordTitleAttribute = 'keterangan';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'bk', 'kesiswaan']);
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'bk', 'kesiswaan']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'bk', 'kesiswaan']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if ($user->level === 'admin' || $user->level === 'kesiswaan') {
            return true;
        }
        if ($user->level === 'bk' && $record->guru_konselor === $user->guru_id) {
            return true;
        }
        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'bk', 'kesiswaan']);
    }

    public static function form(Schema $schema): Schema
    {
        return BimbinganKonselingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BimbinganKonselingsTable::configure($table);
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
            'index' => ListBimbinganKonselings::route('/'),
            'create' => CreateBimbinganKonseling::route('/create'),
            'edit' => EditBimbinganKonseling::route('/{record}/edit'),
        ];
    }
}
