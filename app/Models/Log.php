<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agent;
use App\Models\Message;
class Log extends Model
{
    protected $fillable = ['agent_id', 'title'];

public function agent()
{
    return $this->belongsTo(Agent::class);
}

public function messages()
{
    return $this->hasMany(Message::class);
}
}
