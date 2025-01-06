<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Log;
class Agent extends Model
{
    protected $fillable = ['name', 'description', 'image', 'system_messages'];

    protected $casts = [
        'system_messages' => 'array', // Cast JSON to array
    ];

    public function log()
    {
        return $this->hasOne(Log::class);
    }
}
