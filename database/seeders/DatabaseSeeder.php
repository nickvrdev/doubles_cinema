<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cinema;
use App\Models\Film;
use App\Models\Timeslot;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cinemas = [];
        $cinemas[] = Cinema::create(['name' => 'Location A']);
        $cinemas[] = Cinema::create(['name' => 'Location B']);
        
        $films = [];
        $films[] = Film::create(['name' => 'Jello Beanies', 'genre' => 'animation', 'rating' => 'A', 'run_time' => 92]);
        $films[] = Film::create(['name' => 'The Great Gatsby - A food documentary', 'genre' => 'documentary', 'rating' => 'A', 'run_time' => 125]);
        
        $slots = [
          ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00'],
          ['10:00', '12:30', '15:00', '17:30', '20:00', '22:30'],
        ];
        $days = [];
        $now = Carbon::now();
        for($i=0;$i<14;$i++){
          $days[] = $now->format('Y-m-d');
          $now->addDay();
        }
        
        $insert = [];
        foreach($days as $day){
          foreach($slots as $k => $items){
            foreach($items as $slot){
              foreach($cinemas as $cinema){
                $insert[] = ['cinema_id' => $cinema->id, 'film_id' => $films[$k]->id, 'time_slot' => $slot, 'date_slot' => $day];
                
              }          
            }
          }
        }
        $insert = array_map(function($a) {
          return array_merge($a, [
            'created_at'=>  Carbon::now(),
            'updated_at'=> Carbon::now()
          ]);
        }, $insert);
        Timeslot::insert($insert);
        
        foreach($cinemas as $cinema){
          foreach($films as $film){
            $cinema->films()->attach($film->id);
          }
        }
        
    }
}
