<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /*get all messages*/
    public function index()
    {
        //return all
        return Message::all();
    }
    /*get one message by id*/
    public function show(string $id)
    {
        //find message with given id, save as variable 
        $message = Message::find($id);
        //check if exist 
        if ($message != null) {
            //return 
            return $message;
        } else {
            //if not exist, return 404
            return response()->json([
                'Message not found'
            ], 404);
        }
    }

    /*Update message by id*/
    public function update(Request $request, string $id)
    {
        //find with given id, save as variable 
        $message = Message::find($id);
        //check if exist 
        if ($message != null) {
            //update and return updated 
            $message->update($request->all());
            return $message;
        } else {
            //if not exist, return 404
            return response()->json([
                'Message not found'
            ], 404);
        }
    }

    /*delete message by id*/
    public function destroy(string $id)
    {
        //find with given id, save as variable 
        $message = Message::find($id);
        //check if exist 
        if ($message != null) {
            //update and return updated 
            $message->destroy($id);
            return response()->json([
                'Message deleted'
            ]);
        } else {
            //if not exist, return 404
            return response()->json([
                'Message not found'
            ], 404);
        }
    }
}
