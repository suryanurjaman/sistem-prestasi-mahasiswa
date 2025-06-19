<?php

namespace App\Filament\Resources;

use App\Models\Prestasi;
use App\Models\Mahasiswa;
use App\Models\BerkasPrestasi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InputPrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Input Prestasi Mahasiswa';
    protected static ?string $navigationGroup = 'Manajemen Data Prestasi';

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'approved';
        $data['is_complete'] = true;
        return $data;
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Pilih Mahasiswa')
                ->schema([
                    Forms\Components\Select::make('mahasiswa_id')
                        ->label('Mahasiswa')
                        ->options(function () {
                            return \App\Models\Mahasiswa::with('user')->get()->pluck('user.name', 'id');
                        })
                        ->searchable()
                        ->preload()
                        ->required(),
                ])->columns(1),

            Forms\Components\Section::make('Data Prestasi')
                ->schema([
                    Forms\Components\TextInput::make('nama_prestasi')->required(),
                    Forms\Components\TextInput::make('nama_prestasi_en')->label('Nama Prestasi (Inggris)')->required(),
                    Forms\Components\Select::make('tingkat')
                        ->options([
                            'Internasional' => 'Internasional',
                            'Nasional' => 'Nasional',
                            'Provinsi' => 'Provinsi',
                            'Kota' => 'Kota',
                            'Universitas' => 'Universitas',
                        ])->required(),

                    Forms\Components\Select::make('jenis_juara')
                        ->options([
                            'Juara 1' => 'Juara 1',
                            'Juara 2' => 'Juara 2',
                            'Juara 3' => 'Juara 3',
                            'Harapan' => 'Harapan',
                            'Peserta' => 'Peserta',
                        ])->required(),

                    Forms\Components\TextInput::make('tahun')->numeric()->minValue(2000)->maxValue(date('Y'))->required(),

                    Forms\Components\TextInput::make('tempat')->required(),
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
                    Forms\Components\DatePicker::make('tanggal_mulai')->required(),
                    Forms\Components\DatePicker::make('tanggal_selesai')->required(),
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
                    Forms\Components\TextInput::make('dosen_pembimbing')->nullable(),
                ])->columns(2),

            Forms\Components\Section::make('Berkas Pendukung')
                ->relationship('berkasPrestasi') // relasi 1-1 dari model Prestasi
                ->schema([
                    Forms\Components\FileUpload::make('sertifikat_kelulusan')
                        ->multiple()
                        ->label('Sertifikat Kelulusan (Gambar)')
                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                        ->preserveFilenames()
                        ->required(),

                    Forms\Components\FileUpload::make('bukti_berkas')
                        ->label('Sertifikat kegiatan disatukan dalam format PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required(),

                    Forms\Components\FileUpload::make('foto_upp')
                        ->label('Foto Upacara')
                        ->image()
                        ->nullable(),

                    Forms\Components\FileUpload::make('surat_tugas')
                        ->label('Surat Tugas/Izin (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required(),

                    Forms\Components\Repeater::make('link_sertifikat_list')
                        ->label('Link Sertifikat Online (Opsional)')
                        ->schema([
                            Forms\Components\TextInput::make('url')
                                ->label('Link Sertifikat')
                                ->url()
                                ->required(),
                        ])
                        ->columns(1)
                        ->default([])
                        ->addActionLabel('Tambah Link'),
                ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.user.name')->label('Mahasiswa'),
                Tables\Columns\TextColumn::make('nama_prestasi'),
                Tables\Columns\TextColumn::make('tingkat'),
                Tables\Columns\TextColumn::make('jenis_juara'),
                Tables\Columns\TextColumn::make('tahun'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\InputPrestasiResource\Pages\ListInputPrestasis::route('/'),
            'create' => \App\Filament\Resources\InputPrestasiResource\Pages\CreateInputPrestasi::route('/create'),
            'edit' => \App\Filament\Resources\InputPrestasiResource\Pages\EditInputPrestasi::route('/{record}/edit'),
        ];
    }
}
