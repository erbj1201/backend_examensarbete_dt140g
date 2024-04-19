<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /*get all medicine */
    public function getAllMedicines()
    {
       //return all 
       return Medicine::all(); 
    }

      /*get one medicine by id*/
    public function getMedicineById(string $id)
    {
        //find with given id
        $medicine = Medicine::find($id);
        //check if exists
        if($medicine != null){
            return $medicine;
             //if not exist, return 404
        } else {
            return response()->json([
                'Medicine not found'
            ], 404);
        }
    }

   /**update medicine by id*/
    public function updateMedicine(Request $request, string $id)
    {
        //find with given id, save as variable 
        $medicine = Medicine::find($id);
        //check if exist 
        if ($medicine != null) {
         $request->validate([
             'date' => 'required',
             'type' => 'required',
             'amount' => 'required',
             'recurrent' => 'required',
         ]);
            //update and return updated 
            $medicine->update($request->all());
            return $medicine;
        } else {
            //if not exist, return 404
            return response()->json([
                'Medicine not found'
            ], 404);
        }
    }

    /**Delete medicine by id*/
    public function destroyMedicine(string $id)
    {
         //find with given id, save as variable 
         $medicine = Medicine::find($id);
         //check if exist 
         if ($medicine != null) {
             //update and return updated 
             $medicine->destroy($id);
             return response()->json([
                 'Medicine deleted'
             ]);
         } else {
             //if not exist, return 404
             return response()->json([
                 'Medicine not found'
             ], 404);
         }
    }
}
