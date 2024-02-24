<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\UserResource;
use App\Models\Quote;
use App\Models\Section;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StatsOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
            ->description('Total Active Users on site.')
            ->descriptionIcon('heroicon-m-users')
            ->color('success')
            ->url(UserResource::getUrl()),

            Stat::make('Admins', User::where('is_admin',true)->count())
            ->description('Super-Admins on the site.')
            ->descriptionIcon('heroicon-m-user')
            ->color('danger'),

            Stat::make('Users', User::where('is_admin',false)->count())
            ->description('Normal users on the site.')
            ->descriptionIcon('heroicon-o-user')
            ->color('success'),

            Stat::make('Total Sections', Section::count())
                ->description('Total Sections defined on the site.')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success')
                ->url(SectionResource::getUrl()),

            Stat::make('Active Sections', Section::where('is_active',true)->count())
                ->description('Published sections on the site.')
                ->descriptionIcon('heroicon-s-rectangle-stack')
                ->color('success'),

            Stat::make('Active Sections', Section::where('is_active',false)->count())
                ->description('Un-published sections on the site.')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('danger'),


            // Stat::make('Total Quotes', Quote::count())
            //     ->description('Total quotes present for random display.')
            //     ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
            //     ->color('success')
            //     ->url(route('filament.admin.resources.quotes.index')),

            // Stat::make('Active Quotes', Quote::where('is_active',true)->count())
            //     ->description('Published quotes available.')
            //     ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
            //     ->color('success'),

            // Stat::make('Inactive Quotes', Quote::where('is_active',false)->count())
            //     ->description('Un-published quotes on the site.')
            //     ->descriptionIcon('heroicon-o-chat-bubble-bottom-center-text')
            //     ->color('danger'),

        ];
    }
}
