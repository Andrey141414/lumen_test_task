<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\Helpers\ResponseBuilder;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

//Второе задание(модуль для системы логистики)
class Task2 extends Controller
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

    public $direction = [
        'Город_1',
        "Город_2",
        "Город_3",
    ];
    public $weekMap = [
        0 => 'Воскресенье',
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
    ];


    public $rules = [
        'date'=>'required|date',
        'time'=>'required|date_format:H:i',
        'direction'=>'required|string',
    ];

public $hollidays = ['01.01', '08.03', '09.05','23.03'];

public function logic_system_modul(HttpRequest $request)
    {


        $validator = Validator::make($request->all(), [$this->rules], $messages = [
            'required' => 'The :attribute field is required.',
            'date' => 'The :attribute is not date.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        };

        if(array_search($request->get('direction'),$this->direction)== null)
        {
            return 3000;
        }
        $date = Carbon::parse($request->get('date'));
        $time = Carbon::parse($request->get('time'));
        $direction = $request->get('direction');
        
        $day_count = 21;
        $result = array();
       

       
       
        for($i = 0;$i<$day_count;$i++)
        {
            $date->addDay(1);
            if( array_search($date->format('d.m'),$this->hollidays))
            {

            }
            else{
                if($direction == $this->direction[0] || $direction == $this->direction[1] )
                {
                    if(
                    $date->dayOfWeek== array_search('Понедельник',$this->weekMap)||
                    $date->dayOfWeek== array_search('Среда',$this->weekMap)||
                    $date->dayOfWeek== array_search('Пятница',$this->weekMap)
                    )
                    {
                        if(($i == 0 && $time > Carbon::parse('16:00')) == false)
                        {
                            array_push($result,(['date'=>$date->format('d.m.y'),
                            'day'=>$this->weekMap[$date->dayOfWeek],
                            'title' =>$date->format('d M')
                            ]));    
                        }
                        
                    }
                }

                else
                {
                    if(
                        $date->dayOfWeek== array_search('Вторник',$this->weekMap)||
                        $date->dayOfWeek== array_search('Четверг',$this->weekMap)||
                        $date->dayOfWeek== array_search('Суббота',$this->weekMap)
                        )
                        {
                            if(($i == 0 && $time > Carbon::parse('20:00')) == false)
                                {
                                array_push($result,(['date'=>$date->format('d.m.y'),
                                'day'=>$this->weekMap[$date->dayOfWeek],
                                'title' =>$date->format('d M')
                                ]));
                            }
                        }
                }
            }
        }
        return response()->json( $result);
    }
}