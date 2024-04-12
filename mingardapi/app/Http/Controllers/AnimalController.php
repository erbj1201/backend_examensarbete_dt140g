<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Milk;

class AnimalController extends Controller
{
    /*get all animals*/
    public function getAllAnimals()
    {
        //return all animals
        return Animal::all();
    }
    /*get one animal by id*/
    public function getAnimalById(string $id)
    {
        //find animal with given id, save as variable 
        $animal = Animal::find($id);
        //check if exist 
        if ($animal != null) {
            //return 
            return $animal;
        } else {
            //if not exist, return 404
            return response()->json([
                'Animal not found'
            ], 404);
        }
    }

    /*Update animal by id*/
    public function updateAnimal(Request $request, string $id)
    {
        //find with given id, save as variable 
        $animal = Animal::find($id);
        //check if exist 
        if ($animal != null) {
            //update and return updated 
            $animal->update($request->all());
            return $animal;
        } else {
            //if not exist, return 404
            return response()->json([
                'Animal not found'
            ], 404);
        }
    }

    /*Update just animal image by id */
    public function updateAnimalImage(Request $request, string $id){
        //find with given id, save as variabl
        $animal = Animal::find($id);
        //check if exist 
    if ($animal != null) {
        $request->validate([
            'imagepath' => 'image|mimes:jpeg,png,jpg,gif|max:4048'
        ]);
         //if file is uploaded
         if ($request->hasFile('imagepath')) {
            $image = $request->file('imagepath');
              //Get unique name för the image
              $imageName = time() . '.' . $image->getClientOriginalExtension();
              //Move uploaded image to storage directory
              $image->move(public_path('uploads'), $imageName);
              //Create URL for uploaded image
              $imageURL = asset('uploads/' . $imageName);
              //Add image to array
              $data['imagepath'] = $imageURL;
              //If no file uploaded
      } else { 
          return response()->json([
              'No image uploaded'], 400);
      }
      //Update image
      $animal->update($data);
      return $animal;
  } //If animal not found, return 404
  return response()->json([
      'Animal not found'], 404);
    }

/*Update animal and image*/
public function updateAnimalAndImage(Request $request, string $id){
    //find with given id, save as variable 
    $animal = Animal::find($request->id);
    //check if exist and validate text
    if ($animal != null) {
        $request->validate([
            'animalId' => 'required',
            'earNo' => 'required',
            'breed' => 'required',
            'name' => 'required',
            'birthDate' => 'required',
            'sex' => 'required',
            'category' => 'required',
        ]);
        // Create an empty array 
        $data = [];
        //if file is uploaded
        if($request->hasFile('imagepath')){ 
        //validate image
        $request->validate([
        'imagepath' => 'image|mimes:jpeg,png,jpg,gif|max:4048'
    ]);
            $image = $request->file('imagepath');
              //Get unique name för the image
              $imageName = time() . '.' . $image->getClientOriginalExtension();
              //Move uploaded image to storage directory
              $image->move(public_path('uploads'), $imageName);
              //Create URL for uploaded image
              $imageURL = asset('uploads/' . $imageName);

              //Remove image from request
              unset($request['imagepath']);
              //Add image to array
              $data['imagepath'] = $imageURL;
      } 
      //Merge updated data with existing request data
      $data = array_merge($request->all(), $data);
      //Update animal
      $animal->update($data);
      return $animal;
  } //If animal not found, return 404
  return response()->json([
      'Animal not found'], 404);
    }
    


    /*delete animal by id*/
    public function destroyAnimal(string $id)
    {
        //find with given id, save as variable 
        $animal = Animal::find($id);
        //check if exist 
        if ($animal != null) {
            //update and return updated 
            $animal->destroy($id);
            return response()->json([
                'Animal deleted'
            ]);
        } else {
            //if not exist, return 404
            return response()->json([
                'Animal not found'
            ], 404);
        }
    }

    /*Milks*/
    /*Add milks to given animal */
    public function addMilk(Request $request, $id)
    { //Find animal by given id
        $animal = Animal::find($id);
        //If null, return 404 
        if ($animal == null) {
            return response()->json([
                'Animal not found'
            ], 404);
        } //Validate data input
        $validatedData = $request->validate([
            'kgMilk' => 'required',
            'milkDate' => 'required'
        ]); //Create new instance of class 
        $milk = new Milk();
        $milk->kgMilk = $validatedData['kgMilk'];
        $milk->milkDate = $validatedData['milkDate'];
        //Save animal, return 200 response ok
        $animal->milks()->save($milk);
        return response()->json([
            'Milk added to animal'
        ], 200);
    }

    /*Get all milks for one animal */
    public function getMilksByAnimal($id)
    {    //Find animal by given id
        $animal = Animal::find($id);
        //If null, return 404 
        if ($animal == null) {
            return response()->json([
                'Animal not found'
            ], 404);
        } //Find milks
        $milks = Animal::find($id)->milks;
        //Return all milks
        return $milks;
    }

}

