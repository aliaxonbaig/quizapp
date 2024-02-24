<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-s-puzzle-piece';

    protected static bool $shouldRegisterNavigation = false;

    public static function canCreate(): bool {
        return false;
    }

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
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
                    ->image()
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

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
