<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        if (Auth::user()->role == 0) {
            $this->redirect('/books');
        }

        return [
            Actions\CreateAction::make(),
        ];
    }
}
