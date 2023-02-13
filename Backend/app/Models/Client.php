<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'document',
        'image',
        'observations',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'client_services', 'client_id', 'service_id');
    }

    public function clientServices()
    {
        return $this->hasMany(ClientService::class, 'client_id', 'id');
    }
}
