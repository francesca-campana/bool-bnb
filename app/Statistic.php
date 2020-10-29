<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
      'date',
      'view',
      'apartment_id',
    ];

    public function apartment(){
      return $this->belongsTo('App\Apartment');
    }
}
