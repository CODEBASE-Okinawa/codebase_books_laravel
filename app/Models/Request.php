<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image_path',
        'isbn_10',
        'deleted_at',
    ];
}
