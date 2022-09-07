<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inquiries extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "inquiries";

    protected $fillable = ['lat' ,
    'lon' ,
    'date',
    ];
}
