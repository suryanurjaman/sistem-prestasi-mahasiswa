<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\BerkasPrestasiResource\Pages;
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
    protected static ?string $model = BerkasPrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $modelLabel = 'Berkas Prestasi';
    protected static ?string $navigationLabel = 'Berkas Prestasi';
    protected static ?string $navigationGroup = 'Pengajuan Prestasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Hidden::make('prestasi_id')->required(),

            FileUpload::make('bukti_berkas')
                ->label('Bukti Prestasi (PDF/IMG)')
                ->acceptedFileTypes(['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'])
                ->required(),

            TextInput::make('link_berkas')
                ->label('Link Sertifikat (jika ada)')
                ->url()
                ->nullable(),

            FileUpload::make('foto_upp')
                ->label('Foto Upacara Penyerahan Penghargaan (jika ada)')
                ->image()
                ->nullable(),

            FileUpload::make('surat_tugas')
                ->label('Surat Tugas/Izin')
                ->acceptedFileTypes(['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bukti_berkas')
                    ->label('Bukti Berkas')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '—'; // tanda strip yang lebih rapi

                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        $url = Storage::url($state);

                        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            return "<img src='$url' alt='bukti' class='h-12 rounded-md object-cover' style='max-width: 100px;' />";
                        } elseif ($ext === 'pdf') {
                            return "
                            <a href='$url' target='_blank' class='inline-flex items-center gap-1'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 text-gray-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z' />
                                </svg>
                                <span class='text-sm text-blue-600 hover:underline'>Lihat PDF</span>
                            </a>
                        ";
                        }
                        return "<a href='$url' target='_blank' class='text-blue-600 hover:underline'>Lihat File</a>";
                    })
                    ->html()
                    ->extraAttributes(['class' => 'text-left whitespace-nowrap']),

                Tables\Columns\TextColumn::make('link_berkas')
                    ->label('Link Sertifikat')
                    ->url(fn($record) => $record->link_berkas)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->extraAttributes(['class' => 'text-left']),

                Tables\Columns\TextColumn::make('foto_upp')
                    ->label('Foto Upacara')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '—';

                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        $url = Storage::url($state);

                        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            return "<img src='$url' alt='foto_upp' class='h-8 rounded-md object-cover' style='max-width: 80px;' />";
                        } elseif ($ext === 'pdf') {
                            return "
                            <a href='$url' target='_blank' class='flex items-center gap-1'>
                                <img src='https://cdn-icons-png.flaticon.com/512/337/337946.png' alt='PDF' class='h-6' />
                                <span class='text-sm text-blue-600 hover:underline'>Lihat PDF</span>
                            </a>
                        ";
                        }
                        return "<a href='$url' target='_blank' class='text-blue-600 hover:underline'>Lihat File</a>";
                    })
                    ->html()
                    ->extraAttributes(['class' => 'text-left whitespace-nowrap']),

                Tables\Columns\TextColumn::make('surat_tugas')
                    ->label('Surat Tugas')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '—';

                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        $url = Storage::url($state);

                        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            return "<img src='$url' alt='bukti' class='h-12 rounded-md object-cover' style='max-width: 100px;' />";
                        } elseif ($ext === 'pdf') {
                            return "
                            <a href='$url' target='_blank' class='flex items-center gap-1'>
                                <img src='https://cdn-icons-png.flaticon.com/512/337/337946.png' alt='PDF' class='h-6' />
                                <span class='text-sm text-blue-600 hover:underline'>Lihat PDF</span>
                            </a>
                        ";
                        }
                        return "<a href='$url' target='_blank' class='text-blue-600 hover:underline'>Lihat File</a>";
                    })
                    ->html()
                    ->extraAttributes(['class' => 'text-left whitespace-nowrap']),

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
