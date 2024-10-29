<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $table = 'certifications';
    protected $primaryKey = 'cf_id';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
