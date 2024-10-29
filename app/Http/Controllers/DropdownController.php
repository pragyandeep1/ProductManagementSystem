<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Response;
use Redirect;
use App\Models\{Country, State, City};

class DropdownController extends Controller
{
    public function index()
    {
        $data['countries'] = Country::get(["name", "id"]);
        // return view('welcome', $data);
        return response()->json($data);
    }
    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function getLocationNames($id, $type)
    {
        $location = null;

        switch ($type) {
            case 'country':
                $location = Country::where("id", $id)->first();
                // $location = Country::find($id);
                break;
            case 'state':
                // $location = State::find($id);
                $location = State::where("id", $id)->first();

                break;
            case 'city':
                // $location = City::find($id);
                $location = City::where("id", $id)->first();
                break;
        }

        return response()->json(['name' => $location ? $location->name : null]);
    }
}
