<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
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
                
                Section::make('Uploaded Files')
                    ->schema([
                        TextEntry::make('files')
                            ->label('')
                            ->formatStateUsing(function ($state) {
                                if (!$state || !is_array($state)) {
                                    return 'No files uploaded';
                                }
                                
                                $html = '<div class="space-y-2">';
                                foreach ($state as $file) {
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
                                    $html .= '<a href="' . Storage::url($file) . '" target="_blank" class="text-blue-600 hover:text-blue-800">';
                                    $html .= 'View/Download';
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
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
