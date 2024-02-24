<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizHeaderResource\Pages;
use App\Models\QuizHeader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizHeaderResource extends Resource
{
    protected static ?string $model = QuizHeader::class;

    protected static ?string $navigationIcon = 'heroicon-s-rocket-launch';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'warning' : 'primary';
    }

    public static function canCreate(): bool {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'name')
                    ->required(),
                Forms\Components\Select::make('certification_id')
                    ->relationship('certification', 'name')
                    ->required(),
                Forms\Components\Textarea::make('domains')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('difficulty')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('learningmode')
                    ->required(),
                Forms\Components\Toggle::make('completed')
                    ->required(),
                Forms\Components\TextInput::make('quiz_size')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('questions_taken')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('certification.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('learningmode')
                    ->boolean(),
                Tables\Columns\IconColumn::make('completed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quiz_size')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListQuizHeaders::route('/'),
            'create' => Pages\CreateQuizHeader::route('/create'),
            'edit' => Pages\EditQuizHeader::route('/{record}/edit'),
        ];
    }
}
