<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\QuizHeaderResource\Pages;
use App\Filament\Member\Resources\QuizHeaderResource\RelationManagers;
use App\Models\QuizHeader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizHeaderResource extends Resource
{
    protected static ?string $model = QuizHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'My Quizzes';
    
    protected static ?string $modelLabel = 'Quiz';
    
    protected static ?string $pluralModelLabel = 'My Quizzes';
    
    protected static ?string $navigationGroup = 'Student Area';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Quiz Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('certification_id')
                            ->label('Major')
                            ->options(function () {
                                return auth()->user()->certifications_owned()
                                    ->pluck('name', 'certification_id');
                            })
                            ->required()
                            ->searchable()
                            ->helperText('You can only create quizzes for majors you are subscribed to'),
                        Forms\Components\Select::make('section_id')
                            ->label('Semester')
                            ->relationship('section', 'title')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('pass_score')
                            ->label('Pass Score (%)')
                            ->numeric()
                            ->default(70)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        Forms\Components\TextInput::make('duration')
                            ->label('Duration (minutes)')
                            ->numeric()
                            ->default(30)
                            ->minValue(1)
                            ->suffix('min'),
                    ])->columns(2),
                Forms\Components\Section::make('Quiz Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_private')
                            ->label('Private Quiz')
                            ->helperText('Private quizzes are only visible to you')
                            ->default(true)
                            ->reactive()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false),
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => auth()->id()),
                        Forms\Components\Hidden::make('is_student_created')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where(function ($q) {
                    // Show student's own quizzes
                    $q->where('user_id', auth()->id())
                    // OR show teacher-created quizzes in subscribed majors
                    ->orWhere(function ($subQ) {
                        $subQ->where('is_student_created', false)
                            ->whereIn('certification_id', auth()->user()->certifications_owned()->pluck('certification_id'));
                    })
                    // OR show approved student quizzes in subscribed majors
                    ->orWhere(function ($subQ) {
                        $subQ->where('is_student_created', true)
                            ->where('is_approved', true)
                            ->where('is_private', false)
                            ->whereIn('certification_id', auth()->user()->certifications_owned()->pluck('certification_id'));
                    });
                })
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('certification.title')
                    ->label('Major')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('section.title')
                    ->label('Semester')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('is_private')
                    ->label('Visibility')
                    ->formatStateUsing(fn ($state) => $state ? 'Private' : 'Public')
                    ->colors([
                        'warning' => fn ($state) => $state === true,
                        'success' => fn ($state) => $state === false,
                    ]),
                Tables\Columns\BadgeColumn::make('is_approved')
                    ->label('Status')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->is_student_created 
                            ? ($state ? 'Approved' : 'Pending') 
                            : 'Teacher Created'
                    )
                    ->colors([
                        'success' => fn ($state) => $state === true,
                        'warning' => fn ($state) => $state === false,
                        'primary' => fn ($state, $record) => !$record->is_student_created,
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => fn ($state) => $state === true,
                        'heroicon-o-clock' => fn ($state) => $state === false,
                        'heroicon-o-academic-cap' => fn ($state, $record) => !$record->is_student_created,
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('visibility')
                    ->options([
                        'private' => 'Private',
                        'public' => 'Public',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'private') {
                            $query->where('is_private', true);
                        } elseif ($data['value'] === 'public') {
                            $query->where('is_private', false);
                        }
                    }),
                Tables\Filters\SelectFilter::make('ownership')
                    ->options([
                        'mine' => 'My Quizzes',
                        'teacher' => 'Teacher Quizzes',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'mine') {
                            $query->where('user_id', auth()->id());
                        } elseif ($data['value'] === 'teacher') {
                            $query->where('is_student_created', false);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->user_id === auth()->id()),
                Tables\Actions\Action::make('request_approval')
                    ->label('Request Approval')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->visible(fn ($record) => 
                        $record->user_id === auth()->id() && 
                        $record->is_private && 
                        !$record->is_approved &&
                        !$record->approvalRequests()->where('status', 'pending')->exists()
                    )
                    ->form([
                        Forms\Components\Textarea::make('request_message')
                            ->label('Message to Teacher')
                            ->required()
                            ->rows(4)
                            ->helperText('Explain why this quiz should be made public'),
                    ])
                    ->action(function ($record, array $data) {
                        \App\Models\QuizApprovalRequest::create([
                            'quiz_header_id' => $record->id,
                            'user_id' => auth()->id(),
                            'request_message' => $data['request_message'],
                            'status' => 'pending',
                        ]);
                    })
                    ->successNotificationTitle('Approval request submitted!')
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->user_id === auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->authorize(fn () => true),
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
            'index' => Pages\ListQuizHeaders::route('/'),
            'create' => Pages\CreateQuizHeader::route('/create'),
            'view' => Pages\ViewQuizHeader::route('/{record}'),
            'edit' => Pages\EditQuizHeader::route('/{record}/edit'),
        ];
    }
}
