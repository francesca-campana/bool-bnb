<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Apartment extends Model
{

    use Searchable;

    protected $fillable = [
      'title',
      'rooms',
      'baths',
      'beds',
      'mqs',
      'description',
      'guests',
      'user_id',
      'latitude',
      'longitude',
      'address',
      'city',
      'zip',
      'image',
      'active',
    ];


    public function user(){
      return $this->belongsTo('App\User');
    }

    public function images(){
      return $this->hasMany('App\Image');
    }

    public function sponsors(){
      return $this->belongsToMany('App\Sponsor')->withPivot('inizio_sponsorizzazione', 'fine_sponsorizzazione','status_payment');
    }

    public function statistics() {
      return $this->hasMany('App\Statistic');
    }
    // public function visits()
    // {
    //   return visits($this)->increment()->relation();
    // }

    public function services(){
      return $this->belongsToMany('App\Service');
    }

    public function conversations(){
      return $this->hasMany('App\Conversation');
    }
}
