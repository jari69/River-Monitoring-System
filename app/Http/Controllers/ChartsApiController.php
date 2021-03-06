<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\River;
use App\Sections;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Discharge;
use App\WaterLevel;

class ChartsApiController extends Controller
{
    public function index($id)
    {
        //------------------------------------------------//
        // $river = River::find($id);
        // $client = new Client();
        
        // $res2 = $client->request('GET','https://api.thingspeak.com/channels/' . $river->channel . '/fields/2.json?api_key=' . $river->key . '&results=30');
        // $temp2 = json_decode($res2->getBody()->getContents()); 
        // $temp2=$temp2->feeds;
        // // dump($temp2);

        // $cart = array();
        // $id = array();

        // foreach($temp2 as $element){
        //     array_push($cart, (float)$element->field2);
        //     array_push($id, $element->entry_id);
        // }

        // // dump($cart);
        // // dd($id);
        // $cart2 = new Collection();
        // $id2 = new Collection();
        // $data = collect($cart);
        // $labels = collect($id);
        // // dump($cart2);
        // // dd($id2);
        // return response()->json(compact('labels', 'data'));

        //------------------------------------------------//
        $array1 = array();
        $array2 = array();

        //get last 30 only
        $waterLevels = WaterLevel::latest()->take(30)->where('river_id', '=', $id)->get();
        $waterLevels = $waterLevels->reverse();
        foreach($waterLevels as $waterLevel){
            array_push($array1, $waterLevel->level);
            array_push($array2, $waterLevel->id);
        }
        $data = collect($array1);
        $labels = collect($array2);
        return response()->json(compact('data','labels'));
    }

    public function getDetails($id)
    {
        $river = River::find($id);
        $client = new Client();
        // $fields = Field::latest()->take(30)->get()->sortBy('id');
        // $field1 = $fields->pluck("field1");
        // $field2 = $fields->pluck("field2");
        // $field3 = $fields->pluck("field3");
        // $field4 = $fields->pluck("field4");
        $res2 = $client->request('GET','https://api.thingspeak.com/channels/' . $river->channel . '/feeds.json?api_key=' . $river->key);
        $temp = json_decode($res2->getBody()); //--original
        $temp = $temp->feeds;
        // $field1 = end($temp)->field1;
        // $field2 = end($temp)->field2;
        // $field3 = end($temp)->field3;
        // $field4 = end($temp)->field6;
        
        $cart = array();
        array_push($cart, (float)end($temp)->field1);
        array_push($cart, (float)end($temp)->field2);
        array_push($cart, (float)end($temp)->field3);
        array_push($cart, (float)end($temp)->field6);

        $cart2 = new Collection();
        $data = collect($cart);
        return response()->json(compact('data'));
        // return response()->json(compact('field1','field2','field3','field4'));
    }

    public function getFlowRate($id)
    {
        // $labels = array();
        // $dischargeArray = array();
        // $temp = River::where('id','=',$id)->first();
        // $client = new Client();

        // //query the water levels and velocities
        // $waterLevels = $client->request('GET','https://api.thingspeak.com/channels/' . $temp->channel . '/feeds.json?api_key=' . $temp->key . '&results=1');
        // $waterLevels = json_decode($waterLevels->getBody()->getContents()); 
        // $waterLevels = $waterLevels->feeds;
        // // dd($waterLevels);
        // $discharge = 0.00;
        // $totalDischarge = 0.00;
        // $sections = Sections::where('river_id','=',$id)->get();
        // $count = $sections->count();
        // $width = $temp->width;
        // $height = $temp->height;
        // $counter = 0; 

        // foreach($waterLevels as $waterLevel){
        //     foreach ($sections as $section){
        //         if ($section->shape==0){
        //             $ratio = $section->width*($height - $section->vertical_distance);
        //             //change to height from device?
        //             $area = (($ratio * $waterLevel->field2 * $waterLevel->field2 ) - ($ratio * $waterLevel->field2  * $section->vertical_distance))/2;
        //             // $discharge = $area * $section->coefficient * $section->velocity;
        //             $discharge = $area * $section->coefficient * $waterLevel->field1;
        //             // dd($discharge);
        //         }
        //         elseif($section->shape==1){
        //             $area = ($section->width * $waterLevel->field2 ) - ($section->width * $section->vertical_distance);
        //             // $discharge = $area * $section->coefficient * $section->velocity;
        //             $discharge = $area * $section->coefficient * $waterLevel->field1;
        //         }
        //         elseif($section->shape==2){
        //             if($height <= $section->triangleHeight){
        //                 $ratio = ($section->triangleHeight - $section->vertical_distance)* $section->width;
        //                 $area = (($ratio * pow($waterLevel->field2,2)) - ($ratio * $waterLevel->field2  * $section->vertical_distance))/2;
        //                 $discharge = $area * $section->coefficient * $waterLevel->field1;
        //             }
        //             elseif($height > $section->triangleHeight){
        //                 //change to height from device
        //                 $area = ((0.5 * $section->$width * $section->triangleHeight) + ($waterLevel->field2 * $section->width))- ($section->triangleHeight + $section->vertical_distance);
        //                 // dump($area);
        //                 $discharge = $area * $section->coefficient * $waterLevel->field1;
        //             }
        //         }
                
        //         $counter = $counter + 1;
        //         $totalDischarge = $totalDischarge + $discharge;
        //         if($counter == $count){
        //             // array_push($dischargeArray, (float)$totalDischarge);//delete this
        //             Discharge::create(['dischargeValue' =>$totalDischarge]);
        //             $counter = 0;
        //             $totalDischarge = 0.0;
        //         }
                
        //     }
        //     // array_push($labels, $waterLevel->entry_id);//delete this
        // }
        // $data = collect($dischargeArray);
        // $labels = collect($labels);
        //---------------------------------------------------//

        $array1 = array();
        $array2 = array();

        //get last 30 only
        $discharges = Discharge::latest()->take(30)->where('river_id', '=', $id)->get();
        $discharges = $discharges->reverse();
        foreach($discharges as $discharge){
            array_push($array1, $discharge->dischargeValue);
            array_push($array2, $discharge->id);
        }
        $data = collect($array1);
        $labels = collect($array2);
        //---------------------------------------------------//
        return response()->json(compact('data','labels'));
    }

    // public function getDataRange(Request $request)
    // {
    //     $client = new Client();
    //     $start = explode('-', $request->start);
    //     $end = explode('-', $request->end);

        
    //     $url = 'https://api.thingspeak.com/channels/952196/fields/2.json?api_key=RGBK34NEJJV41DY7&start='.$start[0].'-'.$start[1].'-'.$start[2].'&end='.$end[0].'-'.$end[1].'-'.$end[2];
    //     //ibalhin nalang sa apiController.php
    //     //ang problem kay basin sa date na gi select 
    //     $res2 = $client->request('GET',$url);
        
    //     $temp = json_decode($res2->getBody()->getContents()); //--original
    //     $temp = $temp->feeds;

    //     $cart = array();
    //     $id = array();

    //     foreach($temp as $element){
    //         array_push($cart, (float)$element->field2);
    //         array_push($id, $element->entry_id);
    //     }

    //     $cart2 = new Collection();
    //     $id2 = new Collection();
    //     $data = collect($cart);
    //     $labels = collect($id);

    //     return response()->json(compact('labels', 'data'));
    // }
}
