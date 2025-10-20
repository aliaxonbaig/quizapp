<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Lesson Materials';
    
    protected static ?string $navigationGroup = 'Teaching';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Material Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Week 5 - Network Security Slides')
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Brief description of the materials...')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('files')
                            ->label('Upload Files')
                            ->multiple()
                            ->directory('materials')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'application/zip',
                            ])
                            ->maxSize(10240) // 10MB per file
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->reorderable()
                            ->helperText('Upload PDF, Word, PowerPoint, images, or ZIP files (max 10MB each)')
                            ->columnSpanFull(),
                        
                        Forms\Components\Hidden::make('user_id')
                            ->default(auth()->id()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                
                Tables\Columns\TextColumn::make('files')
                    ->label('Files')
                    ->badge()
                    ->state(function (Material $record): string {
                        return count($record->files ?? []) . ' file(s)';
                    })
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Uploaded By')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'view' => Pages\ViewMaterial::route('/{record}'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
