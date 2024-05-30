<?php
namespace App\Models;
/*Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'type',
        'amount',
        'recurrent',
        'animal_id',
    ];
    //connect medicine to animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
