<?php

namespace App\Filament\Mahasiswa\Resources\PrestasiResource\Pages;

use App\Filament\Mahasiswa\Resources\PrestasiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Session;
use Filament\Actions\CreateAction;

class ListPrestasis extends ListRecords
{
    protected static string $resource = PrestasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        // Jangan deklarasikan defaultAction, langsung set aja:
        if (!session()->has('prestasi_modal_shown')) {
            $this->defaultAction = 'modalNotification'; // ✅ tetap bisa di-set
            session()->put('prestasi_modal_shown', true);
        }
    }

    public function modalNotification(): Action
    {
        return Action::make('modalNotification')
            ->modalSubmitActionLabel('Mengerti')
            ->modalCancelAction(false)
            ->color('primary')
            ->modalHeading('Informasi Penting')
            ->modalContent(view('modals.modal-info-prestasi'));
    }
}
