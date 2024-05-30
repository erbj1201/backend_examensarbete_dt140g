<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /*Get all messages*/
    public function getAllMessages()
    {
        //Return all
        return Message::all();
    }

    /*Get one message by id*/
    public function getMessageById(string $id)
    {
        //Find message with given id, save as variable 
        $message = Message::find($id);
        //Check if exist 
        if ($message != null) {
            //Return 
            return $message;
        } else {
            //If not exist, return 404
            return response()->json([
                'Message not found'
            ], 404);
        }
    }

    /*Update message by id*/
    public function updateMessage(Request $request, string $id)
    {
        //Find with given id, save as variable 
        $message = Message::find($id);
        //Check if exist 
        if ($message != null) {
            //Update and return updated 
            $message->update($request->all());
            return $message;
        } else {
            //If not exist, return 404
            return response()->json([
                'Message not found'
            ], 404);
        }
    }

    /*Delete message by id*/
    public function destroyMessage(string $id)
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
