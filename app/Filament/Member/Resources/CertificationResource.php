<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\CertificationResource\Pages;
use App\Models\Certification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Available Majors';
    protected static ?string $modelLabel = 'Major';
    protected static ?string $pluralModelLabel = 'Available Majors';
    protected static ?string $navigationGroup = 'Student Area';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Major Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Major Name')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),
                        Forms\Components\Textarea::make('details')
                            ->label('Details')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->description('View major information. Subscribe to access quizzes.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Major Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('md'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(60)
                    ->wrap(),
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Semester')
                    ->sortable()
                    ->badge(),
                Tables\Columns\IconColumn::make('subscribed')
                    ->label('Subscribed')
                    ->boolean()
                    ->getStateUsing(fn ($record) => 
                        $record->users()->where('user_id', auth()->id())->exists()
                    )
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
            ])
            ->filters([
                Tables\Filters\Filter::make('subscribed')
                    ->label('My Subscriptions')
                    ->query(fn (Builder $query) => 
                        $query->whereHas('users', fn ($q) => $q->where('user_id', auth()->id()))
                    ),
                Tables\Filters\SelectFilter::make('section')
                    ->label('Filter by Semester')
                    ->relationship('section', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details'),
                Tables\Actions\Action::make('subscribe')
                    ->label('Subscribe')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->visible(fn ($record) => 
                        !$record->users()->where('user_id', auth()->id())->exists()
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Subscribe to Major')
                    ->modalDescription(fn ($record) => "Subscribe to {$record->name}? You'll get access to all quizzes in this major.")
                    ->action(function ($record) {
                        $record->users()->attach(auth()->id());
                    })
                    ->successNotificationTitle('Successfully subscribed!')
                    ->successNotification(
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Successfully subscribed!')
                            ->body('You can now access quizzes in this major.')
                    ),
                Tables\Actions\Action::make('unsubscribe')
                    ->label('Unsubscribe')
                    ->icon('heroicon-o-minus-circle')
                    ->color('danger')
                    ->visible(fn ($record) => 
                        $record->users()->where('user_id', auth()->id())->exists()
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Unsubscribe from Major')
                    ->modalDescription(fn ($record) => "Are you sure you want to unsubscribe from {$record->name}?")
                    ->action(function ($record) {
                        $record->users()->detach(auth()->id());
                    })
                    ->successNotificationTitle('Successfully unsubscribed')
                    ->successNotification(
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Successfully unsubscribed')
                            ->body('You no longer have access to quizzes in this major.')
                    ),
            ])
            ->bulkActions([])
            ->emptyStateHeading('No Majors Available')
            ->emptyStateDescription('There are no active majors at this time. Check back later!')
            ->emptyStateIcon('heroicon-o-academic-cap');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertifications::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
