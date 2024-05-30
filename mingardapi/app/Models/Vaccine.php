<?php
namespace App\Models;
/*Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'batchNo',
        'name',
        'date',
        'animal_id',
    ];
    //connect Vaccine to animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

}
