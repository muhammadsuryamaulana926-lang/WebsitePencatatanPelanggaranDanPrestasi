<?php

namespace App\Filament\Resources\Gurus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GurusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                TextColumn::make('nama_guru')
                    ->label('Nama Guru')
                    ->searchable(),
                TextColumn::make('bidang_studi')
                    ->label('Bidang Studi')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Tgl Bergabung')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
