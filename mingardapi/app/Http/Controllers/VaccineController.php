<!--Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg -->

<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /*Get all vaccine */
    public function getAllVaccines()
    {
        //Return all 
        return Vaccine::all();
    }

    /*Get one vaccine by id*/
    public function getVaccineById(string $id)
    {
        //Find with given id
        $vaccine = Vaccine::find($id);
        //check if exists
        if ($vaccine != null) {
            return $vaccine;
            //If not exist, return 404
        } else {
            return response()->json([
                'Vaccine not found'
            ], 404);
        }
    }

    /**Update vaccine by id*/
    public function updateVaccine(Request $request, string $id)
    {
        //Find with given id, save as variable 
        $vaccine = Vaccine::find($id);
        //check if exist 
        if ($vaccine != null) {
            $request->validate([
                'batchNo' => 'required',
                'name' => 'required',
                'date' => 'required',
            ]);
            //Update and return updated 
            $vaccine->update($request->all());
            return $vaccine;
        } else {
            //If not exist, return 404
            return response()->json([
                'Vaccine not found'
            ], 404);
        }
    }

    /**Delete vaccine by id*/
    public function destroyVaccine(string $id)
    {
        //Find with given id, save as variable 
        $vaccine = Vaccine::find($id);
        //Check if exist 
        if ($vaccine != null) {
            //Update and return updated 
            $vaccine->destroy($id);
            return response()->json([
                'Vaccine deleted'
            ]);
        } else {
            //If not exist, return 404
            return response()->json([
                'Vaccine not found'
            ], 404);
        }
    }
}
