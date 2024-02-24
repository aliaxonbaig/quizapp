<?php

namespace App\Filament\Resources\DomainResource\RelationManagers;

use App\Filament\Resources\QuestionResource;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('domain_id')
                    ->relationship('domain', 'name')
                    ->preload()
                    ->required()
                    ->placeholder('Not Selected'),

                Forms\Components\Toggle::make('is_active')
                    ->required(),

                Forms\Components\Textarea::make('question')
                    ->required()
                    ->maxLength(65535),
                SpatieMediaLibraryFileUpload::make('thumbnail')->collection('questions')
                    ->multiple()
                    ->reorderable()
                    ->label('Question Image'),
                Forms\Components\Textarea::make('explanation')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\Select::make('level')
                    ->options([
                        1 => 'Easy',
                        2 => 'Medium',
                        3 => 'Difficult'
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                ->wrap(),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('level')
                ->badge(fn (int $state): string => match ($state) {
                    1 => 'Easy',
                    2 => 'Medium',
                    3 => 'Hard',
                })
                ->sortable(),

                Tables\Columns\TextColumn::make('domain.name')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('domain.certification.name')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('domain.certification.section.name')
                ->sortable()
                ->searchable()
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
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => QuestionResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Toggle Status')
                    ->requiresConfirmation()
                    ->action(function (Collection $records): void {
                    foreach ($records as $record) {
                        $record->is_active = !$record->is_active;
                        $record->save();
                    }
                    Notification::make()
                        ->success()
                        ->title('Question Status toggled successfully!')
                        ->send();
                    })
                    ->icon('heroicon-m-arrows-right-left')
                    ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
