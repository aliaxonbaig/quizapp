<?php

namespace App\Filament\Member\Resources\MyQuizzesResource\Pages;

use App\Filament\Member\Resources\MyQuizzesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMyQuizzes extends CreateRecord
{
    protected static string $resource = MyQuizzesResource::class;
}
