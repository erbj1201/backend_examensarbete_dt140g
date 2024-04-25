<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calf extends Model
{
    use HasFactory;

    protected $fillable = [
        'animalId',
        'earNo',
        'breed',
        'name',
        'expectedBirthDate',
        'birthDate',
        'sex',
        'category',
        'animal_id',
    ];
    //Connect calf to animal (mum)
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
    //connect calf to herd
    public function herd()
    {
        return $this->belongsTo(Herd::class);
    }

}
