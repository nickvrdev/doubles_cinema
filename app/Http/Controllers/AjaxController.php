<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Film;
use App\Models\Timeslot;

class AjaxController extends Controller
{

    /**
     * List the films available at selected cinema.
     */
    public function listFilms(Request $request)
    {
        $data = [];
        $cinema_id = (int) $request->input('cinema');
        if($cinema_id && ($cinema = Cinema::find($cinema_id))){
          $data = $cinema->films->map(function($item){
            return [
              'id' => $item->id,
              'name' => $item->name,
              'genre' => $item->genre,
              'run_time' => $item->run_time,
              'rating' => $item->rating,
            ];
          });
        }
        return response()->json(['data' => $data], 200);
    }
    
    /**
     * List the timeslots available for film at selected cinema.
     */
    public function listTimeslots(Request $request)
    {
        $data = [];
        $cinema_id = (int) $request->input('cinema');
        $film_id = (int) $request->input('film');
        if($cinema_id && ($cinema = Cinema::find($cinema_id)) && $film_id && ($film = Film::find($film_id))){
          $data = $cinema->timeslots()->where('film_id', $film->id)->get()->sortBy('timestamp')->map(function($item){
            return [
              'id' => $item->id,
              'text' => $item->text,
            ];
          });
        }
        return response()->json(['data' => $data], 200);
    }
    
    /**
     * List the timeslots available for film at selected cinema.
     */
    public function availableTimeslots(Request $request)
    {
        $data = [];
        $timeslot_id = (int) $request->input('timeslot');
        if($timeslot_id && ($timeslot = Timeslot::find($timeslot_id))){
          $data = $timeslot->countAvailableTimeslots();
        }
        return response()->json(['data' => $data], 200);
    }
}
