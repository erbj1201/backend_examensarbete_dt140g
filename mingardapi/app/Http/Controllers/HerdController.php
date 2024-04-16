<?php
/*Controller for herds*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herd;
use App\Models\Animal;

class HerdController extends Controller
{
    /*get all herds*/
    public function getAllHerds()
    {
        //return all herds
        return Herd::all();
    }

    /*get one herd by id*/
    public function getHerdById(string $id)
    {
        //find herd with given id, save as variable 
        $herd = Herd::find($id);
        //check if herd exist 
        if ($herd != null) {
            //return herd
            return $herd;
        } else {
            //if not exist, return 404
            return response()->json([
                'Herd not found'
            ], 404);
        }
    }

    /*Update herd by id*/
    public function updateHerd(Request $request, string $id)
    {
        //find herd with given id, save as variable 
        $herd = Herd::find($id);
        //check if herd exist 
        if ($herd != null) {
            //update herd and return updated herd
            $herd->update($request->all());
            return $herd;
        } else {
            //if not exist, return 404
            return response()->json([
                'Herd not found'
            ], 404);
        }
    }

    /*delete herd by id*/
    public function destroyHerd(string $id)
    {
        // find herd with given id, save as variable 
        $herd = Herd::find($id);
        //check if herd exist 
        if ($herd != null) {
            //delete herd and return updated herd
            $herd->destroy($id);
            return response()->json([
                'Herd deleted'
            ]);
        } else {
            //if not exist, return 404
            return response()->json([
                'Herd not found'
            ], 404);
        }
    }

    /*Animals*/
    /*Add animal to given herd */
    public function addAnimal(Request $request, $id)
    { //Find herd by given id
        $herd = Herd::find($id);
        //If null, return 404 
        if ($herd == null) {
            return response()->json([
                'Herd not found'
            ], 404);
        } //Validate data input
        $validatedData = $request->validate([
            'animalId' => 'required',
            'earNo' => 'required',
            'breed' => 'required',
            'name' => 'required',
            'birthDate' => 'required',
            'sex' => 'required',
            'category' => 'nullable',
            'imagepath' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048'
        ]); 
        
        $animal = new Animal();
        $animal->animalId = $validatedData['animalId'];
        $animal->earNo = $validatedData['earNo'];
        $animal->breed = $validatedData['breed'];
        $animal->name = $validatedData['name'];
        $animal->birthDate = $validatedData['birthDate'];
        $animal->sex = $validatedData['sex'];
        $animal->category= $validatedData['category'];
        
    
        //Upload images
        if ($request->hasFile('imagepath')) {
            $image = $request->file('imagepath');
            //Get unique name för the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            //Move uploaded image to storage directory
            $image->move(public_path('uploads'), $imageName);
            //Create URL for uploaded image
            $imageURL = asset('uploads/' . $imageName);
           // Save the image path in the animal object
            $animal->imagepath = $imageURL;
        }

     //Save animal, return 200 response ok
     $herd->animals()->save($animal);
     return response()->json([
         'Animal added to herd'
     ], 200);
 }

    /*Get all animals for one herd */
    public function getAnimalsByHerd($id)
    {    //Find herd by given id
        $herd = Herd::find($id);
        //If null, return 404 
        if ($herd == null) {
            return response()->json([
                'Herd not found'
            ], 404);
        } //Find animals
        $animals = Herd::find($id)->animals;
        //Return all animals 
        return $animals;
    }

    /*Get all milks from one herd*/
    public function getMilksByHerd($herdId)
    {
        //Get herd by given id
        $herd = Herd::find($herdId);
        //Check if herd exist
        if ($herd === null) {
            //if not exist, return 404
            return response()->json(['Herd not found'], 404);
        } //Create an empty collection of milks
        $milks = collect();
        //Loop all animals and get milks from every animal
        foreach ($herd->animals as $animal) {
            //merge animals with milks 
            $milks = $milks->merge($animal->milks);
        }//Return all milks from all animals 
        return $milks;
    }
}