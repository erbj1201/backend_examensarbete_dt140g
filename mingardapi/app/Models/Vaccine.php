<?php

namespace App\Models;

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
