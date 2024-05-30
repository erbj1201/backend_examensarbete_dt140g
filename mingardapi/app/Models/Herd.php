<?php
namespace App\Models;
/*Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herd extends Model
{
    use HasFactory;

    protected $fillable = [
        'herdId',
        'address',
        'user_id'
    ];
    //connect herd to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Conntect animal to herd
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

}
