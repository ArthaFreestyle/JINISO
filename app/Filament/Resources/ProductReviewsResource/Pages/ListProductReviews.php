<?php

namespace App\Filament\Resources\ProductReviewsResource\Pages;

use App\Filament\Resources\ProductReviewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductReviews extends ListRecords
{
    protected static string $resource = ProductReviewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
