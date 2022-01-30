<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Evaluation;
use App\Models\Restaurant;
use DB;


class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission', ['except' => ['average_evaluation']]);
        
    }
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        
        $evaluation = Evaluation::where('user_id' , '=' , $user_id)->orderBy('created_at','desc')->paginate(10);
        $restaurant = Restaurant::all();

        return view('evaluation.index')->with('evaluation', $evaluation)->with('restaurant', $restaurant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = Restaurant::all();

        return view('evaluation.create')->with('restaurant', $restaurant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Price' => 'required',
            'Cleanliness' => 'required',
            'Speed_of_Order_Arrival' => 'required',
            'Food_Quality' => 'required',
            'Treatment_of_Employees' => 'required',
        ]);

        $user_id = auth()->user()->id;;
        $restaurant_id = $request->input('restaurant_id');
    
        $evaluation_check = Evaluation::where('user_id' , '=' , $user_id )->where('restaurant_id' , '=' , $restaurant_id )->first();

        if ($evaluation_check != '') {

            return redirect('/evaluation/create')->with('error', "You already evaluate this restaurant");
        }


        // Create Evaluation
        $evaluation = new Evaluation;
        $evaluation->Price = $request->input('Price');
        $evaluation->Cleanliness = $request->input('Cleanliness');
        $evaluation->Speed_of_Order_Arrival = $request->input('Speed_of_Order_Arrival');
        $evaluation->Food_Quality = $request->input('Food_Quality');
        $evaluation->Location_of_The_Place = $request->input('Location_of_The_Place');
        $evaluation->Treatment_of_Employees = $request->input('Treatment_of_Employees');
        $evaluation->Positives = $request->input('Positives');
        $evaluation->Negatives = $request->input('Negatives');
        $evaluation->Description = $request->input('Description');
        $evaluation->Note = $request->input('Note');
        $evaluation->user_id = auth()->user()->id;
        $evaluation->restaurant_id = $request->input('restaurant_id');
        
        $evaluation->save();

        return redirect('/evaluation')->with('success', 'Evaluation Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = Evaluation::find($id);
        $restaurant = Restaurant::where('id' , '=' , $evaluation->restaurant_id)->first();

        $average = collect([$evaluation->Price, $evaluation->Cleanliness,$evaluation->Speed_of_Order_Arrival,$evaluation->Food_Quality,$evaluation->Location_of_The_Place,$evaluation->Treatment_of_Employees])->avg();
        $average = round($average);

        return view('evaluation.show')->with('average', $average)->with('restaurant', $restaurant)->with('evaluation', $evaluation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluation = Evaluation::find($id);
        
        //Check if Evaluation exists before deleting
        if (!isset($evaluation)){
            return redirect('/evaluation')->with('error', 'No Evaluation Found');
        }
        $restaurant = Restaurant::all();

        return view('evaluation.edit')->with('evaluation', $evaluation)->with('restaurant', $restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Price' => 'required',
            'Cleanliness' => 'required',
            'Speed_of_Order_Arrival' => 'required',
            'Food_Quality' => 'required',
            'Treatment_of_Employees' => 'required',
        ]);

        $evaluation = Evaluation::find($id);

        $user_id = auth()->user()->id;;
        $restaurant_id = $request->input('restaurant_id');
    
        $evaluation_check = Evaluation::where('user_id' , '=' , $user_id )->where('restaurant_id' , '=' , $restaurant_id )->first();

        if ($evaluation_check->id  != $id) {

            return redirect("/evaluation/$id/edit")->with('error', "You already evaluate this restaurant");
        }

        // Update Evaluation
        $evaluation->Price = $request->input('Price');
        $evaluation->Cleanliness = $request->input('Cleanliness');
        $evaluation->Speed_of_Order_Arrival = $request->input('Speed_of_Order_Arrival');
        $evaluation->Food_Quality = $request->input('Food_Quality');
        $evaluation->Location_of_The_Place = $request->input('Location_of_The_Place');
        $evaluation->Treatment_of_Employees = $request->input('Treatment_of_Employees');
        $evaluation->Positives = $request->input('Positives');
        $evaluation->Negatives = $request->input('Negatives');
        $evaluation->Description = $request->input('Description');
        $evaluation->Note = $request->input('Note');
        $evaluation->user_id = auth()->user()->id;
        $evaluation->restaurant_id = $request->input('restaurant_id');
        
        $evaluation->save();
    
        return redirect('/evaluation')->with('success', 'Evaluation Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluation = Evaluation::find($id);
        
        //Check if Evaluation exists before deleting
        if (!isset($evaluation)){
            return redirect('/evaluation')->with('error', 'No Evaluation Found');
        }

        $evaluation->delete();
        return redirect('/evaluation')->with('success', 'Evaluation Removed');
    }

    public static function average_evaluation($restaurant)
    {
        $average = 0;$count_each = 0 ;$count = 0;$Price_collect = 0;
        $Cleanliness_collect = 0;$Speed_collect = 0;$Quality_collect = 0;
        $Location_collect = 0;$Treatment_collect = 0;
        $filter0_collect = 0;
        $filter1_collect = 0;$filter2_collect = 0;
        $filter5_collect = 0;$filter3_collect = 0;
        $filter6_collect = 0;$filter4_collect = 0;
        
        $evaluation = Evaluation::where('restaurant_id' , '=' , $restaurant->id)->get();

        if($evaluation != '[]')
        {
            foreach($evaluation as $evaluations){
            if(isset($_POST['filterarray']))
                {
                    $filterarray[] = $_POST['filterarray'];
        
                        foreach ($filterarray as $filterarrays) {

                            $filter0 = $filterarrays[0];                             
                            $filter0 =  $evaluations->$filter0;                             
                            
                            //dd(count($filterarrays));
                            
                            if(count($filterarrays) == 2)
                            {
                                $filter1 = $filterarrays[1]; 
                                $filter1 =  $evaluations->$filter1;                                                                 
                            }
                            if(count($filterarrays) == 3)
                            {
                                $filter1 = $filterarrays[1]; 
                                $filter1 =  $evaluations->$filter1;

                                $filter2 = $filterarrays[2]; 
                                $filter2 =  $evaluations->$filter2;                                   
                            }
                            if(count($filterarrays) == 4)
                            {
                                $filter1 = $filterarrays[1]; 
                                $filter1 =  $evaluations->$filter1;

                                $filter2 = $filterarrays[2]; 
                                $filter2 =  $evaluations->$filter2;   

                                $filter3 = $filterarrays[3]; 
                                $filter3 =  $evaluations->$filter3;                                                            
                            }
                            if(count($filterarrays) == 5)
                            {
                                $filter1 = $filterarrays[1]; 
                                $filter1 =  $evaluations->$filter1;

                                $filter2 = $filterarrays[2]; 
                                $filter2 =  $evaluations->$filter2;   

                                $filter3 = $filterarrays[3]; 
                                $filter3 =  $evaluations->$filter3;  

                                $filter4 = $filterarrays[4]; 
                                $filter4 =  $evaluations->$filter4;                                 
                            }
                            if(count($filterarrays) == 6)
                            {                                
                                $filter1 = $filterarrays[1]; 
                                $filter1 = $evaluations->$filter1;

                                $filter2 = $filterarrays[2];                                 
                                $filter2 =  $evaluations->$filter2; 

                                $filter3 = $filterarrays[3]; 
                                $filter3 =  $evaluations->$filter3; 

                                $filter4 = $filterarrays[4]; 
                                $filter4 =  $evaluations->$filter4;  

                                $filter5 = $filterarrays[5]; 
                                $filter5 =  $evaluations->$filter5;                                                               
                            }
                        }

                        if(count($filterarrays) == 1)
                        {
                            $filter0_collect = $filter0_collect + $filter0;

                            $count_each++;
                            $count = 1;                         
                        }
                        if(count($filterarrays) == 2)
                        {
                            $filter0_collect = $filter0_collect + $filter0;
                            $filter1_collect = $filter1_collect + $filter1;

                            $count_each++;
                            $count = 2;                         
                        } 
                        if(count($filterarrays) == 3)
                        {
                            $filter0_collect = $filter0_collect + $filter0;
                            $filter1_collect = $filter1_collect + $filter1;
                            $filter2_collect = $filter2_collect + $filter2;

                            $count_each++;
                            $count = 3;                        
                        } 
                        if(count($filterarrays) == 4)
                        {
                            $filter0_collect = $filter0_collect + $filter0;
                            $filter1_collect = $filter1_collect + $filter1;
                            $filter2_collect = $filter2_collect + $filter2;
                            $filter3_collect = $filter3_collect + $filter3;
                            
                            $count_each++;
                            $count = 4;                         
                        } 
                        if(count($filterarrays) == 5)
                        {
                            $filter0_collect = $filter0_collect + $filter0;
                            $filter1_collect = $filter1_collect + $filter1;
                            $filter2_collect = $filter2_collect + $filter2;
                            $filter3_collect = $filter3_collect + $filter3;
                            $filter4_collect = $filter4_collect + $filter4;
                            
                            $count_each++;
                            $count = 5;                        
                        } 
                        if(count($filterarrays) == 6)
                        {
                            $filter0_collect = $filter0_collect + $filter0;
                            $filter1_collect = $filter1_collect + $filter1;
                            $filter2_collect = $filter2_collect + $filter2;
                            $filter3_collect = $filter3_collect + $filter3;
                            $filter4_collect = $filter4_collect + $filter4;
                            $filter5_collect = $filter5_collect + $filter5;                            

                           $count_each++;
                           $count = 6;
                        }                           
                }
                else
                {
                    $Price = $evaluations->Price;
                    $Cleanliness = $evaluations->Cleanliness;
                    $Speed = $evaluations->Speed_of_Order_Arrival;
                    $Quality = $evaluations->Food_Quality;
                    $Location = $evaluations->Location_of_The_Place;
                    $Treatment = $evaluations->Treatment_of_Employees;
                    
                    $Price_collect = $Price_collect + $Price;
                    $Cleanliness_collect = $Cleanliness_collect + $Cleanliness;
                    $Speed_collect = $Speed_collect + $Speed;
                    $Quality_collect = $Quality_collect + $Quality;
                    $Location_collect = $Location_collect + $Location;
                    $Treatment_collect = $Treatment_collect + $Treatment;   
                    
                    $count_each++;
                }
                
            }

            if(isset($_POST['filterarray']))
            {
                $average = ($filter0_collect / $count_each ) +( $filter1_collect / $count_each ) + ($filter2_collect / $count_each ) + ($filter3_collect / $count_each ) + ($filter4_collect / $count_each ) + ($filter5_collect / $count_each );
            }
            else{
                $average = ( $Price_collect / $count_each )+ ($Cleanliness_collect / $count_each ) + ( $Speed_collect / $count_each ) + ( $Quality_collect / $count_each ) + ( $Location_collect / $count_each ) + ($Treatment_collect/ $count_each);
                $count = 6;
            }

            $average = $average / $count;        
            $average = round($average);            
            
        switch ($average) {
            case '1':
                $average = 'Very Bad';
                break;
            case '2':
                $average = 'Bad';
                break;
            case '3':
                $average = 'Good';
                break;
            case '4':
                $average = 'Very Good';
                break;
            case '5':
                $average = 'Excellent';
                break;
            default:
            $average = 'Undefined';
                break;
        }

        return $average;

        }
    }
}
