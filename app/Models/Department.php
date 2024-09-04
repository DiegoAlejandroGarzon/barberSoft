<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "departments";

    protected $fillable = [
    'id',
    'code_dane',
    'name'
    ];

    // A department has many cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
