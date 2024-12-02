<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdersResource\Pages;
use App\Models\Orders;
use App\Models\PromoCode;
use App\Models\OrderDetails;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;


class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Wizard::make()
                    ->schema([
                        Step::make('Order Information')
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required(),
                                DatePicker::make('order_date')
                                    ->required(),
                                TextInput::make('total_amount')
                                    ->numeric()
                                    ->required()
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                        $details = $get('details');
                                        $discount = $get('promo_code_id');

                                        $total = 0;
                                        foreach ($details as $detail) {
                                            $total += $detail['subtotal'];
                                        }
                                        if ($discount) {
                                            $promo = PromoCode::find($discount);
                                            if ($promo) {
                                                $total -= $promo->discount_amount;
                                            }
                                        }
                                        $set('total_amount', $total);
                                    }),
                                Select::make('promo_code_id')
                                    ->relationship('promo', 'code')
                                    ->searchable()
                                    ->nullable()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $promo = PromoCode::find($state);
                                        if ($promo) {
                                            $set('total_amount', $promo->discount_amount);
                                        }
                                    }),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),
                            ]),
                        Step::make('Order Details')
                            ->schema([
                                Repeater::make('details')
                                    ->relationship('details')
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('Product')
                                            ->relationship('product', 'product_name')
                                            ->required()
                                            ->afterStateUpdated(function (callable $set, $state) {
                                                
                                                $product = Products::find($state);
                                                if ($product) {
                                                    $set('price', $product->price);
                                                }
                                            }),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                                $price = $get('price') ?? 0;
                                                $set('subtotal', $state * $price);
                                            }),
                                        TextInput::make('price')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                                $quantity = $get('quantity') ?? 0;
                                                $set('subtotal', $state * $quantity);
                                            }),
                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->required(),
                                    ])
                                    ->required(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('details.product.thumbnail'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('order_id'),
                Tables\Columns\TextColumn::make('status'),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function(Orders $order){
                    $order->update([
                        'status' => 'completed'
                    ]);
                    Notification::make()
                    ->title('Order Approved')
                    ->success()
                    ->body('Order has been approved successfully')
                    ->send();
                }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
        ];
    }
}
