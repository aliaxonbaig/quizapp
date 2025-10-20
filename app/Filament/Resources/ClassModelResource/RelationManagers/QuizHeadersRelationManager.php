<?php

namespace App\Filament\Resources\ClassModelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizHeadersRelationManager extends RelationManager
{
    protected static string $relationship = 'quizHeaders';
    
    protected static ?string $title = 'Student Quiz Results';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('score')
                    ->disabled()
                    ->suffix('%'),
                
                Forms\Components\TextInput::make('quiz_size')
                    ->disabled()
                    ->label('Questions'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Quiz Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->badge()
                    ->color(function ($record): string {
                        if ($record->score >= 90) return 'success';
                        if ($record->score >= 75) return 'warning';
                        return 'danger';
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%'),
                
                Tables\Columns\TextColumn::make('quiz_size')
                    ->label('Questions')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Completed')
                    ->dateTime('M d, Y g:i A')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('learningmode')
                    ->label('Learning Mode')
                    ->boolean()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Student')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Existing Quiz')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'user.name'])
                    ->recordTitle(fn ($record) => $record->user->name . ' - ' . $record->name),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.my-quizzes.view', $record)),
                Tables\Actions\DetachAction::make()
                    ->label('Remove from Class'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->defaultSort('user.name')
            ->groupedBulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ])
            ->emptyStateHeading('No student quizzes yet')
            ->emptyStateDescription('Add existing quiz results to this class by clicking "Add Existing Quiz".');
    }
}
