<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Map;
use DB;

class MapController extends Controller
{
    //
    public function index() {



        return view('map');
    }

    public function addMarker(Request $request){

        try {
            $map = new \App\Map();

            $map->name = $request->palceName;
            $map->address = $request->placeAddress;
            $map->latitude = $request->latitude;
            $map->longitude = $request->longitude;

            $map->save();
            return 'Success';
        }
        catch (Illuminate\Database\Exception $e){
            if($e->errorInfo[1] == 1062) {

                return 'already exist';
            }
            echo $e->getMessage();
        }
    }

    public function getMarkers() {

        $maps = new \App\Map();
        $data = $maps->get();

        $locations = array();
        $count = 1;
        foreach($data as $map) {

            $locations[$count]['lat'] = $map['latitude'];
            $locations[$count]['lng'] = $map['longitude'];
            $locations[$count]['placeName'] = $map['name'];
            $locations[$count]['placeAddress'] = $map['address'];
            $count++;
        }
        return $locations;
    }

}
