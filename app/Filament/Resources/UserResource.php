<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === Data User ===
                Section::make('Akun')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                            ->minLength(8)
                            ->dehydrateStateUsing(function ($state) {
                                return filled($state) ? Hash::make($state) : null;
                            })
                            ->dehydrated(fn($state) => filled($state)) // ⛔️ Jangan ikut simpan kalau kosong
                            ->hiddenOn(Pages\ListUsers::class),
                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin'     => 'Admin',
                                'mahasiswa' => 'Mahasiswa',
                            ])
                            ->reactive()
                            ->required(),
                    ]),

                // === Data Mahasiswa (only if role=mahasiswa) ===
                Section::make('Data Mahasiswa')
                    ->relationship('mahasiswa')             // <-- ikut hasOne relasi
                    ->schema([
                        TextInput::make('nim')
                            ->label('NIM')
                            ->required()
                            ->maxLength(20),
                        TextInput::make('kontak')
                            ->label('Kontak / HP')
                            ->required()
                            ->tel(),
                        Select::make('fakultas_id')
                            ->relationship('fakultas', 'nama')
                            ->label('Fakultas')
                            ->required()
                            ->preload(),
                        Select::make('prodi_id')
                            ->relationship('prodi', 'nama')
                            ->label('Program Studi')
                            ->required()
                            ->preload(),
                        Select::make('ormawa_id')
                            ->relationship('ormawa', 'nama')
                            ->label('Ormawa')
                            ->nullable()
                            ->preload(),
                        Select::make('ukm_id')
                            ->relationship('ukm', 'nama') // pastikan relasi `ukm()` ada di model Mahasiswa
                            ->label('UKM')
                            ->nullable()
                            ->preload(),

                        // ⬇️ Tambahkan ini untuk unggah foto mahasiswa
                        FileUpload::make('foto_mahasiswa')
                            ->label('Foto Mahasiswa')
                            ->image()
                            ->directory('foto-mahasiswa')
                            ->disk('public')
                            ->imagePreviewHeight('150')
                            ->maxSize(3024)
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->visible(fn(Forms\Get $get) => $get('role') === 'mahasiswa'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                // Role sebagai TextColumn tanpa enum()
                TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(function (?string $state): string {
                        return match ($state) {
                            'admin'     => 'Admin',
                            'mahasiswa' => 'Mahasiswa',
                            default     => '-',
                        };
                    })
                    // contoh: beri warna teks berbeda
                    ->extraAttributes(function (?string $state): array {
                        return [
                            'class' => match ($state) {
                                'admin'     => 'text-red-600',
                                'mahasiswa' => 'text-blue-600',
                                default     => 'text-gray-600',
                            },
                        ];
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
