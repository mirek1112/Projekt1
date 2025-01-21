<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function zaznamy()
    {
        return $this->belongsToMany(Zaznamy::class, 'zaznamy_hobby', 'hobby_id', 'zaznamy_id');
    }


}

