<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\MyQuizzesResource\Pages;
use App\Models\MyQuizzes;
use App\Models\QuizHeader;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MyQuizzesResource extends Resource
{
    protected static ?string $model = MyQuizzes::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function getNavigationBadge(): ?string
    {
        return QuizHeader::where('user_id',auth()->id())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'warning' : 'primary';
    }
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    protected static ?string $title = 'My Quizzies';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function canCreate(): bool {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('certification.name')
                ->numeric()
                ->sortable()
                ->alignment(Alignment::Start),
            Tables\Columns\TextColumn::make('score')
                ->numeric()
                ->suffix('%')
                ->sortable()
                ->alignment(Alignment::Start),
            Tables\Columns\TextColumn::make('quiz_size')
                ->label('Questions')
                ->badge()
                ->alignment(Alignment::Start),
            Tables\Columns\TextColumn::make('status')
                ->state(function (Model $record): string {
                    return $record->score >= 70.0 ? 'Passed' : 'Failed';
                })
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Passed' => 'success',
                    'Failed' => 'danger',
                })
                ->tooltip('Scores above 70% are considered passed!'),
            Tables\Columns\TextColumn::make('domains')
                ->badge(),
            Tables\Columns\IconColumn::make('learningmode')
                ->boolean()
                ->grow(false),
            Tables\Columns\IconColumn::make('completed')
                ->boolean()
                ->grow(false),
            Tables\Columns\TextColumn::make('section.name')
                ->numeric()
                ->sortable()
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
                Action::make('view')
                ->action(fn ($record) => redirect()->route('filament.member.pages.quiz-detail-page', ['record' => $record]))
                ->icon('heroicon-m-rocket-launch')
                ->iconButton(),
                Tables\Actions\DeleteAction::make()
                ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListMyQuizzes::route('/'),
        ];
    }
}
