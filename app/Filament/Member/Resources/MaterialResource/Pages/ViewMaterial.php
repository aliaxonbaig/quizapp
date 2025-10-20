<?php

namespace App\Filament\Member\Resources\MaterialResource\Pages;

use App\Filament\Member\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Storage;

class ViewMaterial extends ViewRecord
{
    protected static string $resource = MaterialResource::class;

    protected static ?string $title = 'Study Material';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Material Information')
                    ->schema([
                        TextEntry::make('title')
                            ->size('lg')
                            ->weight(FontWeight::Bold),
                        
                        TextEntry::make('description')
                            ->placeholder('No description provided'),
                        
                        TextEntry::make('user.name')
                            ->label('Uploaded By'),
                        
                        TextEntry::make('created_at')
                            ->label('Upload Date')
                            ->dateTime('F j, Y \a\t g:i A'),
                    ]),
                
                Section::make('Available Files')
                    ->schema([
                        TextEntry::make('files')
                            ->label('')
                            ->listWithLineBreaks()
                            ->formatStateUsing(function ($state) {
                                if (!$state || !is_array($state)) {
                                    return 'No files available';
                                }
                                
                                $html = '<div class="space-y-2">';
                                foreach ($state as $index => $file) {
                                    $filename = basename($file);
                                    $extension = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
                                    $size = Storage::exists('public/' . $file) ? 
                                        number_format(Storage::size('public/' . $file) / 1024, 2) : '0';
                                    
                                    $html .= '<div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">';
                                    $html .= '<div class="flex items-center gap-3">';
                                    $html .= '<span class="px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded">' . $extension . '</span>';
                                    $html .= '<div>';
                                    $html .= '<p class="font-medium text-gray-900">' . $filename . '</p>';
                                    $html .= '<p class="text-sm text-gray-500">' . $size . ' KB</p>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '<a href="' . asset('storage/' . $file) . '" download class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">';
                                    $html .= '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                    $html .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>';
                                    $html .= '</svg>';
                                    $html .= 'Download';
                                    $html .= '</a>';
                                    $html .= '</div>';
                                }
                                $html .= '</div>';
                                
                                return new \Illuminate\Support\HtmlString($html);
                            }),
                    ])
                    ->visible(fn ($record) => !empty($record->files)),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Materials')
                ->url(MaterialResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}
