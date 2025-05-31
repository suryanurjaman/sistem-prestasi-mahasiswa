<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluasiPrestasiResource\Pages;
use App\Models\Prestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\LinkEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;


class EvaluasiPrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['berkasPrestasi', 'mahasiswa.user']);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['dosen_pembimbing']) && ($data['dosen_pembimbing'] === '-' || empty($data['dosen_pembimbing']))) {
            $data['dosen_pembimbing'] = null;
        }
        return $data;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Mahasiswa')
                ->schema([
                    Forms\Components\Placeholder::make('nim')
                        ->label('NIM')
                        ->content(fn($record) => $record->mahasiswa?->nim),

                    Forms\Components\Placeholder::make('nama_mahasiswa')
                        ->label('Nama Mahasiswa')
                        ->content(fn($record) => $record->mahasiswa?->user?->name),

                    Forms\Components\Placeholder::make('prodi')
                        ->label('Program Studi')
                        ->content(fn($record) => $record->mahasiswa?->prodi?->nama),

                    Forms\Components\Placeholder::make('fakultas')
                        ->label('Fakultas')
                        ->content(fn($record) => $record->mahasiswa?->fakultas?->nama),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Prestasi')
                ->schema([
                    Forms\Components\TextInput::make('nama_prestasi')
                        ->label('Nama Prestasi')
                        ->disabled(),
                    Forms\Components\TextInput::make('nama_prestasi_en')
                        ->label('Nama Prestasi (Inggris)')
                        ->disabled(),
                    Forms\Components\TextInput::make('tingkat')
                        ->label('Tingkat')
                        ->disabled(),
                    Forms\Components\TextInput::make('jenis_juara')
                        ->label('Jenis Juara')
                        ->disabled(),
                    Forms\Components\TextInput::make('tahun')
                        ->label('Tahun')
                        ->disabled(),
                    Forms\Components\TextInput::make('tempat')
                        ->label('Tempat')
                        ->disabled(),
                    Forms\Components\TextInput::make('jumlah_pt')
                        ->label('Jumlah PT')
                        ->disabled(),
                    Forms\Components\TextInput::make('jumlah_provinsi')
                        ->label('Jumlah Provinsi')
                        ->disabled(),
                    Forms\Components\TextInput::make('jenis_prestasi')
                        ->label('Jenis Prestasi')
                        ->disabled(),
                    Forms\Components\DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->disabled(),
                    Forms\Components\DatePicker::make('tanggal_selesai')
                        ->label('Tanggal Selesai')
                        ->disabled(),
                    Forms\Components\TextInput::make('kategori_prestasi')
                        ->label('Kategori Prestasi')
                        ->disabled(),
                    Forms\Components\TextInput::make('dosen_pembimbing')
                        ->label('Dosen Pembimbing')
                        ->disabled()
                        ->placeholder('-'),
                ])->columns(2),

            Forms\Components\Section::make('Berkas Pendukung')
                ->schema([
                    Forms\Components\Placeholder::make('bukti_berkas')
                        ->label('Bukti Berkas')
                        ->content(fn($record) => $record->berkasPrestasi?->bukti_berkas
                            ? new HtmlString('<a href="' . route('download.berkas', ['tipe' => 'bukti', 'id' => $record->id]) . '" target="_blank" class="text-primary-600 underline">Download Berkas</a>')
                            : 'Berkas tidak ada')
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('foto_upp')
                        ->label('Foto Upacara')
                        ->content(fn($record) => $record->berkasPrestasi?->foto_upp
                            ? new HtmlString('<a href="' . route('download.berkas', ['tipe' => 'foto', 'id' => $record->id]) . '" target="_blank" class="text-primary-600 underline">Download Berkas</a>')
                            : 'Berkas tidak ada')
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('surat_tugas')
                        ->label('Surat Tugas')
                        ->content(fn($record) => $record->berkasPrestasi?->surat_tugas
                            ? new HtmlString('<a href="' . route('download.berkas', ['tipe' => 'surat', 'id' => $record->id]) . '" target="_blank" class="text-primary-600 underline">Download Berkas</a>')
                            : 'Berkas tidak ada')
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('link_berkas')
                        ->label('Link Berkas')
                        ->content(fn($record) => $record->berkasPrestasi?->link_berkas
                            ? new HtmlString('<a href="' . $record->berkasPrestasi?->link_berkas . '" target="_blank" class="text-blue-600 underline">Lihat Link</a>')
                            : 'Berkas tidak ada')
                        ->columnSpanFull(),
                ])->columns(1),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nim')
                    ->label('NIM'),
                Tables\Columns\TextColumn::make('mahasiswa.user.name')
                    ->label('Nama Mahasiswa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mahasiswa.prodi.nama')
                    ->label('Program Studi'),

                Tables\Columns\TextColumn::make('mahasiswa.fakultas.nama')
                    ->label('Fakultas'),
                Tables\Columns\TextColumn::make('tempat'),
                Tables\Columns\TextColumn::make('tanggal_mulai'),
                Tables\Columns\TextColumn::make('tanggal_selesai'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'diajukan' => 'Diajukan',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'warning' => 'diajukan',
                    ])
                    ->sortable()
                    ->searchable(),

                // // FILE: BUKTI BERKAS
                // Tables\Columns\TextColumn::make('berkasPrestasi.bukti_berkas')
                //     ->label('Bukti')
                //     ->getStateUsing(fn($record) => $record->berkasPrestasi?->bukti_berkas ? 'Download Berkas' : 'Tidak ada berkas')
                //     ->url(fn($record) => $record->berkasPrestasi?->bukti_berkas ? route('download.berkas', ['tipe' => 'bukti', 'id' => $record->id]) : null, true)
                //     ->openUrlInNewTab()
                //     ->color(fn($record) => $record->berkasPrestasi?->bukti_berkas ? 'primary' : 'secondary'),

                // // FILE: FOTO UPACARA
                // Tables\Columns\TextColumn::make('berkasPrestasi.foto_upp')
                //     ->label('Foto')
                //     ->getStateUsing(fn($record) => $record->berkasPrestasi?->foto_upp ? 'Download Berkas' : 'Tidak ada berkas')
                //     ->url(fn($record) => $record->berkasPrestasi?->foto_upp ? route('download.berkas', ['tipe' => 'foto', 'id' => $record->id]) : null, true)
                //     ->openUrlInNewTab()
                //     ->color(fn($record) => $record->berkasPrestasi?->foto_upp ? 'primary' : 'secondary'),

                // // FILE: SURAT TUGAS
                // Tables\Columns\TextColumn::make('berkasPrestasi.surat_tugas')
                //     ->label('Surat Tugas')
                //     ->getStateUsing(fn($record) => $record->berkasPrestasi?->surat_tugas ? 'Download Berkas' : 'Tidak ada berkas')
                //     ->url(fn($record) => $record->berkasPrestasi?->surat_tugas ? route('download.berkas', ['tipe' => 'surat', 'id' => $record->id]) : null, true)
                //     ->openUrlInNewTab()
                //     ->color(fn($record) => $record->berkasPrestasi?->surat_tugas ? 'primary' : 'secondary'),

                // // FILE: LINK BERKAS
                // Tables\Columns\TextColumn::make('berkasPrestasi.link_berkas')
                //     ->label('Link Berkas')
                //     ->getStateUsing(fn($record) => $record->berkasPrestasi?->link_berkas ? 'Lihat Link' : 'Tidak ada berkas')
                //     ->url(fn($record) => $record->berkasPrestasi?->link_berkas ?: null, true)
                //     ->openUrlInNewTab()
                //     ->color(fn($record) => $record->berkasPrestasi?->link_berkas ? 'info' : 'secondary'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Evaluasi'),
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
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluasiPrestasis::route('/'),
            'edit' => Pages\EditEvaluasiPrestasi::route('/{record}/edit'),
        ];
    }
}
