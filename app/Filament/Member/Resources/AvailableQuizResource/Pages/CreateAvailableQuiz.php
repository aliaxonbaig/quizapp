<?php

namespace App\Filament\Member\Resources\AvailableQuizResource\Pages;

use App\Filament\Member\Resources\AvailableQuizResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAvailableQuiz extends CreateRecord
{
    protected static string $resource = AvailableQuizResource::class;
}
