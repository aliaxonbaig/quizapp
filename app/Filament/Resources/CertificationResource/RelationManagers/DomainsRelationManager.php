<?php

namespace App\Filament\Resources\CertificationResource\RelationManagers;

use App\Filament\Resources\DomainResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'domains';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)->required()->columnSpanFull(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)->required()->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
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
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->wrap(),

            Tables\Columns\TextColumn::make('certification.name')
                ->sortable()
                ->searchable(),


            Tables\Columns\TextColumn::make('questions_count')
                ->counts('questions')
                ->label('Questions')
                ->sortable(),

            Tables\Columns\IconColumn::make('is_active')
                ->boolean(),

            Tables\Columns\TextColumn::make('certification.section.name')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),


            Tables\Columns\TextColumn::make('user.name')
            ->sortable()
            ->searchable()
            ->label('Author')
            ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
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
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => DomainResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
