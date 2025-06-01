<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;
use App\Filament\Mahasiswa\Traits\FilterByMahasiswaTrait;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MahasiswaResource extends Resource
{
    use FilterByMahasiswaTrait;
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Data Pribadi';
    protected static ?string $navigationGroup = 'Personal Info';
    public static function getLabel(): string
    {
        return 'Data Pribadi';
    }

    public static function getPluralLabel(): string
    {
        return 'Data Pribadi';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->label('NIM'),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->label('Kontak'),
                Forms\Components\Select::make('fakultas_id')
                    ->relationship('fakultas', 'nama')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->label('Fakultas'),
                Forms\Components\Select::make('prodi_id')
                    ->relationship('prodi', 'nama')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->label('Program Studi'),
                Forms\Components\Select::make('ormawa_id')
                    ->relationship('ormawa', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Ormawa')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Mahasiswa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fakultas.nama')
                    ->label('Fakultas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('prodi.nama')
                    ->label('Program Studi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ormawa.nama')
                    ->label('Ormawa')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }
    public static function canCreate(): bool
    {
        // Cek kalau user sudah punya data Mahasiswa
        $userId = auth()->id();
        return !Mahasiswa::where('user_id', $userId)->exists();
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
