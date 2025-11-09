<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hash del password antes de crear el usuario
        $data['password'] = Hash::make($data['password']);
        
        // Remover password_confirmation ya que no se guarda en la base de datos
        unset($data['password_confirmation']);
        
        return $data;
    }
}
