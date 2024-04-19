<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /*get all vaccine */
    public function getAllVaccines()
    {
        //return all 
       return Vaccine::all();
    }

  /*get one vaccine by id*/
    public function getVaccineById(string $id)
    {
       //find with given id
       $vaccine = Vaccine::find($id);
       //check if exists
       if($vaccine != null){
           return $vaccine;
            //if not exist, return 404
       } else {
           return response()->json([
               'Vaccine not found'
           ], 404);
       }
    }

     /**update vaccine by id*/
    public function updateVaccine(Request $request, string $id)
    {
         //find with given id, save as variable 
         $vaccine = Vaccine::find($id);
         //check if exist 
         if ($vaccine != null) {
          $request->validate([
              'batchNo' => 'required',
              'name' => 'required',
              'date' => 'required',
          ]);
             //update and return updated 
             $vaccine->update($request->all());
             return $vaccine;
         } else {
             //if not exist, return 404
             return response()->json([
                 'Vaccine not found'
             ], 404);
         }
    }

    /**Delete vaccine by id*/
    public function destroyVaccine(string $id)
    {
         //find with given id, save as variable 
         $vaccine = Vaccine::find($id);
         //check if exist 
         if ($vaccine != null) {
             //update and return updated 
             $vaccine->destroy($id);
             return response()->json([
                 'Vaccine deleted'
             ]);
         } else {
             //if not exist, return 404
             return response()->json([
                 'Vaccine not found'
             ], 404);
         }
    }
}
