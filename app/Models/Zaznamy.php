<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zaznamy extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'zaznamy';
    protected $fillable = ['id','jmeno', 'prijmeni', 'datum', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'zaznamy_hobby', 'zaznamy_id', 'hobby_id');
    }


}
