<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
      'name',
      'genre',
      'rating',
      'run_time',
    ];

    protected $hidden = [
      'id',
      'created_at',
      'updated_at',
      'deleted_at',
    ];
    
    public function cinemas()
    {
        return $this->belongsToMany('App\Models\Cinema');
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
