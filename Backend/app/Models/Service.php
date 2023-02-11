<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'type',
        'start_date',
        'end_date',
        'observations',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
