<?php

namespace App\Filament\Resources\VerifikasiData;

use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\VerifikasiData\Pages\CreateVerifikasiData;
use App\Filament\Resources\VerifikasiData\Pages\EditVerifikasiData;
use App\Filament\Resources\VerifikasiData\Pages\ListVerifikasiData;
use App\Filament\Resources\VerifikasiData\Schemas\VerifikasiDataForm;
use App\Filament\Resources\VerifikasiData\Tables\VerifikasiDataTable;
use App\Models\VerifikasiData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VerifikasiDataResource extends Resource
{
    protected static ?string $model = VerifikasiData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static string|UnitEnum|null $navigationGroup = 'Monitoring & Verifikasi';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'status';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if ($user->level === 'admin' || $user->level === 'kesiswaan') {
            return true;
        }
        if ($user->can_verify && $record->guru_verifikator === $user->guru_id) {
            return true;
        }
        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && in_array($user->level, ['admin', 'kesiswaan']);
    }

    public static function form(Schema $schema): Schema
    {
        return VerifikasiDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VerifikasiDataTable::configure($table);
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
            'index' => ListVerifikasiData::route('/'),
            'create' => CreateVerifikasiData::route('/create'),
            'edit' => EditVerifikasiData::route('/{record}/edit'),
        ];
    }
}
