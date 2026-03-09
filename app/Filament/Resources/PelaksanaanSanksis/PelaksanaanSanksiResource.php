<?php

namespace App\Filament\Resources\PelaksanaanSanksis;

use App\Filament\Resources\PelaksanaanSanksis\Pages\CreatePelaksanaanSanksi;
use App\Filament\Resources\PelaksanaanSanksis\Pages\EditPelaksanaanSanksi;
use App\Filament\Resources\PelaksanaanSanksis\Pages\ListPelaksanaanSanksis;
use App\Filament\Resources\PelaksanaanSanksis\Schemas\PelaksanaanSanksiForm;
use App\Filament\Resources\PelaksanaanSanksis\Tables\PelaksanaanSanksisTable;
use App\Models\PelaksanaanSanksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PelaksanaanSanksiResource extends Resource
{
    protected static ?string $model = PelaksanaanSanksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Pelanggaran & Sanksi';

    protected static ?string $recordTitleAttribute = 'keterangan';

    public static function form(Schema $schema): Schema
    {
        return PelaksanaanSanksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelaksanaanSanksisTable::configure($table);
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
            'index' => ListPelaksanaanSanksis::route('/'),
            'create' => CreatePelaksanaanSanksi::route('/create'),
            'edit' => EditPelaksanaanSanksi::route('/{record}/edit'),
        ];
    }
}
