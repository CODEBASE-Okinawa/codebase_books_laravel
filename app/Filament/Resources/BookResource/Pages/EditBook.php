<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        if (Auth::user()->role == 0) {
            $this->redirect('/books');
        }

        return [
            Actions\DeleteAction::make(),
        ];
    }
}
