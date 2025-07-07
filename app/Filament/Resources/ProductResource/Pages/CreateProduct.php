<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth; // ✅ tambahkan ini

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user(); // ✅ gunakan Auth facade
        $data['created_by'] = $user?->id;
        $data['updated_by'] = $user?->id;
        return $data;
    }
}
