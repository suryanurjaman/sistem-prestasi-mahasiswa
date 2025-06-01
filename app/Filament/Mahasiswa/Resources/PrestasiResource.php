<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PrestasiResource\Pages;
use App\Filament\Mahasiswa\Resources\PrestasiResource\RelationManagers;
use App\Filament\Mahasiswa\Traits\FilterByMahasiswaTrait;
use App\Models\Prestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{TextInput, Select, DatePicker, Textarea};
use App\Models\Mahasiswa;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestasiResource extends Resource
{
    use FilterByMahasiswaTrait;
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Data Prestasi';
    protected static ?string $navigationLabel = 'Data Prestasi';
    protected static ?string $navigationGroup = 'Pengajuan Prestasi';

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $data['user_id'] = $user->id;
        $data['mahasiswa_id'] = $mahasiswa?->id;

        return $data;
    }
    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if (!$user || !$user->mahasiswa) {
            return null; // Kalau belum login atau belum ada relasi mahasiswa, badge gak tampil
        }

        $userId = $user->mahasiswa->id;

        $approved = static::$model::query()
            ->where('mahasiswa_id', $userId)
            ->where('status', 'approved')
            ->count();

        $rejected = static::$model::query()
            ->where('mahasiswa_id', $userId)
            ->where('status', 'rejected')
            ->count();

        if ($approved === 0 && $rejected === 0) {
            return null;
        }

        return ($approved ? '✔️' . $approved : '') . ' ' . ($rejected ? '❌' . $rejected : '');
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('mahasiswa_id')
                ->label('Mahasiswa')
                ->options(function () {
                    return Mahasiswa::with('user')->get()->pluck('user.name', 'id');
                })
                ->searchable()
                ->required()
                ->disabled() // diasumsikan sudah login sebagai mahasiswa
                ->default(optional(auth()->user()->mahasiswa)->id),

            TextInput::make('nama_prestasi')->required(),
            TextInput::make('nama_prestasi_en')->required(),
            TextInput::make('tempat')->required(),

            Select::make('tingkat')
                ->options([
                    'Internasional' => 'Internasional',
                    'Nasional' => 'Nasional',
                    'Provinsi' => 'Provinsi',
                    'Kota' => 'Kota',
                    'Universitas' => 'Universitas',
                ])
                ->required(),

            Select::make('jenis_juara')
                ->options([
                    'Juara 1' => 'Juara 1',
                    'Juara 2' => 'Juara 2',
                    'Juara 3' => 'Juara 3',
                    'Harapan' => 'Harapan',
                    'Peserta' => 'Peserta',
                ])
                ->required(),

            TextInput::make('tahun')
                ->required()
                ->length(4),

            Select::make('jumlah_pt')
                ->options([
                    '<5' => '<5',
                    '10-20' => '10-20',
                    '>20' => '>20',
                ])
                ->label('Jumlah PT yang terlibat di perlombaan')
                ->required(),

            Select::make('jumlah_provinsi')
                ->options([
                    '1-5' => '1-5',
                    '5-10' => '5-10',
                ])
                ->label('Jumlah provinsi yang terlibat di perlombaan')
                ->required(),

            Select::make('jenis_prestasi')
                ->options([
                    'Akademik' => 'Akademik',
                    'Non-akademik' => 'Non-akademik',
                ])
                ->required(),

            DatePicker::make('tanggal_mulai')->required(),
            DatePicker::make('tanggal_selesai')->required(),

            Select::make('kategori_prestasi')
                ->options([
                    'Individu' => 'Individu',
                    'Kelompok' => 'Kelompok',
                ])
                ->required()
                ->live(),

            \Filament\Forms\Components\Repeater::make('anggota_kelompok')
                ->label('Anggota Kelompok (NIM)')
                ->schema([
                    TextInput::make('nim')
                        ->label('NIM Anggota')
                        ->required(),
                ])
                ->visible(fn(Forms\Get $get) => $get('kategori_prestasi') === 'Kelompok')
                ->minItems(1)
                ->columns(1),

            TextInput::make('dosen_pembimbing')->nullable(),

            TextInput::make('status')
                ->default('pending')
                ->hidden(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_prestasi')
                    ->label('Nama Prestasi')
                    ->searchable(),

                TextColumn::make('tingkat')
                    ->label('Tingkat'),

                TextColumn::make('is_complete')
                    ->label('Kelengkapan Berkas')
                    ->badge()
                    ->formatStateUsing(fn(bool $state) => $state ? 'Lengkap' : 'Belum Lengkap')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger'),

                TextColumn::make('status')
                    ->label('Status Pengajuan')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'pending' => 'gray',
                        'diajukan' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\DeleteAction::make(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('lengkapiBerkas')
                    ->label('Lengkapi Berkas')
                    ->icon('heroicon-o-document-text')
                    ->url(fn($record) => route('filament.mahasiswa.resources.berkas-prestasis.create', [
                        'prestasi_id' => $record->id,
                    ]))
                    ->color('warning')
                    ->visible(fn($record) => !$record->is_complete),

                Tables\Actions\Action::make('ajukan')
                    ->label('Ajukan')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->is_complete && $record->status === 'pending')
                    ->action(fn($record) => $record->update(['status' => 'diajukan'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPrestasis::route('/'),
            'create' => Pages\CreatePrestasi::route('/create'),
            'edit' => Pages\EditPrestasi::route('/{record}/edit'),
        ];
    }
}
