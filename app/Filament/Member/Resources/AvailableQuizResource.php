<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\AvailableQuizResource\Pages;
use App\Filament\Member\Resources\AvailableQuizResource\RelationManagers;
use App\Models\QuizHeader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailableQuizResource extends Resource
{
    protected static ?string $model = QuizHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    
    protected static ?string $navigationLabel = 'Browse Quizzes';
    
    protected static ?string $modelLabel = 'Available Quiz';
    
    protected static ?string $pluralModelLabel = 'Browse Quizzes';
    
    protected static ?string $navigationGroup = 'Quizzes';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Quiz Information')
                    ->schema([
                        Forms\Components\TextInput::make('certification.name')
                            ->label('Major')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('quiz_size')
                            ->label('Questions')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->disabled()
                            ->dehydrated(false)
                            ->suffix('%'),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Created By')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('completed', true)
                    ->where(function ($q) {
                        // Get user's subscribed certifications/majors
                        $userCertifications = auth()->user()->certifications_owned()->pluck('certification_id');
                        
                        // Only show quizzes from subscribed majors
                        $q->whereIn('certification_id', $userCertifications)
                            ->where(function ($subQ) {
                                // Show ALL teacher-created quizzes
                                $subQ->where('is_student_created', false)
                                    // OR show approved public student quizzes
                                    ->orWhere(function ($studentQ) {
                                        $studentQ->where('is_student_created', true)
                                            ->where('is_approved', true)
                                            ->where('is_private', false);
                                    });
                            });
                    })
            )
            ->columns([
                Tables\Columns\TextColumn::make('certification.name')
                    ->label('Major')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->description(fn ($record) => 'Quiz #' . $record->id),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quiz_size')
                    ->label('Questions')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn ($state) => $state >= 70 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('domains')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('learningmode')
                    ->label('Learning Mode')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('source')
                    ->label('Source')
                    ->getStateUsing(fn ($record) => 
                        $record->is_student_created ? 'Student' : 'Teacher'
                    )
                    ->colors([
                        'primary' => 'Teacher',
                        'warning' => 'Student',
                    ])
                    ->icons([
                        'heroicon-o-academic-cap' => 'Teacher',
                        'heroicon-o-user' => 'Student',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Taken')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('certification_id')
                    ->label('Filter by Major')
                    ->options(function () {
                        return auth()->user()->certifications_owned()
                            ->pluck('name', 'certification_id');
                    })
                    ->preload(),
                Tables\Filters\Filter::make('source')
                    ->form([
                        Forms\Components\Select::make('source')
                            ->label('Quiz Source')
                            ->options([
                                'teacher' => 'Teacher Created',
                                'student' => 'Student Created',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['source'] === 'teacher') {
                            $query->where('is_student_created', false);
                        } elseif ($data['source'] === 'student') {
                            $query->where('is_student_created', true);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => route('filament.member.pages.quiz-detail-page', ['record' => $record->id]))
                    ->openUrlInNewTab(false),
            ])
            ->bulkActions([
                // No bulk actions for browsing quizzes
            ])
            ->emptyStateHeading('No Quizzes Available')
            ->emptyStateDescription('Subscribe to majors to see available quizzes!')
            ->emptyStateIcon('heroicon-o-book-open');
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
            'index' => Pages\ListAvailableQuizzes::route('/'),
            'view' => Pages\ViewAvailableQuiz::route('/{record}'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false; // Students create quizzes in "My Quizzes"
    }
    
    public static function canEdit($record): bool
    {
        return false; // Read-only for browsing
    }
    
    public static function canDelete($record): bool
    {
        return false; // Cannot delete browsable quizzes
    }
}
