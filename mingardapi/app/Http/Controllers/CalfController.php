<!--Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg -->

<?php

namespace App\Http\Controllers;

use App\Models\Calf;
use Illuminate\Http\Request;

class CalfController extends Controller
{
    /*get all Calves */
    public function getAllCalves()
    {
        //return all 
        return Calf::all();
    }
    /*Get one calf by id*/
    public function getCalfById(string $id)
    {
        //find with given id
        $calf = Calf::find($id);
        //Check if exists
        if ($calf != null) {
            return $calf;
            //If not exist, return 404
        } else {
            return response()->json([
                'Calf not found'
            ], 404);
        }
    }

    /**Update calf by id*/
    public function updateCalf(Request $request, string $id)
    {
        //Find with given id, save as variable 
        $calf = Calf::find($id);
        //Check if exist 
        if ($calf != null) {
            $request->validate([
                'animalId' => 'required',
                'earNo' => 'required',
                'breed' => 'required',
                'name' => 'required',
                'birthDate' => 'required',
                'expectedBirthDate' => 'required',
                'sex' => 'required',
                'category' => 'required',
            ]);
            //Update and return updated 
            $calf->update($request->all());
            return $calf;
        } else {
            //If not exist, return 404
            return response()->json([
                'Calf not found'
            ], 404);
        }
    }

    /**Delete calf by id*/
    public function destroyCalf(string $id)
    {
        //Find with given id, save as variable 
        $calf = Calf::find($id);
        //check if exist 
        if ($calf != null) {
            //Update and return updated 
            $calf->destroy($id);
            return response()->json([
                'Calf deleted'
            ]);
        } else {
            //If not exist, return 404
            return response()->json([
                'Calf not found'
            ], 404);
        }
    }
}
