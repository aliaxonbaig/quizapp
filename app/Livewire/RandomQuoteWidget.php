<?php

namespace App\Livewire;

use Filament\Widgets\Widget;
use App\Models\Quote;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;


class RandomQuoteWidget extends Widget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected static string $view = 'livewire.random-quote-widget';

    protected static ?string $pollingInterval = '10s';

    public $randomQuote = '';

    public function mount(){

        $this->randomQuote = $quote = Quote::where('is_active',true)->inRandomOrder()->first();
    }
}
