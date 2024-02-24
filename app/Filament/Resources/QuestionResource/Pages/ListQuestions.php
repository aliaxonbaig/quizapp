<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

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
            'published' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
            'unpublished' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
        ];
    }
}
