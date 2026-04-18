<?php
namespace App\Filament\Resources;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Events\OrderStatusChanged;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $modelLabel = "Commandes";
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending'    => 'En attente',
                        'processing' => 'En cours',
                        'completed'  => 'Terminée',
                        'canceled'   => 'Annulée',
                    ])
                    ->required(),
                Forms\Components\Fieldset::make('user_id')
                    ->relationship('user')
                    ->label('Client')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Adresse e-mail')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')
                    ->label('ID client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nom du client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('E-mail du client')
                    ->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut de la commande')
                    ->enum([
                        'pending'    => 'En attente',
                        'processing' => 'En cours',
                        'completed'  => 'Terminée',
                        'canceled'   => 'Annulée',
                    ])
                    ->colors([
                        'secondary' => 'pending',
                        'warning'   => 'processing',
                        'success'   => 'completed',
                        'danger'    => 'canceled',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->prefix('$')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
                    ->sortable()->date('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifiée le')
                    ->sortable()->date('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export'),
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
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
