<?php

namespace App\Filament\Resources\BimbinganKonselings;

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

    protected static string|UnitEnum|null $navigationGroup = 'Layanan';

    protected static ?string $recordTitleAttribute = 'keterangan';

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
