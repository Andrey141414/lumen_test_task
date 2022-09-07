<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Responses extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "responses";

    protected $fillable = [
        "Night",
        "Morning",
        "Day",
        "Evening",
        "Location",
        "id_inquries"
    ];
}
