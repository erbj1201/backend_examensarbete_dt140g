<?php
//include 
use App\Http\Controllers\HerdController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\MilkController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CalfController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Restricted routes, authentication
Route::middleware(['auth:sanctum'])->group(function(){
/*Routes herds*/
 
//Get all herds
Route::get('herds', [HerdController::class, 'getAllHerds']);
//Get one herd by id
Route::get('herds/{id}', [HerdController::class, 'getHerdById'] );
//Update herd
Route::put('herds/{id}', [HerdController::class, 'updateHerd'] );
//Delete herd 
Route::delete('herds/{id}', [HerdController::class, 'destroyHerd'] );
//Connect herd to user when posting herd
Route::post ('herds/users/{id}', [UserController::class, 'addHerd']);
//Get all herds for one user
Route::get ('herds/users/{id}', [UserController::class, 'getHerdsByUser']);

/*Routes animals*/
//Get all animals
Route::get('animals', [AnimalController::class, 'getAllAnimals']);
//Get one animal by id
Route::get('animals/{id}', [AnimalController::class, 'getAnimalById'] );
//Update animal without image
Route::put('animals/{id}', [AnimalController::class, 'updateAnimal'] );
//Delete animal
Route::delete('animals/{id}', [AnimalController::class, 'destroyAnimal'] );
//Update just image on animal
Route::post('animals/images/{id}', [AnimalController::class, 'updateAnimalImage']);
//Update animal with image
Route::post('animals/{id}', [AnimalController::class, 'updateAnimalAndImage']);
//Connect animal to herd when posting animal
Route::post ('animals/herds/{id}', [HerdController::class, 'addAnimal']);
//Get all animals for one herd
Route::get ('animals/herds/{id}', [HerdController::class, 'getAnimalsByHerd']);
//Get all animals for one user
Route::get('animals/users/{id}', [UserController::class, 'getAnimalsByUser']);

/*Routes milk*/
//Get all milks
Route::get('milks', [MilkController::class, 'getAllMilks']);
//Get one milk by id
Route::get('milks/{id}', [MilkController::class, 'getMilkById'] );
//Update milk
Route::put('milks/{id}', [MilkController::class, 'updateMilk'] );
//Delete milk
Route::delete('milks/{id}', [MilkController::class, 'destroyMilk'] );
//Connect milk to animal when posting milk
Route::post ('milks/animals/{id}', [AnimalController::class, 'addMilk']);
//Get all milks from one animal
Route::get ('milks/animals/{id}', [AnimalController::class, 'getMilksByAnimal']);
//Get all milks from one herd
Route::get('milks/herds/{id}', [HerdController::class, 'getMilksByHerd']);

/*Routes messages*/
//Get all messages
Route::get('messages', [MessageController::class, 'getAllMessages']);
//Get one message by id
Route::get('messages/{id}', [MessageController::class, 'getMessageById'] );
//Update message
Route::put('messages/{id}', [MessageController::class, 'updateMessage'] );
//Delete message
Route::delete('messages/{id}', [MessageController::class, 'destroyMessage'] );
//Connect message to user when posting message
Route::post ('messages/users/{id}', [UserController::class, 'addMessage']);
//Get all messages for one user
Route::get ('messages/users/{id}', [UserController::class, 'getMessagesByUser']);

/*Routes Calves*/
//Get all calves
Route::get('calves', [CalfController::class, 'getAllCalves']);
//Get one calf by id
Route::get('calves/{id}', [CalfController::class, 'getCalfById']);
//Update calf
Route::put('calves/{id}', [CalfController::class, 'updateCalf'] );
//Delete calf
Route::delete('calves/{id}', [CalfController::class, 'destroyCalf'] );
//Connect calves to animal when posting message
Route::post ('calves/animals/{id}', [AnimalController::class, 'addCalf']);
//Get all calves for one animal
Route::get ('calves/animals/{id}', [AnimalController::class, 'getCalvesByAnimal']);
//Get all calves from one herd
Route::get('calves/herds/{id}', [HerdController::class, 'getCalvesByHerd']);

/*Routes Medicine*/
//Get all medicine 
Route::get('medicines', [MedicineController::class, 'getAllMedicines']);
//Get one medicine by id 
Route::get('medicines/{id}', [MedicineController::class, 'getMedicineById']);
//Update medicine 
Route::put('medicines/{id}', [MedicineController::class, 'updateMedicine']);
//Delete medicine
Route::delete('medicines/{id}', [MedicineController::class, 'destroyMedicine']);
//Connect medicine to animal when posting medicine 
Route::post ('medicines/animals/{id}', [AnimalController::class, 'addMedicine']);
//Get all medicine for one animal
Route::get ('medicines/animals/{id}', [AnimalController::class, 'getMedicinesByAnimal']);
//Get all medicines from one herd
Route::get('medicines/herds/{id}', [HerdController::class, 'getMedicinesByHerd']);

/*Routes Vaccine*/
//Get all vaccine
Route::get('vaccines', [VaccineController::class, 'getAllVaccines']);
//Get one medicine by id 
Route::get('vaccines/{id}', [VaccineController::class, 'getVaccineById']);
//Update medicine 
Route::put('vaccines/{id}', [VaccineController::class, 'updateVaccine']);
//Delete medicine
Route::delete('vaccines/{id}', [VaccineController::class, 'destroyVaccine']);
//Connect medicine to animal when posting medicine 
Route::post ('vaccines/animals/{id}', [AnimalController::class, 'addVaccine']);
//Get all medicine for one animal
Route::get ('vaccines/animals/{id}', [AnimalController::class, 'getVaccinesByAnimal']);
//Get all vaccines from one herd
Route::get('vaccines/herds/{id}', [HerdController::class, 'getVaccinesByHerd']);

/*Route user*/ 
//Log out user
Route::post('/logout', [UserController::class, 'logoutUser'])->middleware('auth:sanctum');
//Get one user by id
Route::get('users/{id}', [UserController::class, 'getUserById']);
//Get all users
Route::get('users', [UserController::class, 'getAllUsers']);
//Update just user image
Route::post('users/images/{id}', [UserController::class, 'updateUserImage']); 
//update user with image 
Route::post('users/{id}', [UserController::class, 'updateUserAndImage']); 
//update user without image
Route::put ('users/{id}', [UserController::class, 'updateUser']);
//Delete user
Route::delete('users/{id}', [UserController::class, 'destroyUser']); 
});

/*Endpoints without authorization*/
//Register new user
Route::post('register', [UserController::class, 'registerUser']);
//Log in user
Route::post ('/login', [UserController::class, 'loginUser']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


