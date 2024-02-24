<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-m-rectangle-stack';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 0;

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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Status'),

                Forms\Components\TextInput::make('description')->columnSpanFull()
                    ->required()
                    ->maxLength(255),

                Forms\Components\MarkdownEditor::make('details')
                    ->required()
                    ->maxLength(65535),

                SpatieMediaLibraryFileUpload::make('thumbnail')->collection('sections')
                ->reorderable()
                ->image()
                ->label('Section Image'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                ->collection('sections'),

                Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->wrap(),

                Tables\Columns\TextColumn::make('certifications_count')
                ->counts('certifications')
                ->label('Certifications')
                ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('user.name')
                ->sortable()
                ->searchable()
                ->label('Author')
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
                Tables\Filters\SelectFilter::make('is_active')
                ->label('Published?')
                ->options([
                    true => 'Yes',
                    false => 'No',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\CertificationsRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
