<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\BerkasPrestasiResource\Pages;
use App\Filament\Mahasiswa\Traits\FilterByMahasiswaTrait;
use App\Models\BerkasPrestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{FileUpload, Hidden, TextInput};
use Illuminate\Support\Facades\Storage;

class BerkasPrestasiResource extends Resource
{
    use FilterByMahasiswaTrait;
    protected static ?string $model = BerkasPrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $modelLabel = 'Berkas Pendukung Prestasi';
    protected static ?string $navigationLabel = 'Berkas Pendukung Prestasi';
    protected static ?string $navigationGroup = 'Pengajuan Prestasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('prestasi_id')->required(),

            FileUpload::make('sertifikat_kelulusan')
                ->label('Bukti sertifikat kelulusan dalam format Gambar (bisa lebih )')
                ->multiple()
                ->image()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                ->required(), // atau nullable() kalau tidak wajib

            FileUpload::make('foto_upp')
                ->label('Foto Upacara Penyerahan Penghargaan (jika ada)')
                ->image()
                ->nullable(),

            FileUpload::make('bukti_berkas')
                ->label('Sertifikat kegiatan disatukan dalam format PDF')
                ->acceptedFileTypes(['application/pdf'])
                ->required(),

            FileUpload::make('surat_tugas')
                ->label('Surat Tugas/Izin (PDF)')
                ->acceptedFileTypes(['application/pdf'])
                ->required(), // atau nullable()

            Forms\Components\Repeater::make('link_sertifikat_list')
                ->label('Link Sertifikat (kosongkan jika tidak ada)')
                ->schema([
                    TextInput::make('url')
                        ->label('Link Sertifikat')
                        ->url()
                        ->required(),
                ])
                ->addActionLabel('Tambah Link')
                ->default([]) // Tambahkan ini
                ->columns(1),



        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prestasi.nama_prestasi')
                    ->label('Nama Prestasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ViewColumn::make('bukti_berkas')
                    ->label('Bukti Berkas')
                    ->view('components.table.bukti-berkas')
                    ->extraAttributes([
                        'class' => 'p-0 m-0 text-left align-middle',
                    ]),

                Tables\Columns\TextColumn::make('surat_tugas')
                    ->label('Surat Tugas')
                    ->placeholder('Berkas tidak ada')
                    ->view('components.table.bukti-berkas')
                    ->extraAttributes([
                        'class' => 'p-0 m-0 text-left align-middle',
                    ]),

                Tables\Columns\ViewColumn::make('sertifikat_kelulusan')
                    ->label('Sertifikat Kelulusan')
                    ->view('components.table.sertifikat-kelulusan'),

                Tables\Columns\TextColumn::make('foto_upp')
                    ->label('Foto pengesahan (jika ada)')
                    ->placeholder('Berkas tidak ada')
                    ->view('components.table.bukti-berkas')
                    ->extraAttributes([
                        'class' => 'p-0 m-0 text-left align-middle',
                    ]),

                Tables\Columns\ViewColumn::make('link_sertifikat_list')
                    ->label('Link Sertifikat')
                    ->view('components.table.link-sertifikat')
                    ->extraAttributes(['class' => 'text-left']),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Upload')
                    ->extraAttributes(['class' => 'text-left']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'create' => Pages\CreateBerkasPrestasi::route('/create'),
            'edit' => Pages\EditBerkasPrestasi::route('/{record}/edit'),
            'index' => Pages\ListBerkasPrestasis::route('/'),
        ];
    }
}
