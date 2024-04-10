<?php
//include 
use App\Http\Controllers\HerdController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\MilkController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*Routes herds*/
Route::resource('herds', HerdController::class);
//Connect herd to user when posting herd
Route::post ('users/{id}/herds', [UserController::class, 'addHerd']);
//Get all herds for one user
Route::get ('users/{id}/herds', [UserController::class, 'getHerdsByUser']);


/*Routes animals*/
Route::resource('animals', AnimalController::class);
//Update just image on animal
Route::post('animals/images/{id}', [AnimalController::class, 'updateAnimalImage']);
//Update animal with image
Route::post('animals/{id}', [AnimalController::class, 'updateAnimalAndImage']);
//Connect animal to herd when posting animal
Route::post ('herds/{id}/animals', [HerdController::class, 'addAnimal']);
//Get all animals for one herd
Route::get ('herds/{id}/animals', [HerdController::class, 'getAnimalsByHerd']);
//Get all milks from one herd
Route::get('herds/{id}/milks', [HerdController::class, 'getMilksByHerd']);


/*Routes milk*/
Route::resource('milks', MilkController::class);
//Connect milk to animal when posting milk
Route::post ('animals/{id}/milks', [AnimalController::class, 'addMilk']);
//Get all milks from one animal
Route::get ('animals/{id}/milks', [AnimalController::class, 'getMilksByAnimal']);

/*Routes messages*/
Route::resource('messages', MessageController::class);
//Connect message to user when posting message
Route::post ('users/{id}/messages', [UserController::class, 'addMessage']);
//Get all messages for one user
Route::get ('users/{id}/messages', [UserController::class, 'getMessagesByUser']);
//Get all animals for one user
Route::get('users/{id}/animals', [UserController::class, 'getAnimalsByUser']);


/*Route user*/ 
Route::resource('users', UserController::class);
//Update just user image
Route::post('users/images/{id}', [UserController::class, 'updateUserImage']); 
//update user with image 
Route::post('users/{id}', [UserController::class, 'updateUserAndImage']); 


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


