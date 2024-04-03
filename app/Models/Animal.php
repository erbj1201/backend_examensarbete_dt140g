<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'animalId',
        'breed',
        'name',
        'herd_id',
        'imagepath'
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
}
