<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
      'name',
    ];

    protected $hidden = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at',
    ];
    
    public function films()
    {
        return $this->belongsToMany(Film::class, 'cinema_film', 'cinema_id', 'film_id');
        return $this->belongsToMany('App\Models\Film');
    }
    
    public function timeslots()
    {
        return $this->hasMany('App\Models\Timeslot');
    }
    
    public function booking()
    {
        return $this->hasMany('App\Models\Booking');
    }

}
