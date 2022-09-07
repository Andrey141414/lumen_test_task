<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\Helpers\ResponseBuilder;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Inquiries;
use App\Models\Responses;
use Illuminate\Database\Eloquent;


use function PHPSTORM_META\type;
//Первое задание получение прогноза погоды(работает тольок на 5 дней)
class Task1 extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public $rules = [
        'lat'=>'required|numeric',
        'lon'=>'required|numeric',
        'date'=>'required|date',
    ];
   //
    public function get_forecast(HttpRequest $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute is not date.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        };

        $lat = $request->lat;
        $lon = $request->lon;
        $date = Carbon::parse($request->date);
        $KELVIN = 270.0;
                
        if($lat>90||$lat< -90||$lon>180||$lon< -180){
            return response()->json([
                'message' => 'Incorect geo chords'
            ]); 
        };


        if($date>=Carbon::today() && $date<=Carbon::today()->addDays(5)){
            $date = $date->format('M d Y');
        }
        else{
            return response()->json([
                'message' => 'Unfortunately the weather is only for the next 5 days'
            ]);
        }
        






        
        $api_key = env('API_KEY');
        $json_res = (Http::get(
            "https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&exclude=daily&lang=ru&appid=${api_key}"));
        
        $result=json_decode($json_res,true);
        $city = $result['city']['name'];
        

        
        
        for($i = 0;$i<40;$i+=2)
        {
            if(Carbon::parse($result["list"][$i]["dt_txt"])->format('M d Y') == $date)
            {
                $temp_night = number_format($result["list"][$i]["main"]["temp"]-$KELVIN,0);
                $temp_morning = number_format($result["list"][$i+1]["main"]["temp"]-$KELVIN);
                $temp_day = number_format($result["list"][$i+2]["main"]["temp"]-$KELVIN);
                $temp_evening = number_format($result["list"][$i+3]["main"]["temp"]-$KELVIN);
                break;

            }
        }

        $inquir = new Inquiries();
        $inquir::Create([
            'lat' => $lat,
            'lon' => $lon ,
            'date' => Carbon::parse($request->date),
        ])->save();


        Responses::firstOrCreate([
            'Night'=>$temp_night,
            'Morning'=>$temp_morning,
            'Day'=>$temp_day,
            'Evening'=>$temp_evening,
            'Location'=>$city,
            'id_inquries'=>1,
        ])->save();

        

        return response()->json([
            "Night"=>$temp_night,
            "Morning"=>$temp_morning,
            "Day"=>$temp_day,
            "Evening"=>$temp_evening,
            "Location"=>$city
        ]);        
        
    }

    
}
