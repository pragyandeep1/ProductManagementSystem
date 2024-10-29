<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerHistory extends Model
{
    use HasFactory;
    protected $table = 'career_history';
    protected $primaryKey = 'ch_id';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
