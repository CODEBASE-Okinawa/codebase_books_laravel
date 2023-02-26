<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function __construct($id = null)
    {
        parent::__construct($id);

        if (Auth::user()->role == 0) {
            $this->redirect('/books');
        }
    }
}
