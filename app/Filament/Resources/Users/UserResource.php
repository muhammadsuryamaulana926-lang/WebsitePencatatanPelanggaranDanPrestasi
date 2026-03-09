<?php

namespace App\Filament\Resources\Users;

use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Toggle;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 53;
    protected static ?string $navigationLabel = 'Manajemen User';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Sistem';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->level === 'admin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->level === 'admin';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('username')->required()->unique(ignoreRecord: true),
            TextInput::make('password')->password()->required(fn ($record) => !$record)->dehydrated(fn ($state) => filled($state)),
            Select::make('level')
                ->options([
                    'admin' => 'Admin',
                    'kesiswaan' => 'Kesiswaan',
                    'guru' => 'Guru',
                    'walikelas' => 'Wali Kelas',
                    'bk' => 'BK',
                    'kepalasekolah' => 'Kepala Sekolah',
                    'siswa' => 'Siswa',
                    'ortu' => 'Orang Tua',
                ])
                ->required(),
            Select::make('guru_id')
                ->label('Guru')
                ->relationship('guru', 'nama_guru')
                ->searchable()
                ->preload(),
            Toggle::make('can_verify')->label('Dapat Verifikasi'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')->searchable(),
                TextColumn::make('level')->badge(),
                TextColumn::make('guru.nama_guru')->label('Guru'),
                IconColumn::make('can_verify')->boolean(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Users\Pages\ListUsers::route('/'),
            'create' => \App\Filament\Resources\Users\Pages\CreateUser::route('/create'),
            'edit' => \App\Filament\Resources\Users\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
