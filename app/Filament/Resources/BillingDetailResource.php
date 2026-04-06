<?php
namespace App\Filament\Resources;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\BillingDetail;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BillingDetailResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\BillingDetailResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class BillingDetailResource extends Resource
{
    protected static ?string $model = BillingDetail::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $modelLabel = 'Détail de facturation';         // singulier (1 enregistrement)
    protected static ?string $pluralModelLabel = 'Détails de facturation';  // pluriel  (liste)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label('ID utilisateur')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nom')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Adresse e-mail')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('billing_address')
                    ->label('Adresse de facturation')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ville')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Pays')
                    ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListBillingDetails::route('/'),
            'create' => Pages\CreateBillingDetail::route('/create'),
            'edit'   => Pages\EditBillingDetail::route('/{record}/edit'),
        ];
    }
}
