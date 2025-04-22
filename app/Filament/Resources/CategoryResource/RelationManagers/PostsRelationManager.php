<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    Select::make('category_id')
                        ->relationship(name: 'category', titleAttribute: 'name')
                        ->label('Sélectionnez la catégorie de l\'article')
                        ->required(),
                    TextInput::make('title')
                        ->label('Titre')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->readOnly(),
                    Select::make('tags')
                        ->multiple()
                        ->relationship(name: 'tags', titleAttribute: 'name')
                        ->label('Mots clés')
                        ->preload()
                        ->required(),                        
                    Textarea::make('description')
                        ->rows(3)
                        ->maxLength(160)
                        ->required(),
                    FileUpload::make('media')
                        ->label('Image mis en avant')
                        ->image()
                        ->required(),
                    Toggle::make('is_published')
                        ->label('Rendre publique l\'article'),
                    RichEditor::make('content')
                        ->label('Contenu de l\'article')
                        ->required(),
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')
                    ->label('titre')
                    ->limit(50)
                    ->description(fn (Post $record): string => $record->description)   
                    ->sortable(),
                ToggleColumn::make('is_published')->label('publié'),
                /*TextColumn::make('content')
                    ->limit(50)
                    ->html(),*/
                TextColumn::make('created_at')->sortable(),
                TextColumn::make('updated_at')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
