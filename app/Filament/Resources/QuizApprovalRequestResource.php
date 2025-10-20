<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizApprovalRequestResource\Pages;
use App\Filament\Resources\QuizApprovalRequestResource\RelationManagers;
use App\Models\QuizApprovalRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizApprovalRequestResource extends Resource
{
    protected static ?string $model = QuizApprovalRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    
    protected static ?string $navigationLabel = 'Quiz Approvals';
    
    protected static ?string $modelLabel = 'Quiz Approval Request';
    
    protected static ?string $pluralModelLabel = 'Quiz Approval Requests';
    
    protected static ?string $navigationGroup = 'Student Content';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Quiz Information')
                    ->schema([
                        Forms\Components\Select::make('quiz_header_id')
                            ->label('Quiz')
                            ->relationship('quizHeader', 'title')
                            ->required()
                            ->searchable()
                            ->disabled(fn ($record) => $record !== null),
                        Forms\Components\Select::make('user_id')
                            ->label('Student')
                            ->relationship('user', 'name')
                            ->required()
                            ->disabled(fn ($record) => $record !== null),
                        Forms\Components\Textarea::make('request_message')
                            ->label('Student\'s Request Message')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('review_message')
                            ->label('Teacher\'s Review Message')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Provide feedback to the student'),
                        Forms\Components\Hidden::make('reviewed_by')
                            ->default(fn () => auth()->id()),
                        Forms\Components\Hidden::make('reviewed_at')
                            ->default(fn ($get) => $get('status') !== 'pending' ? now() : null),
                    ])
                    ->visible(fn ($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quizHeader.title')
                    ->label('Quiz Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_message')
                    ->label('Request')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->request_message),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewed By')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Reviewed At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);
                        $record->quizHeader->update([
                            'is_approved' => true,
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                    }),
                Tables\Actions\Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('review_message')
                            ->label('Reason for rejection')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                            'review_message' => $data['review_message'],
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListQuizApprovalRequests::route('/'),
            'create' => Pages\CreateQuizApprovalRequest::route('/create'),
            'view' => Pages\ViewQuizApprovalRequest::route('/{record}'),
            'edit' => Pages\EditQuizApprovalRequest::route('/{record}/edit'),
        ];
    }
}
