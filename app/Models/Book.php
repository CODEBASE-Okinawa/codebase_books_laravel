<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image_path',
        'deleted_at',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function lendeings()
    {
        return $this->hasMany(Lending::class);
    }

}
