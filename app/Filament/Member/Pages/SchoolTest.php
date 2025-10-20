<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SchoolTest extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'School Test';
    
    protected static ?string $title = 'School Test (Exam Mode)';

    protected static string $view = 'filament.member.pages.school-test';
    
    protected static ?int $navigationSort = 3;
}
