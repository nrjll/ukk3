<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (!$this->record->status_lapor_pkl && !$this->record->pkls()->exists()) {
            $actions[] = Actions\DeleteAction::make()
                ->before(function () {
                    // Double check sebelum delete
                    if ($this->record->pkls()->exists()) {
                        Notification::make()
                            ->title('Tidak dapat menghapus guru')
                            ->body('Guru ini memiliki data PKL yang terkait.')
                            ->danger()
                            ->send();
                        
                        return false; // Cancel deletion
                    }
                });
        }

        return $actions;
    }
}