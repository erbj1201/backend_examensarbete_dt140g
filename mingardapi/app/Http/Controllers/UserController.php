<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Message;
use App\Models\Herd;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*Get all user*/
    public function getAllUsers()
    {
        //Return all 
        return User::all();
    }

    /*Post new user*/
    public function registerUser(Request $request)
    {
        //Custom validation for email uniqueness
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'Email already exists',
            ], 400);
        }
        //Validate requested data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'imagepath' => 'image|mimes:jpeg,png,jpg,gif|max:4048'
        ]);

        $data = $request->all();
        //Upload images
        if ($request->hasFile('imagepath')) {
            $image = $request->file('imagepath');
            //Get unique name för the image
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            //Move uploaded image to storage directory
            $image->move(public_path('uploads'), $imageName);
            //Create URL for uploaded image
            $imageURL = asset('uploads/' . $imageName);
            $data['imagepath'] = $imageURL;
        }
        //Store user
        return User::create($data);
    }

    //Login user
    public function loginUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email or password incorrect',
            ], 404);
        }
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            "userId" => $user->id,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }
    //Logout user
    public function logoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]
        );
    }

    /*Get one user by id*/
    public function getUserById(string $id)
    {
        //Find user with given id, save as variable 
        $user = user::find($id);
        $user->makeVisible(['password']);
        //Check if exist 
        if ($user != null) {
            //Return 
            return $user;
        } else {
            //If not exist, return 404
            return response()->json([
                'User not found'
            ], 404);
        }
    }
    /*Update user by id, without image*/
    public function updateUser(Request $request, string $id)
    {
        //find with given id, save as variable 
        $user = User::find($id);
        // Check if password field is present in the request
        if ($request->has('password')) {
            // Use Hash::check() to compare the provided password with the hashed password in the database
            if (!Hash::check($request->password, $user->password)) {
                // If the passwords don't match, return an error response
                return response()->json([
                    'message' => 'Incorrect password'
                ], 400);
            }
        }
        // Check if user exists
        if ($user != null) {
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id), // Ignore current user's email
                ],
            ]);

            // Update and return the updated user
            $user->update($request->all());
            return $user;
        } else {
            // If user does not exist, return 404
            return response()->json([
                'User not found'
            ], 404);
        }
    }
    /*Update just user image by id*/
    public function updateUserImage(Request $request, string $id)
    {
        //find with given id, save as variable 
        $user = User::find($id);
        //check if exist 
        if ($user != null) {
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
                    'No image uploaded'
                ], 400);
            }
            //Update image
            $user->update($data);
            return $user;
        } //If user not found, return 404
        return response()->json([
            'User not found'
        ], 404);
    }

    /**Update user and image */
    public function updateUserAndImage(Request $request, string $id)
    {
        //find with given id, save as variable 
        $user = User::find($request->id);
        // Check if password field is present in the request
        if ($request->has('password')) {
            // Use Hash::check() to compare the provided password with the hashed password in the database
            if (!Hash::check($request->password, $user->password)) {
                // If the passwords don't match, return an error response
                return response()->json([
                    'message' => 'Incorrect password'
                ], 400);
            }
        }
        // Check if user exists
        if ($user != null) {
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id), // Ignore current user's email
                ],
            ]);
            // Create an empty array 
            $data = [];

            //If file is uploaded
            if ($request->hasFile('imagepath')) {
                //Validate image
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
            //Update user
            $user->update($data);
            return $user;
        }
        return response()->json([
            'User not found'
        ], 404);
    }

    /*Delete user by id*/
    public function destroyUser(string $id)
    {
        //Find with given id, save as variable 
        $user = User::find($id);
        //Check if exist 
        if ($user != null) {
            //Update and return updated 
            $user->destroy($id);
            return response()->json([
                'User deleted'
            ]);
        } else {
            //If not exist, return 404
            return response()->json([
                'User not found'
            ], 404);
        }
    }
    /* Message */

    /*Add message to given user by id*/
    public function addMessage(Request $request, $id)
    {   //Find user by given id
        $user = User::find($id);
        //If null, return 404 
        if ($user == null) {
            return response()->json([
                'User not found'
            ], 404);
        } //Validate data input
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]); //Create new instance of class 
        $message = new Message();
        $message->title = $validatedData['title'];
        $message->description = $validatedData['description'];
        //Save message, return 200 response ok
        $user->messages()->save($message);
        return response()->json([
            'Message added to user'
        ], 200);
    }

    /*Get all messages for one user */
    public function getMessagesByUser($id)
    {    //Find user by given id
        $user = User::find($id);
        //If null, return 404 
        if ($user == null) {
            return response()->json([
                'User not found'
            ], 404);
        } //Find messages 
        $messages = User::find($id)->messages;
        //Return all messages 
        return $messages;
    }

    /** Herds*/
    /*Add herd to given user */
    public function addHerd(Request $request, $id)
    {  //Find user by given id
        $user = User::find($id);
        //If null, return 404 
        if ($user == null) {
            return response()->json([
                'User not found'
            ], 404);
        } //Validate data input
        $validatedData = $request->validate([
            'herdId' => 'required',
            'address' => 'required'
        ]);
        //Create new instance of class 
        $herd = new Herd();
        $herd->herdId = $validatedData['herdId'];
        $herd->address = $validatedData['address'];
        //Save herd, return 200 response ok
        $user->herds()->save($herd);
        return response()->json([
            'Herd added to user'
        ], 200);

    }

    /*Get all herds for given user*/
    public function getHerdsByUser($id)
    {//Find user by given id
        $user = User::find($id);
        //If null, return 404 
        if ($user == null) {
            return response()->json([
                'User not found'
            ], 404);
        }   //Find herds
        $herds = User::find($id)->herds;
        //return all herds
        return $herds;
    }

    /*Get all animals in all the users herds*/
    public function getAnimalsByUser($userid)
    {
        //Get given user
        $user = User::find($userid);
        //Check if exist
        if ($user == null) {
            //return 404
            return response()->json(['User not found'], 404);
        }
        //Create an empty collection of animals
        $animals = collect();
        // Loop user's herds and get all animals
        foreach ($user->herds as $herd) {
            //Merge herd with animals
            $animals = $animals->merge($herd->animals);
        }
        //Return all animals from all herds from one user
        return $animals;
    }
}

