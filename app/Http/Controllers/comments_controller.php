<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class comments_controller extends Controller
{
    public function add_comment(Request $request)
    {
        $comment = new Comments;
        $comment->name = $request->input('name');
        $comment->phone_number = $request->input('phone_number');
        $comment->comment = $request->input('comment');
        $comment->email = $request->input('email');    
        if($comment->save()){
            return array('color'=>'green','message'=>'نظر شما ثبت شد');
        } else {
            return array('color'=>'red','message'=>'نظر شما ثبت نشد!!!');
        }
    }
    public function getComments()
    {
        $comments = Comments::select('created_at', 'comment')->get();
        return response()->json($comments);
    }    
}
