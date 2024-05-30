<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'animalId',
        'earNo',
        'breed',
        'name',
        'birthDate',
        'sex',
        'category',
        'herd_id',
        'imagepath',
    ];
    //connect animal to herd
    public function herd()
    {
        return $this->belongsTo(Herd::class);
    }
    //Conntect milk to animal
    public function milks()
    {
        return $this->hasMany(Milk::class);
    }

    //Conntect calves to animal (mum)
    public function calves()
    {
        return $this->hasMany(Calf::class);
    }
    //Conntect medicine to animal
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    //Conntect vaccine to animal
    public function vaccines()
    {
        return $this->hasMany(Vaccine::class);
    }
}
