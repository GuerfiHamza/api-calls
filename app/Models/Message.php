<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Log;
class Message extends Model
{
    protected $fillable = ['log_id', 'content'];
    public $timestamps = true; // Disable automatic timestamps

    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
