<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Milk;
use App\Models\Calf;
use App\Models\Medicine;
use App\Models\Vaccine;

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
            $request->validate([
                'animalId' => 'required',
                'earNo' => 'required',
                'breed' => 'required',
                'name' => 'required',
                'birthDate' => 'required',
                'sex' => 'required',
                'category' => 'required',
            ]);
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
/*Calf, add calf to given animal*/
    public function addCalf(Request $request, string $id)
    {
       //find with given id, save as variable 
       $animal = Animal::find($id);
       //check if exist 
       if ($animal != null) {
        $validatedData = $request->validate([
            'animalId' => 'required',
            'earNo' => 'required',
            'breed' => 'required',
            'name' => 'required',
            'expectedBirthDate' => 'required',
            'birthDate' => 'required',
            'sex' => 'required',
            'category' => 'required',
        ]);
        //Create new instance of class 
        $calf = new Calf();
        $calf->animalId = $validatedData['animalId'];
        $calf->earNo = $validatedData['earNo'];
        $calf->breed = $validatedData['breed'];
        $calf->name = $validatedData['name'];
        $calf->expectedBirthDate = $validatedData['expectedBirthDate'];
        $calf->birthDate = $validatedData['birthDate'];
        $calf->sex = $validatedData['sex'];
        $calf->category = $validatedData['category'];
        //Save animal, return 200 response ok
        $animal->calves()->save($calf);
        return response()->json([
            'Calf added to animal'
        ], 200);

       }
    }

 /*Get all calves for one animal */
 public function getCalvesByAnimal($id)
 {    //Find animal by given id
     $animal = Animal::find($id);
     //If null, return 404 
     if ($animal == null) {
         return response()->json([
             'Animal not found'
         ], 404);
     } //Find calves
     $calves = Animal::find($id)->calves;
     //Return all calves
     return $calves;
 }
 /*Medcine, add medicine to given animal*/
 public function addMedicine(Request $request, string $id)
 {
    //find with given id, save as variable 
    $animal = Animal::find($id);
    //check if exist 
    if ($animal != null) {
     $validatedData = $request->validate([
         'date' => 'required',
         'type' => 'required',
         'amount' => 'required',
         'recurrent' => 'required',
     ]);
     //Create new instance of class 
     $medicine = new Medicine();
     $medicine->date = $validatedData['date'];
     $medicine->type = $validatedData['type'];
     $medicine->amount = $validatedData['amount'];
     $medicine->recurrent = $validatedData['recurrent'];
     
     //Save animal, return 200 response ok
     $animal->medicines()->save($medicine);
     return response()->json([
         'Medicine added to animal'
     ], 200);

    }
 }

/*Get all medicines for one animal */
public function getMedicinesByAnimal($id)
{    //Find animal by given id
  $animal = Animal::find($id);
  //If null, return 404 
  if ($animal == null) {
      return response()->json([
          'Animal not found'
      ], 404);
  } //Find calves
  $medicines = Animal::find($id)->medicines;
  //Return all medicines
  return $medicines;
}
/*Vaccines*/ 
 /*add vaccine to given animal*/
 public function addVaccine(Request $request, string $id)
 {
    //find with given id, save as variable 
    $animal = Animal::find($id);
    //check if exist 
    if ($animal != null) {
     $validatedData = $request->validate([
         'batchNo' => 'required',
         'name' => 'required',
         'date' => 'required',
     ]);
     //Create new instance of class 
     $vaccine = new Vaccine();
     $vaccine->batchNo = $validatedData['batchNo'];
     $vaccine->name = $validatedData['name'];
     $vaccine->date = $validatedData['date'];
     
     //Save animal, return 200 response ok
     $animal->vaccines()->save($vaccine);
     return response()->json([
         'Vaccine added to animal'
     ], 200);

    }
 }
/*Get all vaccines for one animal */
public function getVaccinesByAnimal($id)
{    //Find animal by given id
  $animal = Animal::find($id);
  //If null, return 404 
  if ($animal == null) {
      return response()->json([
          'Animal not found'
      ], 404);
  } //Find calves
  $vaccines = Animal::find($id)->vaccines;
  //Return all vaccines
  return $vaccines;
}

}

