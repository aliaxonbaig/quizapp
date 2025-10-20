<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    
    protected static ?string $navigationLabel = 'Users (Teachers & Students)';
    
    protected static ?string $modelLabel = 'User';
    
    protected static ?string $pluralModelLabel = 'Users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at'),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),

                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                    
                Forms\Components\Section::make('Student Major Subscriptions')
                    ->schema([
                        Forms\Components\Select::make('certifications')
                            ->label('Assign Majors to Student')
                            ->relationship('certifications_owned', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Assign majors (certifications) to this student. They will have access to all quizzes in these majors.')
                            ->columnSpanFull(),
                    ])
                    ->description('Manage which majors this student can access')
                    ->collapsible()
                    ->visible(fn ($record) => $record && $record->hasRole('student')),

                // Forms\Components\Section::make('Roles')->schema([
                //     Forms\Components\CheckboxList::make('roles')->relationship('roles','name'),
                // ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->colors([
                        'success' => 'teacher',
                        'primary' => 'student',
                    ]),
                Tables\Columns\TextColumn::make('certifications_owned.name')
                    ->label('Majors')
                    ->badge()
                    ->color('warning')
                    ->limit(2)
                    ->tooltip(fn ($record) => $record->certifications_owned->pluck('name')->join(', '))
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_login')
                    ->dateTime()
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
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->relationship('roles', 'name')
                    ->preload(),
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('User Active ?')
                    ->options([
                        true => 'Yes',
                        false => 'No',
                    ]),
                Tables\Filters\Filter::make('has_subscriptions')
                    ->label('Has Major Subscriptions')
                    ->query(fn (Builder $query) => 
                        $query->has('certifications_owned')
                    ),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 5 ? 'warning' : 'primary';
    }
}
