<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\BillProduct;
use App\Models\Building;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        $toBuilding = Building::all();
        $product = $this->record;

        foreach ($toBuilding as $building) {
            BillProduct::insert([
                'building_id' => $building->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'period' => $product->period,
                'price' => $product->price
            ]);
        }
    }
}
