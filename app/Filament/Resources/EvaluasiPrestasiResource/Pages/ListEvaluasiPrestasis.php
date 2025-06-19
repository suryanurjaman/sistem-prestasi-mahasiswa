<?php

namespace App\Filament\Resources\EvaluasiPrestasiResource\Pages;

use App\Filament\Resources\EvaluasiPrestasiResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;

use Filament\Resources\Pages\ListRecords;

class ListEvaluasiPrestasis extends ListRecords
{
    protected static string $resource = EvaluasiPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('primary')
                ->action(function () {
                    // ✅ Ambil data dari query yang sudah difilter user
                    $records = $this->getFilteredSortedTableQuery()
                        ->with(['mahasiswa.user', 'mahasiswa.prodi', 'mahasiswa.fakultas'])
                        ->get();

                    $pdf = Pdf::loadView('filament.export.evaluasi_prestasi', compact('records'));

                    $filename = 'evaluasi-prestasi-' . now()->format('Ymd_His') . '.pdf';

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        $filename,
                    );
                }),
        ]);
    }
}
