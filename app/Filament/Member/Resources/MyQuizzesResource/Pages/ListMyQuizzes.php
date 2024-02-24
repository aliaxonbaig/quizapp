<?php

namespace App\Filament\Member\Resources\MyQuizzesResource\Pages;

use App\Filament\Member\Resources\MyQuizzesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMyQuizzes extends ListRecords
{
    protected static string $resource = MyQuizzesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('completed', true)),
            'Not Completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('completed', false)),
        ];
    }
}
