<?php

namespace App\Filament\Resources\EvaluasiPrestasiResource\Pages;

use App\Filament\Resources\EvaluasiPrestasiResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEvaluasiPrestasi extends EditRecord
{
    protected static string $resource = EvaluasiPrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return []; // Hilangkan tombol Delete di atas
    }
    public function getTitle(): string
    {
        return 'Evaluasi Data';
    }

    public function getBreadcrumb(): string
    {
        return 'Evaluasi Data';
    }
    protected function getFormActions(): array
    {
        return [

            Action::make('Terima')
                ->extraAttributes(['style' => 'background-color: #69084D; border-color: #69084D; color: white;'])
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->update([
                        'status' => 'approved',
                        'pesan_admin' => 'Prestasi diterima oleh admin.',
                    ]);

                    $recipient = $this->record->mahasiswa->user;

                    Notification::make()
                        ->title('Prestasi "' . $this->record->nama_prestasi . '" telah disetujui')
                        ->body($this->record->pesan_admin)
                        ->success()
                        ->sendToDatabase($recipient, isEventDispatched: true);

                    $this->redirect(EvaluasiPrestasiResource::getUrl());
                }),

            // Tombol Tolak
            Action::make('Tolak')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->form([
                    \Filament\Forms\Components\Textarea::make('pesan_admin')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->maxLength(1000),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => 'rejected',
                        'pesan_admin' => $data['pesan_admin'],
                    ]);

                    $recipient = $this->record->mahasiswa->user;

                    Notification::make()
                        ->title('Prestasi "' . $this->record->nama_prestasi . '" ditolak')
                        ->body($this->record->pesan_admin)
                        ->danger()
                        ->sendToDatabase($recipient, isEventDispatched: true);

                    $this->redirect(EvaluasiPrestasiResource::getUrl());
                }),



        ];
    }
}
