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
        'isbn_10',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }

    public function latestLending()
    {
        // 最新データ取得
        return $this->hasOne(Lending::class)->latestOfMany();
    }

    public function latestReservation()
    {
        // 最新データ取得
        return $this->hasOne(Reservation::class)->latestOfMany();
    }
}
