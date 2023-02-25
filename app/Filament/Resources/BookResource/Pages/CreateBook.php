<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    public function __construct($id = null)
    {
        parent::__construct($id);

        if (Auth::user()->role == NO_ADMIN) {
            $this->redirect('/books');
        }
    }
}
