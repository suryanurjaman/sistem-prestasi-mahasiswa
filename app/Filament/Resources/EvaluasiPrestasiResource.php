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
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class EvaluasiPrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Evaluasi Data Prestasi';
    protected static ?string $navigationGroup = 'Manajemen Data Prestasi';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            // hanya ambil yang status-nya bukan 'pending'
            ->where('status', '!=', 'pending')
            // tetap eager‑load relasi
            ->with(['berkasPrestasi', 'mahasiswa.user', 'mahasiswa.prodi', 'mahasiswa.fakultas']);
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

                    // Sertifikat Kelulusan
                    Forms\Components\Placeholder::make('sertifikat_kelulusan')
                        ->label('Sertifikat Kelulusan')
                        ->content(function ($record) {
                            $sertifikatList = $record->berkasPrestasi?->sertifikat_kelulusan;

                            if (!is_array($sertifikatList) || count($sertifikatList) === 0) {
                                return 'Tidak ada sertifikat kelulusan.';
                            }

                            $html = '<ul class="list-disc pl-8">';
                            foreach ($sertifikatList as $filename) {
                                $url = Storage::url("berkas-prestasi/sertifikat_kelulusan/{$filename}");
                                $shortName = \Illuminate\Support\Str::limit($filename, 50);
                                $html .= "<li><a href=\"{$url}\" download class=\"text-primary-600 underline\"> {$shortName}</a></li>";
                            }
                            $html .= '</ul>';

                            return new HtmlString($html);
                        })
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('bukti_berkas')
                        ->label('Bukti sertifikat kegiatan disatukan dalam bentuk file PDF')
                        ->content(function ($record) {
                            $url = $record->berkasPrestasi?->buktiBerkasUrl; // accessor otomatis
                            return $url
                                ? new HtmlString("<a href=\"{$url}\" download class=\"text-primary-600 underline\">Download Berkas</a>")
                                : 'Berkas tidak ada';
                        })
                        ->columnSpanFull(),

                    // Foto Upacara
                    Forms\Components\Placeholder::make('foto_upp')
                        ->label('Foto Upacara')
                        ->content(function ($record) {
                            $url = $record->berkasPrestasi?->fotoUppUrl; // accessor getFotoUppUrlAttribute()
                            return $url
                                ? new HtmlString(
                                    "<a href=\"{$url}\" download class=\"text-primary-600 underline\">Download Foto</a>"
                                )
                                : 'Berkas tidak ada';
                        })
                        ->columnSpanFull(),

                    // Surat Tugas
                    Forms\Components\Placeholder::make('surat_tugas')
                        ->label('Surat Tugas')
                        ->content(function ($record) {
                            $url = $record->berkasPrestasi?->suratTugasUrl; // accessor getSuratTugasUrlAttribute()
                            return $url
                                ? new HtmlString(
                                    "<a href=\"{$url}\" download class=\"text-primary-600 underline\">Download Surat</a>"
                                )
                                : 'Berkas tidak ada';
                        })
                        ->columnSpanFull(),

                    // Link Berkas (jika ada URL eksternal)
                    Forms\Components\Placeholder::make('link_sertifikat_list')
                        ->label('Link Berkas')
                        ->content(function ($record) {
                            $links = $record->berkasPrestasi?->link_sertifikat_list;

                            if (!is_array($links) || count($links) === 0) {
                                return 'Berkas tidak ada';
                            }

                            $html = '<ul class="list-disc pl-4">';
                            foreach ($links as $item) {
                                if (is_array($item) && isset($item['url'])) {
                                    $shortUrl = Str::limit($item['url'], 50);
                                    $html .= "<li><a href=\"{$item['url']}\" target=\"_blank\" class=\"text-blue-600 underline\">{$shortUrl}</a></li>";
                                }
                            }
                            $html .= '</ul>';

                            return new HtmlString($html);
                        })
                        ->columnSpanFull(),
                ])->columns(1),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nim')
                    ->label('NIM')
                    ->sortable(),
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
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pengajuan')
                    ->options([
                        'diajukan'  => 'Diajukan',
                        'approved'  => 'Disetujui',
                        'rejected'  => 'Ditolak',
                    ]),

                SelectFilter::make('mahasiswa.prodi_id')
                    ->label('Program Studi')
                    ->relationship('mahasiswa.prodi', 'nama'),

                SelectFilter::make('mahasiswa.fakultas_id')
                    ->label('Fakultas')
                    ->relationship('mahasiswa.fakultas', 'nama'),

                SelectFilter::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'Internasional' => 'Internasional',
                        'Nasional' => 'Nasional',
                        'Provinsi' => 'Provinsi',
                        'Kota/Kabupaten' => 'Kota/Kabupaten',
                        'Perguruan Tinggi' => 'Perguruan Tinggi',
                    ]),

                SelectFilter::make('jenis_prestasi')
                    ->label('Jenis Prestasi')
                    ->options(fn() => Prestasi::query()
                        ->distinct()
                        ->pluck('jenis_prestasi', 'jenis_prestasi')
                        ->filter()),

                SelectFilter::make('kategori_prestasi')
                    ->label('Kategori Prestasi')
                    ->options(fn() => Prestasi::query()
                        ->distinct()
                        ->pluck('kategori_prestasi', 'kategori_prestasi')
                        ->filter()),
            ])
            ->defaultSort('created_at', 'desc')
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
