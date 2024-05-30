<!--Webbutvecklingsprogrammet
Självständigt arbete DT140G
Erika Vestin & Sofia Dahlberg -->

<?php
/*Controller for herds*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herd;
use App\Models\Animal;

class HerdController extends Controller
{
    /*Get all herds*/
    public function getAllHerds()
    {
        //Return all herds
        return Herd::all();
    }

    /*Get one herd by id*/
    public function getHerdById(string $id)
    {
        //Find herd with given id, save as variable 
        $herd = Herd::find($id);
        //Check if herd exist 
        if ($herd != null) {
            //Return herd
            return $herd;
        } else {
            //If not exist, return 404
            return response()->json([
                'Herd not found'
            ], 404);
        }
    }

    /*Update herd by id*/
    public function updateHerd(Request $request, string $id)
    {
        //Find herd with given id, save as variable 
        $herd = Herd::find($id);
        //Check if herd exist 
        if ($herd != null) {
            //Update herd and return updated herd
            $herd->update($request->all());
            return $herd;
        } else {
            //If not exist, return 404
            return response()->json([
                'Herd not found'
            ], 404);
        }
    }

    /*Delete herd by id*/
    public function destroyHerd(string $id)
    {
        // Find herd with given id, save as variable 
        $herd = Herd::find($id);
        //Check if herd exist 
        if ($herd != null) {
            //Delete herd and return updated herd
            $herd->destroy($id);
            return response()->json([
                'Herd deleted'
            ]);
        } else {
            //If not exist, return 404
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
        $animal->category = $validatedData['category'];


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

    /*Get all animals from one herd */
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

    /*Get all calves from one herd*/
    public function getCalvesByHerd($herdId)
    {
        //Get herd by given id
        $herd = Herd::find($herdId);
        //Check if herd exist
        if ($herd === null) {
            //if not exist, return 404
            return response()->json(['Herd not found'], 404);
        } //Create an empty collection of calves
        $calves = collect();
        //Loop all animals and get calves from every animal
        foreach ($herd->animals as $animal) {
            //merge animals with calves
            $calves = $calves->merge($animal->calves);
        }//Return all calves from all animals 
        return $calves;
    }

    /*Get all medicines from one herd*/
    public function getMedicinesByHerd($herdId)
    {
        //Get herd by given id
        $herd = Herd::find($herdId);
        //Check if herd exist
        if ($herd === null) {
            //if not exist, return 404
            return response()->json(['Herd not found'], 404);
        } //Create an empty collection of medicines
        $medicines = collect();
        //Loop all animals and get medicines from every animal
        foreach ($herd->animals as $animal) {
            //merge animals with medicines
            $medicines = $medicines->merge($animal->medicines);
        }//Return all medicines from all animals 
        return $medicines;
    }

    /*Get all vaccines from one herd*/
    public function getVaccinesByHerd($herdId)
    {
        //Get herd by given id
        $herd = Herd::find($herdId);
        //Check if herd exist
        if ($herd === null) {
            //if not exist, return 404
            return response()->json(['Herd not found'], 404);
        } //Create an empty collection of vaccines
        $vaccines = collect();
        //Loop all animals and get vaccines from every animal
        foreach ($herd->animals as $animal) {
            //merge animals with vaccines
            $vaccines = $vaccines->merge($animal->vaccines);
        }//Return all vaccines from all animals 
        return $vaccines;
    }
}