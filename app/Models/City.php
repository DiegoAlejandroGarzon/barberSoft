<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = "cities";

    protected $fillable = ['name', 'department_id'];

    // A city belongs to a department
    public function department()
    {
        return $this->belongsTo(Departament::class);
    }

    // A city can have many users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
