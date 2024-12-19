<?php

namespace App\Filament\Resources\ProductReviewsResource\Pages;

use App\Filament\Resources\ProductReviewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductReviews extends EditRecord
{
    protected static string $resource = ProductReviewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
