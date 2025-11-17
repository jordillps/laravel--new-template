<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Helpers\SettingsHelper;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $changes = [];
        
        // Verificar cambios específicos
        if ($this->record->wasChanged('app_name')) {
            $changes[] = 'nombre de la aplicación';
            config(['app.name' => $this->record->app_name]);
        }
        
        if ($this->record->wasChanged('app_logo')) {
            $changes[] = 'logo de la aplicación';
        }
        
        if ($this->record->wasChanged('app_favicon')) {
            $changes[] = 'favicon';
        }
        
        // Mostrar notificación específica según cambios
        if (!empty($changes)) {
            $message = 'Se ha actualizado correctamente: ' . implode(', ', $changes);
            
            Notification::make()
                ->title('Configuración actualizada')
                ->body($message)
                ->success()
                ->send();
        } elseif ($this->record->wasChanged()) {
            Notification::make()
                ->title('Configuración guardada')
                ->body('Los cambios se han aplicado correctamente.')
                ->success()
                ->send();
        }
    }
}
