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
Route::post ('herds/users/{id}', [UserController::class, 'addHerd']);
//Get all herds for one user
Route::get ('herds/users/{id}', [UserController::class, 'getHerdsByUser']);


/*Routes animals*/
Route::resource('animals', AnimalController::class);
//Update just image on animal
Route::post('animals/images/{id}', [AnimalController::class, 'updateAnimalImage']);
//Update animal with image
Route::post('animals/{id}', [AnimalController::class, 'updateAnimalAndImage']);
//Connect animal to herd when posting animal
Route::post ('animals/herds/{id}', [HerdController::class, 'addAnimal']);
//Get all animals for one herd
Route::get ('animals/herds/{id}', [HerdController::class, 'getAnimalsByHerd']);


/*Routes milk*/
Route::resource('milks', MilkController::class);
//Connect milk to animal when posting milk
Route::post ('milks/animals/{id}', [AnimalController::class, 'addMilk']);
//Get all milks from one animal
Route::get ('milks/animals/{id}', [AnimalController::class, 'getMilksByAnimal']);
//Get all milks from one herd
Route::get('milks/herds/{id}', [HerdController::class, 'getMilksByHerd']);

/*Routes messages*/
Route::resource('messages', MessageController::class);
//Connect message to user when posting message
Route::post ('messages/users/{id}', [UserController::class, 'addMessage']);
//Get all messages for one user
Route::get ('messages/users/{id}', [UserController::class, 'getMessagesByUser']);
//Get all animals for one user
Route::get('animals/users/{id}', [UserController::class, 'getAnimalsByUser']);


/*Route user*/ 
//Log in user
Route::login ('/login', [UserController::class, 'loginUser']);
//Log out user
Route::logout('/logout', [UserController::class, 'logoutUser']);
//Get one user by id
Route::get('users/{id}', [UserController::class, 'getUserById']);
//Get all users
Route::get('users', [UserController::class, 'getAllUsers']);
//Register new user
Route::post('register', [UserController::class, 'registerUser']);
//update user without image
Route::put ('users/{id}', [UserController::class, 'updateUser']);
//Update just user image
Route::post('users/images/{id}', [UserController::class, 'updateUserImage']); 
//update user with image 
Route::post('users/{id}', [UserController::class, 'updateUserAndImage']); 
//Delete user
Route::delete('users/{id}', [UserController::class, 'destroyUser']); 


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


