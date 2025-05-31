<?php

namespace App\Filament\Resources\EvaluasiPrestasiResource\Pages;

use App\Filament\Resources\EvaluasiPrestasiResource;
use App\Models\Prestasi;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class ReviewEvaluasiPrestasi extends EditRecord
{
    protected static string $resource = EvaluasiPrestasiResource::class;

    public function mount($record): void
    {
        parent::mount($record);
        // Load relasi agar data berkas & mahasiswa tersedia
        $this->record = Prestasi::with('berkasPrestasi', 'mahasiswa.user')->findOrFail($this->record->id);
    }

    public function getTitle(): string
    {
        return 'Review Prestasi: ' . $this->record->nama_prestasi;
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Setujui')
                ->color('success')
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'approved',
                        'pesan_admin' => $data['pesan_admin'] ?? null,
                    ]);
                    $this->notify('success', 'Prestasi disetujui.');
                    $this->redirect(EvaluasiPrestasiResource::getUrl());
                }),

            Action::make('reject')
                ->label('Tolak')
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Textarea::make('pesan_admin')
                        ->label('Alasan Penolakan')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'rejected',
                        'pesan_admin' => $data['pesan_admin'],
                    ]);
                    $this->notify('success', 'Prestasi ditolak.');
                    $this->redirect(EvaluasiPrestasiResource::getUrl());
                }),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Data Mahasiswa')
                ->schema([
                    Forms\Components\Placeholder::make('mahasiswa')
                        ->label('Nama Mahasiswa')
                        ->content($this->record->mahasiswa?->user?->name ?? '-'),
                ]),

            Forms\Components\Section::make('Data Prestasi')
                ->schema([
                    Forms\Components\Placeholder::make('nama_prestasi')->label('Nama Prestasi')->content($this->record->nama_prestasi),
                    Forms\Components\Placeholder::make('tingkat')->label('Tingkat')->content($this->record->tingkat),
                    Forms\Components\Placeholder::make('jenis_juara')->label('Jenis Juara')->content($this->record->jenis_juara),
                    Forms\Components\Placeholder::make('kategori_prestasi')->label('Kategori')->content($this->record->kategori_prestasi),
                    Forms\Components\Placeholder::make('tanggal')->label('Tanggal')->content("{$this->record->tanggal_mulai} s/d {$this->record->tanggal_selesai}"),
                ]),

            Forms\Components\Section::make('Berkas Pendukung')
                ->schema($this->generateBerkasFields()),

            Forms\Components\Section::make('Evaluasi Admin')
                ->schema([
                    Forms\Components\Textarea::make('pesan_admin')
                        ->label('Catatan Evaluasi')
                        ->rows(4)
                        ->disabled(fn() => $this->record->status !== 'diajukan'),
                ]),
        ];
    }

    private function generateBerkasFields(): array
    {
        $fields = [];
        $berkas = $this->record->berkasPrestasi;

        $files = [
            'bukti_berkas' => 'Bukti Berkas',
            'foto_upp' => 'Foto Penyerahan',
            'surat_tugas' => 'Surat Tugas / Izin',
        ];

        foreach ($files as $field => $label) {
            $filePath = $berkas?->$field;

            if ($filePath) {
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $url = Storage::url($filePath);

                if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $fields[] = Forms\Components\Placeholder::make($field)
                        ->label($label)
                        ->content("<img src='{$url}' alt='{$label}' class='w-64 rounded shadow mt-2'>");
                } elseif ($ext === 'pdf') {
                    $fields[] = Forms\Components\Placeholder::make($field)
                        ->label($label)
                        ->content("<embed src='{$url}' type='application/pdf' class='w-full h-96 rounded shadow mt-2'>");
                } else {
                    $fields[] = Forms\Components\Placeholder::make($field)
                        ->label($label)
                        ->content("<a href='{$url}' target='_blank' class='text-blue-600 underline'>Lihat File</a>");
                }
            } else {
                $fields[] = Forms\Components\Placeholder::make($field)
                    ->label($label)
                    ->content('<span class="text-gray-400 italic">Tidak ada file</span>');
            }
        }

        if ($berkas?->link_berkas) {
            $fields[] = Forms\Components\Placeholder::make('link_berkas')
                ->label('Link Berkas')
                ->content("<a href='{$berkas->link_berkas}' target='_blank' class='text-blue-600 underline'>Buka Link</a>");
        }

        return $fields;
    }
}
