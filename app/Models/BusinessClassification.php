<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessClassification extends Model
{
    use HasFactory;
    protected $table = 'business_classification';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
}
