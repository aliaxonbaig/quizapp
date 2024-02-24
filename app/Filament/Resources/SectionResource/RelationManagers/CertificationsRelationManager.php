<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use App\Filament\Resources\CertificationResource;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'certifications';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(150),

                Forms\Components\Toggle::make('is_active')
                    ->required(),

                Forms\Components\TextInput::make('description')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(200),

                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection('certification'),

                Forms\Components\MarkdownEditor::make('details')
                    ->required()
                    ->maxLength(65535)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                ->collection('certification'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('section.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->label('Author')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => CertificationResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
