<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
      'name',
      'price',
      'duration',
    ];

    public function apartments(){
      return $this->belongsToMany('App\Apartment')->withPivot('inizio_sponsorizzazione', 'fine_sponsorizzazione','status_payment');
    }
}
