<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassModelResource\Pages;
use App\Filament\Resources\ClassModelResource\RelationManagers;
use App\Models\ClassModel;
use App\Models\Certification;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClassModelResource extends Resource
{
    protected static ?string $model = ClassModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationLabel = 'Classes';
    
    protected static ?string $modelLabel = 'Class';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Class Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., CISSP Exam - October 17, 2025')
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Optional description of this class session')
                            ->columnSpanFull(),
                        
                        Forms\Components\DatePicker::make('test_date')
                            ->label('Test Date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->default(now()),
                        
                        Forms\Components\TimePicker::make('test_time')
                            ->label('Test Time')
                            ->seconds(false)
                            ->native(false),
                        
                        Forms\Components\Select::make('certification_id')
                            ->label('Certification')
                            ->options(Certification::pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Select::make('domains')
                            ->label('Domains Covered')
                            ->multiple()
                            ->options(Domain::pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive classes are archived and hidden from the main list'),
                        
                        Forms\Components\Hidden::make('teacher_id')
                            ->default(Auth::id()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (ClassModel $record): ?string => $record->description),
                
                Tables\Columns\TextColumn::make('test_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('student_count')
                    ->label('Students')
                    ->badge()
                    ->color('info')
                    ->state(fn (ClassModel $record): string => $record->student_count . ' student(s)'),
                
                Tables\Columns\TextColumn::make('quiz_count')
                    ->label('Quizzes')
                    ->badge()
                    ->color('success')
                    ->state(fn (ClassModel $record): string => $record->quizHeaders()->count() . ' quiz(zes)'),
                
                Tables\Columns\TextColumn::make('average_score')
                    ->label('Avg Score')
                    ->badge()
                    ->color(function (ClassModel $record): string {
                        $avg = $record->average_score;
                        if ($avg >= 90) return 'success';
                        if ($avg >= 75) return 'warning';
                        return 'danger';
                    })
                    ->state(fn (ClassModel $record): string => number_format($record->average_score, 1) . '%'),
                
                Tables\Columns\TextColumn::make('certification.name')
                    ->label('Certification')
                    ->toggleable()
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('certification_id')
                    ->label('Certification')
                    ->options(Certification::pluck('name', 'id')),
                
                Tables\Filters\Filter::make('is_active')
                    ->label('Active Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('test_date', 'desc')
            ->emptyStateHeading('No Classes Yet')
            ->emptyStateDescription('Create your first class to organize student quiz results.')
            ->emptyStateIcon('heroicon-o-academic-cap');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuizHeadersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassModels::route('/'),
            'create' => Pages\CreateClassModel::route('/create'),
            'view' => Pages\ViewClassModel::route('/{record}'),
            'edit' => Pages\EditClassModel::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('teacher_id', Auth::id());
    }
}
