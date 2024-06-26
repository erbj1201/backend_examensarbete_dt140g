<?php
namespace App\Models;
/*Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg */
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
    

}
