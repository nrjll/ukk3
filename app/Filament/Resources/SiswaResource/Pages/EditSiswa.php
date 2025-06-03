<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        // Tombol Delete hanya muncul jika siswa belum membuat laporan PKL
        if (!$this->record->status_lapor_pkl && !$this->record->pkls()->exists()) {
            $actions[] = Actions\DeleteAction::make()
                ->before(function () {
                    // Double check sebelum delete
                    if ($this->record->pkls()->exists()) {
                        Notification::make()
                            ->title('Tidak dapat menghapus siswa')
                            ->body('Siswa ini memiliki data PKL yang terkait.')
                            ->danger()
                            ->send();
                        
                        return false; // Cancel deletion
                    }
                });
        }
        
        return $actions;
    }
}
