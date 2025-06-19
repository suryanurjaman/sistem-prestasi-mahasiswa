<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrmawaResource\Pages;
use App\Models\Ormawa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrmawaResource extends Resource
{
    protected static ?string $model = Ormawa::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // ikon bisa diganti sesuai keinginan
    protected static ?string $navigationGroup = 'Data Kampus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Ormawa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis')
                    ->label('Jenis Ormawa')
                    ->options([
                        'UKM' => 'UKM',
                        'HIMA' => 'HIMA',
                        'BEM' => 'BEM',
                        'LAINNYA' => 'LAINNYA',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama Ormawa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('jenis')->label('Jenis')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Diubah')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListOrmawas::route('/'),
            'create' => Pages\CreateOrmawa::route('/create'),
            'edit' => Pages\EditOrmawa::route('/{record}/edit'),
        ];
    }
}
