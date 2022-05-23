<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

use App\Survivors;
use App\SurvivorInventory;
use App\Lastlocation;

class RobotController extends Controller
{
    

    public function listRobots(Request $request) {

    	try{

    		$req = $request->all();
    		$file = asset('file/robots.json');
    		$readJSONFile = file_get_contents($file);
			//input array
			$robot_data = json_decode($readJSONFile, true);
			$return_data =[];


			if(isset($req['category']) && $req['category']!='') {
				foreach ($robot_data as $key => $value) {
					if($value['category'] == $req['category']) {
						$return_data[] =$value;
					}
				}
			}else{
				$return_data = $robot_data;
			}
			

			$returnHTML = view('table-robot')->with('data', $return_data)->render();
           

    		return response()->json([
    			'status'  => true,
    			'data' => $return_data,
    			'returnHTML' => $returnHTML,
    		], 200);

    	}catch(Exception $e) {
    		die($e->getMessage());
    	}
    }


    public function listSurvivors(Request $request) {

    	try{

    		$req = $request->all();
    		
			$return_data =[];

			if(isset($req['is_infected']) && $req['is_infected']!='') {

				$return_data = Survivors::where('is_infected','=',$req['is_infected'])->get()->toArray();
			}else{
				$return_data = Survivors::all()->toArray();
			}
			
			foreach ($return_data as $key => $value) {
				$last_location = Lastlocation::where('survivor_id', $value['id'])
				->orderBy('created_at','desc')
				->first();

				$return_data[$key]['lat'] = $last_location['lat'];
				$return_data[$key]['lng'] = $last_location['lng'];
			}

			$returnHTML = view('table-survivors')->with('data', $return_data)->render();
           
           	$total = Survivors::count();
           	$infected_rate = $non_infected_rate = 0;
           	if($total) {
           		$infected_count=Survivors::where('is_infected',1)->count();
           		$non_infected_count=Survivors::where('is_infected',0)->count();

           		$infected_rate = ($infected_count / $total) *100 ;
           		$non_infected_rate = ($non_infected_count / $total) *100 ;
           	}
           	 

    		return response()->json([
    			'status'  => true,
    			'data' => $return_data,
    			'infected_rate' => round($infected_rate,2),
    			'non_infected_rate' => round($non_infected_rate,2),
    			'returnHTML' => $returnHTML,
    		], 200);

    	}catch(Exception $e) {
    		die($e->getMessage());
    	}
    }

    public function addSurvivor(Request $request) {

    	try{

    		$aRequest = $request->all();

    		$aRules   = [
				'survivor_id'  => 'required|unique:survivors',
				'name'=> 'required',
				'age'=> 'required|numeric',
				'gender'=> 'required|numeric',
				'latitude'=> 'required|numeric' ,
				'longitude'=> 'required|numeric',
			];

			$aError = [];
			$validation = Validator::make($aRequest, $aRules);
			
			if ($validation->fails()) {
				$aError =$this->prepareValidationErrorMsg($validation->errors());
				return response()->json([
					'status'  => false,
					'message' => $aError,
				], 200);
			}else{

				DB::BeginTransaction();

				$save = new Survivors();
				$save->survivor_id = $aRequest['survivor_id'];
				$save->name = $aRequest['name'];
				$save->age = $aRequest['age'];
				$save->gender = $aRequest['gender'];
				$save->save();

				$survivor_id = $save->id;

				$location = new Lastlocation();
				$location->survivor_id = $survivor_id;
				$location->lat = $aRequest['latitude'];
				$location->lng = $aRequest['longitude'];
				$location->save();

				//initial allocation of inventory
				$inventory = new SurvivorInventory();
				$inventory->survivor_id = $survivor_id;
				$inventory->water = 10;
				$inventory->food_items = 'Bread & Jam, Fruits, Vegetables, Milk, Egg';
				$inventory->medicine = 'First aid kit, other medicine';
				$inventory->ammunition = 'Gun';
				$inventory->save();

				DB::commit();
				return response()->json([
					'status'  => true,
					'data' => $inventory,
					'message' => 'Survivor added successfully',
				], 200);

			}

    	}catch(Exception $e) {
    		DB::rollBack();
    		//die($e->getMessage());
    		return response()->json([
					'status'  => false,
					'message' => $e->getMessage()
				], 200);

    	}
    }


    public function updateLocation(Request $request) {

    	try{
    		$aRequest = $request->all();

    		$aRules   = [
				'survivor_id'  => 'required|exists:survivors,id',
				'latitude'=> 'required',
				'longitude'=> 'required',
			];

			$aError = [];
			$validation = Validator::make($aRequest, $aRules);
			
			if ($validation->fails()) {
				$aError =$this->prepareValidationErrorMsg($validation->errors());
				return response()->json([
					'status'  => false,
					'message' => $aError,
				], 200);
			}else{

				
				$location = new Lastlocation();
				$location->survivor_id = $aRequest['survivor_id'];
				$location->lat = $aRequest['latitude'];
				$location->lng = $aRequest['longitude'];
				$location->save();

				$this->updateInfected($aRequest['survivor_id']);

				
				return response()->json([
					'status'  => true,
					'message' => 'Survivor added successfully',
				], 200);

			}

    	}catch(Exception $e) {
    		
    		return response()->json([
					'status'  => false,
					'message' => $e->getMessage()
				], 200);
    	}
    }

    public function prepareValidationErrorMsg($oError)
    {

        $aError = $oError->toArray();
        $aErrorMsg = [];

        foreach ($aError as $key => $aVal) {
            $aErrorMsg[] = implode(',', $aVal);
        }

        return implode(',', $aErrorMsg);
    }


    public function updateInfected($survivor_id) {

    	try{

    		$count = Lastlocation::count(); 

    		if($count % 3 == 0) {

    			$infected = Lastlocation::select('last_location.*')
    			->join('survivors','survivors.id','=', 'last_location.survivor_id')
    			->where('survivors.is_infected','=',0)
    			->where('survivors.id','<>',$survivor_id)
    			->orderBy('last_location.created_at')
    			->first();

    			if($infected->survivor_id) {

    				$update = Survivors::find($infected->survivor_id);
    				$update->is_infected = 1;
    				$update->save();
    			}
    		}

    		return true;

    	}catch(Exception $e) {
    		die($e->getMessage());
    	}
    }

    public function getSurvivorsSelect() {

    	try{

    		$data = Survivors::where('is_infected',0)->get();

    		return response()->json([
					'status'  => true,
					'data'  => $data,
					'message' => 'list fetched'
				], 200);

    	}catch(Exception $e) {
    		return response()->json([
					'status'  => false,
					'message' => $e->getMessage()
				], 200);
    	}
    }
}
