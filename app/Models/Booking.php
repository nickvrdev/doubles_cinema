<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
      'user_id',
      'cinema_id',
      'film_id',
      'timeslot_id',
      'ticket_count',
      'hash',
    ];

    protected $hidden = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function cinema()
    {
        return $this->belongsTo('App\Models\Cinema');
    }
    
    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }
    
    public function timeslot()
    {
        return $this->belongsTo('App\Models\Timeslot');
    }

    public static function hashGen(){
      $count = 0;
      $exists = true;
      while($exists && $count < 1E3){
        $hash = \Str::random(8);
        $exists = self::where('hash', $hash)->count() > 0;
        $count++;
      }
      if($exists){
        // Unable to generate hash, add ticket and better error handling
        abort(500);
      }
      return strtoupper($hash);
    }
    
}
