<?php

namespace App\Http\Controllers;

use App\Models\Milk;
use Illuminate\Http\Request;

class MilkController extends Controller
{
    /*get all milk*/
    public function index()
    {
        //return all 
        return Milk::all();
    }

    /*Post new milk */
    public function store(Request $request)
    {
        //validate input
        $request->validate([
            'kgMilk' => 'required',
            'milkDate' => 'required'
        ]);
        return Milk::create($request->all());
    }

    /*get one milk by id*/
    public function show(string $id)
    {
        //find milk with given id, save as variable 
        $milk = Milk::find($id);
        //check if exist 
        if ($milk != null) {
            //return 
            return $milk;
        } else {
            //if not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }

    /*Update milk by id*/
    public function update(Request $request, string $id)
    {
        //find with given id, save as variable 
        $milk = Milk::find($id);
        //check if exist 
        if ($milk != null) {
            //update and return updated 
            $milk->update($request->all());
            return $milk;
        } else {
            //if not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }

    /*delete milk by id*/
    public function destroy(string $id)
    {
        //find with given id, save as variable 
        $milk = Milk::find($id);
        //check if exist 
        if ($milk != null) {
            //update and return updated 
            $milk->destroy($id);
            return response()->json([
                'Milk deleted'
            ]);
        } else {
            //if not exist, return 404
            return response()->json([
                'Milk not found'
            ], 404);
        }
    }
}
