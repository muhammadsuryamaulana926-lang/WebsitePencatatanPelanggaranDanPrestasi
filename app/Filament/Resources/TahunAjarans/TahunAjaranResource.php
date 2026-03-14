<?php

namespace App\Filament\Resources\TahunAjarans;

use Illuminate\Support\Facades\Auth;

use App\Filament\Resources\TahunAjarans\Pages\CreateTahunAjaran;
use App\Filament\Resources\TahunAjarans\Pages\EditTahunAjaran;
use App\Filament\Resources\TahunAjarans\Pages\ListTahunAjarans;
use App\Filament\Resources\TahunAjarans\Schemas\TahunAjaranForm;
use App\Filament\Resources\TahunAjarans\Tables\TahunAjaransTable;
use App\Models\TahunAjaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TahunAjaranResource extends Resource
{
    protected static ?string $model = TahunAjaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Konfigurasi Sistem';

    protected static ?int $navigationSort = 32;

    protected static ?string $recordTitleAttribute = 'tahun_ajaran';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user && $user->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return TahunAjaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TahunAjaransTable::configure($table);
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
            'index' => ListTahunAjarans::route('/'),
            'create' => CreateTahunAjaran::route('/create'),
            'edit' => EditTahunAjaran::route('/{record}/edit'),
        ];
    }
}
