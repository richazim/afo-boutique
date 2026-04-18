<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = "Utilisateurs";

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Adresse e-mail')
                    ->required(),
                Forms\Components\TextInput::make('is_admin')
                    ->label('Administrateur')
                    ->required(),
            ]);
    }

    /**
     * Méthode permettant de overwrite la méthode Filament
     * permettant d'afficher un bouton créer pour 'Détail de facturation'
     * @return bool
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Adresse e-mail')
                    ->searchable()->sortable(),
                Tables\Columns\ToggleColumn::make('is_admin')
                    ->label('Administrateur')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->sortable()->date('M d H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->sortable()->date('M d H:i'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
