<?php

namespace App\Http\Controllers;

use App\Models\Calf;
use Illuminate\Http\Request;

class CalfController extends Controller
{
    /*get all calves */
    public function getAllCalves()
    {
        //return all 
        return Calf::all();    
    }
    /*get one calv by id*/
    public function getCalfById(string $id)
    {
        //find with given id
        $calf = Calf::find($id);
        //check if exists
        if($calf != null){
            return $calf;
             //if not exist, return 404
        } else {
            return response()->json([
                'Calf not found'
            ], 404);
        }
    }

    /**update calf by id*/
    public function updateCalf(Request $request, string $id)
    {
       //find with given id, save as variable 
       $calf = Calf::find($id);
       //check if exist 
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
           //update and return updated 
           $calf->update($request->all());
           return $calf;
       } else {
           //if not exist, return 404
           return response()->json([
               'Calf not found'
           ], 404);
       }
    }

    /**Delete calf by id*/
    public function destroyCalf(string $id)
    {
         //find with given id, save as variable 
         $calf = Calf::find($id);
         //check if exist 
         if ($calf != null) {
             //update and return updated 
             $calf->destroy($id);
             return response()->json([
                 'Calf deleted'
             ]);
         } else {
             //if not exist, return 404
             return response()->json([
                 'Calf not found'
             ], 404);
         }
    }
}
