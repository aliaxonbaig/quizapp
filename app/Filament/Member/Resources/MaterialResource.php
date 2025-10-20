<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\MaterialResource\Pages;
use App\Filament\Member\Resources\MaterialResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    
    protected static ?string $navigationLabel = 'Study Materials';
    
    protected static ?int $navigationSort = 10;

    // Students can only view, not create or edit
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Material Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->disabled()
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description')
                            ->disabled()
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Placeholder::make('uploaded_by')
                            ->label('Uploaded By')
                            ->content(fn ($record) => $record->user->name),
                        
                        Forms\Components\Placeholder::make('uploaded_at')
                            ->label('Uploaded On')
                            ->content(fn ($record) => $record->created_at->format('M d, Y h:i A')),
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
                    ->weight('bold')
                    ->description(fn (Material $record): ?string => $record->description),
                
                Tables\Columns\TextColumn::make('files')
                    ->label('Files Available')
                    ->badge()
                    ->state(function (Material $record): string {
                        return count($record->files ?? []) . ' file(s)';
                    })
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Uploaded By')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View & Download')
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                // No bulk actions for students
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No Materials Available')
            ->emptyStateDescription('Your teachers haven\'t uploaded any study materials yet.')
            ->emptyStateIcon('heroicon-o-folder-open');
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
            'view' => Pages\ViewMaterial::route('/{record}'),
        ];
    }
}
