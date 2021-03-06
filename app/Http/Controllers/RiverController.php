<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\River;
// use App\Field;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
// use App\Days;
use App\Sections;
use DB;

class RiverController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $rivers = River::all();
            return view('rivers.index', compact('rivers'));
        }
        else{
            return redirect('home');
        }
    }

    public function create()
    {

        if (auth()->check()) {
            return view('rivers.create');
        }
        else{
            return redirect('home');
        }
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'required', //should allow alphabet, dashes, spaces
            'location'=>'required',//should allow alphabet, positive numbers, symbols
            'key'=>'required|regex:/^[\w-]*$/',//should allow alphabet, positive numbers,
            'channel'=>'required|digits:6',//no symbols
            'width'=>'required|between:0,99.99',//allow positive numbers and decimal points
            'height'=>'required|between:0,99.99',//allow positive numbers and decimal points
        ]);
        
        if ($validatedData->fails()) {
            return redirect('rivers/create')->withErrors($validatedData)->withInput();
        }
        else{
            $river = new River;
            $river->name = $request->name;
            $river->location = $request->location;
            $river->key = $request->key;
            $river->channel = $request->channel;
            $river->width = $request->width;
            $river->height = $request->height;
            $river->save();
            // return redirect('admin/home')->with('success', 'River saved!');
            return redirect('/rivers')->with('success', 'River saved!');
        }

    }

    public function show(Request $request)
    {
        if (auth()->check()) {
            $rivers = River::all();
            return view('displayRiver',compact('rivers'));
        }
        else{
            return redirect('home');
        }
    }

    public function edit($id)
    {

        if (auth()->check()) {
            $rivers = River::find($id);
            return view('rivers.edit', compact('rivers'));
        }
        else{
            return redirect('home');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name'=>'required|regex:/(^[\pL0-9 ]+)$/u', //should allow alphabet, dashes, spaces
            'location'=>'required',//should allow alphabet, positive numbers, symbols
            'key'=>'required|regex:/^[\w-]*$/',//should allow alphabet, positive numbers,
            'channel'=>'required|digits:6',//no symbols
            'width'=>'required|between:0,99.99|numeric',//allow positive numbers and decimal points
            'height'=>'required|between:0,99.99|numeric',//allow positive numbers and decimal points
        ]);

        if ($validatedData->fails()){
            // return redirect('rivers/edit')->withErrors($validatedData)->withInput();
            return back()->withErrors($validatedData)->withInput();

        }
        else{
            $river = River::find($id);
            $river->name =  $request->get('name');
            $river->location = $request->get('location');
            $river->key =  $request->get('key');
            $river->channel = $request->get('channel');
            $river->width = $request->get('width');
            $river->height = $request->get('height');
            $river->save();
            return redirect('/rivers')->with('success', 'River saved!');
        }

    }

    public function destroy($id)
    {
        $river = River::find($id);
        $river->delete();

        return redirect('/rivers')->with('success', 'River deleted!');
    }

    public function details($id)
    {


        $client = new Client();
        //-----------------------------------------------//
        // $response = $client->request('GET','https://api.thingspeak.com/channels/952196/feeds.json?api_key=RGBK34NEJJV41DY7&results=5
        // '); //--original
        // $temp = json_decode($response->getBody()->getContents()); //--original
        // $temp=$temp->feeds;
        // $result = end($temp);
        // $fields = Field::latest()->take(30)->get()->sortBy('id');

        // $labels = $fields->pluck('id');
        // $data = $fields->pluck("field2");
        // dump($data);
        //-----------------------------------------------//
        //-----------------------------------------------//
        // $res2 = $client->request('GET','https://api.thingspeak.com/channels/952196/fields/2.json?api_key=RGBK34NEJJV41DY7&results=30');
        // $temp2 = json_decode($res2->getBody()->getContents()); 
        // $temp2=$temp2->feeds;
        // dump($temp2);

        // $cart = array();
        // $id = array();

        // foreach($temp2 as $element){
        //     array_push($cart, (float)$element->field2);
        //     array_push($id, $element->entry_id);
        // }

        // dump($cart);
        // dd($id);
        // $cart2 = new Collection();
        // $id2 = new Collection();
        // $cart2 = collect($cart);
        // $id2 = collect($id);
        // dump($cart2);
        // dd($id2);
        //-----------------------------------------------//
        //-----------------------------------------------//
        // $res = $client->request('GET','https://api.thingspeak.com/channels/952196/feeds.json?api_key=RGBK34NEJJV41DY7');        
        // $temp = json_decode($res->getBody()->getContents()); //--original

        // $temp = $temp->feeds;
        // dump($temp);
        //-----------------------------------------------//
        //-----------------------------------------------//
        // $res2 = $client->request('GET','https://api.thingspeak.com/channels/952196/feeds.json?api_key=RGBK34NEJJV41DY7');
        // $temp = json_decode($res2->getBody()); //--original
        // $temp = $temp->feeds;
        // dd(end($temp)->field2);
        //-----------------------------------------------//
        // $fields = Field::latest()->take(30)->get()->sortBy('id');
        // $field1 = $fields->pluck("field1");
        // $field2 = $fields->pluck("field2");
        // $field3 = $fields->pluck("field3");
        // $field4 = $fields->pluck("field4");

        // dump($field1);
        // $res2 = $client->request('GET','https://api.thingspeak.com/channels/952196/feeds.json?api_key=RGBK34NEJJV41DY7');
        // $temp = json_decode($res2->getBody()); //--original
        // $temp = $temp->feeds;
        // $field1 = end($temp)->field1;
        // $field2 = end($temp)->field2;
        // $field3 = end($temp)->field3;
        // $field4 = end($temp)->field4;
        
        // $cart = array();
        // array_push($cart, (float)end($temp)->field1);
        // array_push($cart, (float)end($temp)->field2);
        // array_push($cart, (float)end($temp)->field3);
        // array_push($cart, (float)end($temp)->field4);

        // $cart2 = new Collection();
        // $data = collect($cart);

        // dd($data);
        //-----------------------------------------------//
        //unhighlight entire block to view code
        // $i = 0;
        // // $river= River::find($request->id);
        // // Dates::create(['start' => $request->start,'end' =>$request->end]);
        // // $client = new Client();
        // // $date = Dates::latest()->first();
        // // $start = explode('-', $date->start);
        // // $end = explode('-', $date->end);
        // $start = "2020-02-22";
        // $end = "2020-02-25";
        // //get all days in db
        // $days = Days::all();
        // //check if start date or end date are in database
        // if($days->contains('date',$start)!=true)
        // {
        //     Days::create(['date' => "2020-02-21"]);
        // }
        // else
        // {
        //     //query from fields in db that have the same date as input
        // }

        // if($days->contains('date',$end)!=true)
        // {
        //     Days::create(['date' => "2020-02-21"]);
        //     // $url = 'https://api.thingspeak.com/channels/'.$river->channel.'/fields/2.json?api_key='.$river->key.'&start='.$start[0].'-'.$start[1].'-'.$start[2].'&end='.$end[0].'-'.$end[1].'-'.$end[2];
        //     // $res2 = $client->request('GET',$url);
        //     // $temp = json_decode($res2->getBody()->getContents()); //--original
        //     // $temp = $temp->feeds;
        //     //uncomment above when ready
        // }
        // else
        // {
        //     //query from fields in db that have the same end date as input
        // }    

        // foreach ($results as $result)
        // {
        //     Field::create(['field1' =>$result->field1,'field2' =>$result->field2,'field3' =>$result->field3,'field4' =>$result->field4]);
        // }

        // $url = 'https://api.thingspeak.com/channels/'.$river->channel.'/fields/2.json?api_key='.$river->key.'&start='.$start[0].'-'.$start[1].'-'.$start[2].'&end='.$end[0].'-'.$end[1].'-'.$end[2];
        // $res2 = $client->request('GET',$url);
        // $temp = json_decode($res2->getBody()->getContents()); //--original
        // $temp = $temp->feeds;

        // $cart = array();
        // $id = array();

        // foreach($temp as $element){
        //     array_push($cart, (float)$element->field2);
        //     array_push($id, $element->entry_id);
        // }

        // $cart2 = new Collection();
        // $id2 = new Collection();
        // $data = collect($cart);
        // $labels = collect($id);
 
        // // return response()->json(compact('labels', 'data'));
        //-----------------------------------------------//

        //-----------------------------------------------//

        // $res2 = $client->request('GET','https://api.thingspeak.com/channels/952196/feeds.json?api_key=RGBK34NEJJV41DY7&results=30
        // '); //<=== fix this!!!
        // $temp = json_decode($res2->getBody()->getContents()); //--original
        // $temp=$temp->feeds;
        // $results = $temp;
      
        // // foreach($results as $result){
        // //     Field::create(['field1' =>$result->field1,'field2' =>$result->field2,'field3' =>$result->field3,'field4' =>$result->field4]);
        // // }

        // if(request()->ajax()){
        //     if(!empty($request->from_date)){
        //         $data = DB::table('fields')
        //                 ->whereBetween('order_date', array($request->from_date, $request->to_date))
        //                 ->get();
        //         Days::create(['date' => $request->from_date]);
        //     }
        //     else{
        //         $data = DB::table('fields')->get();
        //     }
        //     return datatables()->of($data)->make(true);
        // }
        //-----------------------------------------------//

        if (auth()->check()) {
            $river = River::find($id);
            //---------------------------------------------------------//
            // $channel = 952196;

            // $river = River::whereChannel($channel)->first();


            // //initialize array
            // $labels = array();
            // $dischargeArray = array();
            // // $temp = River::where('id','=',$id)->first();
            // $temp = River::whereChannel($channel)->first();
            // $client = new Client();

            // //query the water levels and velocities
            // $waterLevels = $client->request('GET','https://api.thingspeak.com/channels/' . $temp->channel . '/feeds.json?api_key=' . $temp->key . '&results=1');
            // $waterLevels = json_decode($waterLevels->getBody()->getContents()); 
            // $waterLevels = $waterLevels->feeds;
            // // dd($waterLevels);

            // //initialize variables
            // $discharge = 0;
            // $totalDischarge = 0;
            // //query sections from DB
            // $sections = Sections::where('river_id','=',$river->id)->get();

            // $count = $sections->count();
            // $width = $temp->width;
            // $height = $temp->height;
            // $counter = 0; 
            // $totalArea = 0;

            // foreach($waterLevels as $waterLevel){
            //     dump($waterLevel->field2);
            //     foreach ($sections as $section){
            //         //triangle
            //         if ($section->shape==0){
            //             //compute if max Height - longer side < instantaneous height then compute area else return 0
            //             if($height - $section->y1 < $waterLevel->field2){
            //                 // dump("I was computed" . $section->id);
            //                 $no = (($waterLevel->field2-$height)+ $section->y1);
            //                 $area = (pow($no,2) * $section->width)/(2*$section->y1);
            //                 $discharge = $area * $waterLevel->field1 * $section->multiplier;
            //             }
            //             else{
            //                 $area = 0;
            //                 $discharge = 0;
            //             }

            //         }
            //         //rectangle
            //         elseif($section->shape==1){

            //             if($height - $section->y1 < $waterLevel->field2){
            //                 // dump("I was computed" . $section->id);
            //                 $area = $section->width*($waterLevel->field2 - $height + $section->y1);
            //                 $discharge = $area * $waterLevel->field1 * $section->multiplier;
            //             }
            //             else{
            //                 $area = 0;
            //                 $discharge = 0;
            //             }
            //         }
            //         //trapezoids
            //         elseif($section->shape==2){
            //             $smallerSide = min($section->y1,$section->y2);
            //             $greaterSide = max($section->y1,$section->y2);
            //             // dump($smallerSide);
            //             // dump($greaterSide);
            //             //height is max height
            //             //waterLevel->field2 is instantaneous height from sensor
            //             //$section->y1 is y1 sa kana nga section (always left side)
            //             //$section->y2 is y2 sa kana nga section (always right side)
            //             //waterLevel->field1 is velocity from sensor
            //             //compute max Height - longer side if difference < instantaneous height then compute area else return 0
            //             // $difference = $height - $smallerSide;
            //             $difference = $height - $greaterSide;
            //             // $a = $difference;
            //             // $b = $waterLevel->field2;
            //             // $epsilon = 0.00001;
            //             // dump($difference);
            //             // if($a<$b) {
            //             //     dump($difference);
            //             //     dump("jari");
            //             // } 
            //             if(floatVal($waterLevel->field2) > $difference && ($waterLevel->field2)<= $height){
            //                 if($waterLevel->field2  <= $height - $smallerSide){
            //                     // dump("I was computed" . $section->id);
            //                     $no = (($waterLevel->field2-$height)+ $greaterSide);
            //                     $area = (pow($no,2) * $section->width)/(2*($greaterSide-$smallerSide));


            //                     // $area =  (($waterLevel->field2 - $height) + $section->y2 - $section->y1);
            //                 }
            //                 elseif($waterLevel->field2 > $height - $smallerSide){
            //                     // dump("I was computed" . $section->id);
            //                     $area = (($section->width*($greaterSide-$smallerSide))/2)+($section->width*(($waterLevel->field2)+$smallerSide-$height));
			// 				//	$area = ($section->width*($section->y1 + $section->y2 + (2*$waterLevel->field2)- (2*$height)))/2;
            //                 }
    
            //                 $discharge = $area * $waterLevel->field1 * $section->multiplier;
            //             }
            //             else{
            //                 $area = 0;
            //                 $discharge = 0;
            //             }
            //         }
            //         dump($area);
            //         $totalArea = $totalArea + $area; 

            //         $counter = $counter + 1;
            //         $totalDischarge = $totalDischarge + $discharge;
                    
            //         if($counter == $count){
            //             dump("Total discharge:" . $totalDischarge);
            //             // Discharge::create(['dischargeValue' =>$totalDischarge,'river_id'=>$river->id]);
            //             $counter = 0;
            //             $totalDischarge = 0;
            //         }
            //     }
            // }
            //---------------------------------------------------------//
            return view('rivers.riverDetails',compact('river'));
        }
        else{
            return redirect('home');
        }   

        //-----------------------------------------------//
    }
}
