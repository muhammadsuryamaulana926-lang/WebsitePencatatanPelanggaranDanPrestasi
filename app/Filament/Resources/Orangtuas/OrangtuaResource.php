<?php

namespace App\Filament\Resources\Orangtuas;

use App\Filament\Resources\Orangtuas\Pages\CreateOrangtua;
use App\Filament\Resources\Orangtuas\Pages\EditOrangtua;
use App\Filament\Resources\Orangtuas\Pages\ListOrangtuas;
use App\Filament\Resources\Orangtuas\Schemas\OrangtuaForm;
use App\Filament\Resources\Orangtuas\Tables\OrangtuasTable;
use App\Models\Orangtua;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrangtuaResource extends Resource
{
    protected static ?string $model = Orangtua::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $recordTitleAttribute = 'nama_orangtua';

    public static function form(Schema $schema): Schema
    {
        return OrangtuaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrangtuasTable::configure($table);
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
            'index' => ListOrangtuas::route('/'),
            'create' => CreateOrangtua::route('/create'),
            'edit' => EditOrangtua::route('/{record}/edit'),
        ];
    }
}
