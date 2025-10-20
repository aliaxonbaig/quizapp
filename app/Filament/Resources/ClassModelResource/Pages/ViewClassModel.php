<?php

namespace App\Filament\Resources\ClassModelResource\Pages;

use App\Filament\Resources\ClassModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Tables\Table;
use Filament\Tables;
use App\Models\QuizHeader;

class ViewClassModel extends ViewRecord
{
    protected static string $resource = ClassModelResource::class;

    protected static ?string $title = 'Class Details';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Class Information')
                    ->schema([
                        TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),
                        
                        TextEntry::make('description')
                            ->placeholder('No description'),
                        
                        TextEntry::make('test_date')
                            ->label('Test Date')
                            ->date('F j, Y'),
                        
                        TextEntry::make('test_time')
                            ->label('Test Time')
                            ->time('g:i A')
                            ->placeholder('Not specified'),
                        
                        TextEntry::make('certification.name')
                            ->label('Certification')
                            ->placeholder('Not specified'),
                        
                        TextEntry::make('teacher.name')
                            ->label('Teacher'),
                    ])
                    ->columns(2),
                
                Section::make('Class Statistics')
                    ->schema([
                        TextEntry::make('student_count')
                            ->label('Total Students')
                            ->badge()
                            ->color('info'),
                        
                        TextEntry::make('quiz_count')
                            ->label('Total Quizzes')
                            ->state(fn ($record) => $record->quizHeaders()->count())
                            ->badge()
                            ->color('success'),
                        
                        TextEntry::make('average_score')
                            ->label('Class Average')
                            ->state(fn ($record) => number_format($record->average_score, 1) . '%')
                            ->badge()
                            ->color(function ($record) {
                                $avg = $record->average_score;
                                if ($avg >= 90) return 'success';
                                if ($avg >= 75) return 'warning';
                                return 'danger';
                            }),
                    ])
                    ->columns(3),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
