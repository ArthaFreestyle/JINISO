<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewsResource\Pages;
use App\Filament\Resources\ProductReviewsResource\RelationManagers;
use App\Models\ProductReviews;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductReviewsResource extends Resource
{
    protected static ?string $model = ProductReviews::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\BelongsToSelect::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\BelongsToSelect::make('product_id')
                    ->relationship('product', 'product_name')
                    ->required(),
                Forms\Components\TextInput::make('rating')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductReviews::route('/'),
            'create' => Pages\CreateProductReviews::route('/create'),
            'edit' => Pages\EditProductReviews::route('/{record}/edit'),
        ];
    }
}
