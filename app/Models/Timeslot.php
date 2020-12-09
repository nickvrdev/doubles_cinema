<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
      'cinema_id',
      'film_id',
      'date_slot',
      'time_slot',
    ];

    protected $hidden = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at',
    ];
    
    public function cinema()
    {
        return $this->belongsTo('App\Models\Cinema');
    }
    
    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }
    
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }
    
    public function getTimestampAttribute()
    {
      return strtotime("{$this->date_slot} {$this->time_slot}");
    }
    
    public function getTextAttribute()
    {
      return date("j M Y - H:i", $this->timestamp);
    }
    
    public function countAvailableTimeslots(){
      return (config('cinema.theatre_limit') - $this->bookings->count());
    }
    
    public function cancelable(){
      return $this->timestamp > time() + config('cinema.cancel_limit');
    }

}
