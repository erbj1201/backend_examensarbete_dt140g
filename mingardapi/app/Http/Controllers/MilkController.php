<?php
namespace App\Http\Controllers;
/*Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg */
use App\Models\Milk;
use Illuminate\Http\Request;

class MilkController extends Controller
{
    /*Get all milk*/
    public function getAllMilks()
    {
        //Return all 
        return Milk::all();
    }

    /*Get one milk by id*/
    public function getMilkById(string $id)
    {
        //Find milk with given id, save as variable 
        $milk = Milk::find($id);
        //Check if exist 
        if ($milk != null) {
            //Return 
            return $milk;
        } else {
            //If not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }

    /*Update milk by id*/
    public function updateMilk(Request $request, string $id)
    {
        //Find with given id, save as variable 
        $milk = Milk::find($id);
        //Check if exist 
        if ($milk != null) {
            //Update and return updated 
            $milk->update($request->all());
            return $milk;
        } else {
            //If not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }

    /*Delete milk by id*/
    public function destroyMilk(string $id)
    {
        //Find with given id, save as variable 
        $milk = Milk::find($id);
        //Check if exist 
        if ($milk != null) {
            //Update and return updated 
            $milk->destroy($id);
            return response()->json([
                'Milk deleted'
            ]);
        } else {
            //If not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }
}
