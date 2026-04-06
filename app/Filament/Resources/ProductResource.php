<?php
namespace App\Filament\Resources;
use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\CategoryResource\RelationManagers\CategoriesRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel = "Produits";
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Forms\Components\TextInput::make('SKU')
                    ->label('SKU')
                    ->helperText('Le SKU doit être au format SKU-####')
                    ->regex('/SKU-\d{4}/')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->prefix('$')
                    ->rules(['min:0'])
                    ->required(),
                Forms\Components\TextInput::make('old_price')
                    ->label('Ancien prix')
                    ->numeric()
                    ->prefix('$')
                    ->rules(['min:0'])
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantité')
                    ->numeric(),
                Forms\Components\TextInput::make('brief_description')
                    ->label('Description courte')
                    ->rules(['min:10', 'max:100'])
                    ->required(),
                Forms\Components\Select::make('stock_status')
                    ->label('État du stock')
                    ->options([
                        'instock'  => 'En stock',
                        'outstock' => 'Rupture de stock',
                    ])
                    ->default('instock'),
                Forms\Components\FileUpload::make('image')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/main_image/' . $name[0] . '.' . $name[1]);
                    })
                    ->label('Image principale')
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),
                Forms\Components\FileUpload::make('images')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/alt_images/' . $name[0] . '.' . $name[1]);
                    })
                    ->columnSpan('full')
                    ->label('Images secondaires')
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->maxLength(1000)
                    ->columnSpan('full')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ]),
                Forms\Components\CheckboxList::make('categories')
                    ->label('Catégories')
                    ->columnSpan('full')
                    ->relationship('categories', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                FilamentExportHeaderAction::make('export'),
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('SKU')
                    ->label('SKU')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->prefix('$')->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantité')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->sortable()->date('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
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
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
