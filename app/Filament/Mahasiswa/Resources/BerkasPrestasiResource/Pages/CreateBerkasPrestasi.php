<?php

namespace App\Filament\Mahasiswa\Resources\BerkasPrestasiResource\Pages;

use App\Filament\Mahasiswa\Resources\BerkasPrestasiResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Prestasi;

class CreateBerkasPrestasi extends CreateRecord
{
    protected static string $resource = BerkasPrestasiResource::class;

    public function mount(): void
    {
        parent::mount();

        $prestasiId = request()->query('prestasi_id');

        if (! $prestasiId || ! Prestasi::find($prestasiId)) {
            Notification::make()
                ->title('Data prestasi belum ada')
                ->body('Silakan isi data prestasi terlebih dahulu sebelum mengisi berkas pendukung.')
                ->danger()
                ->persistent()
                ->send();

            $this->redirect(route('filament.mahasiswa.resources.prestasis.create'));
        }

        $this->form->fill([
            'prestasi_id' => $prestasiId,
        ]);
    }

    protected function afterCreate(): void
    {
        // Tandai prestasi sebagai lengkap
        $berkas = $this->record;
        Prestasi::where('id', $berkas->prestasi_id)->update([
            'is_complete' => true,
        ]);

        // Redirect ke halaman daftar prestasi atau halaman review
        $this->redirect(route('filament.mahasiswa.resources.prestasis.index'));
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $prestasiId = request()->query('prestasi_id');
        if ($prestasiId && Prestasi::find($prestasiId)) {
            $data['prestasi_id'] = $prestasiId;
        }
        return $data;
    }
}
