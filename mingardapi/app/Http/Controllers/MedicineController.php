<!--Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg -->

<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /*Get all medicine */
    public function getAllMedicines()
    {
        //Return all 
        return Medicine::all();
    }

    /*Get one medicine by id*/
    public function getMedicineById(string $id)
    {
        //Find with given id
        $medicine = Medicine::find($id);
        //check if exists
        if ($medicine != null) {
            return $medicine;
            //If not exist, return 404
        } else {
            return response()->json([
                'Medicine not found'
            ], 404);
        }
    }

    /**Update medicine by id*/
    public function updateMedicine(Request $request, string $id)
    {
        //Find with given id, save as variable 
        $medicine = Medicine::find($id);
        //Check if exist 
        if ($medicine != null) {
            $request->validate([
                'date' => 'required',
                'type' => 'required',
                'amount' => 'required',
                'recurrent' => 'required',
            ]);
            //Update and return updated 
            $medicine->update($request->all());
            return $medicine;
        } else {
            //If not exist, return 404
            return response()->json([
                'Medicine not found'
            ], 404);
        }
    }

    /**Delete medicine by id*/
    public function destroyMedicine(string $id)
    {
        //Find with given id, save as variable 
        $medicine = Medicine::find($id);
        //Check if exist 
        if ($medicine != null) {
            //Update and return updated 
            $medicine->destroy($id);
            return response()->json([
                'Medicine deleted'
            ]);
        } else {
            //If not exist, return 404
            return response()->json([
                'Medicine not found'
            ], 404);
        }
    }
}
