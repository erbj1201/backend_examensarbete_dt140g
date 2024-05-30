<!--Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg -->
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kgMilk',
        'milkDate',
        'animal_id'
    ];
    //connect milk to animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

}
