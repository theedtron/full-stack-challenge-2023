<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index(){
        $comments = Comment::query()->get();
        foreach($comments as $comment){
            $user = User::query()->find($comment->user_id);
            $comment->username = $user->name;
        }
        return view('comments.index',compact('comments'));
    }

    public function referralComments($id){
        $comments = Comment::query()->where('referral_id',$id)->get();
        foreach($comments as $comment){
            $user = User::query()->find($comment->user_id);
            $comment->username = $user->name;
        }

        return view('comments.index',compact('comments'));
    }

    public function create($referral_id){
        return view('comments.create',compact('referral_id'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'comment' => 'required|string|max:512',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user()->id,
            'referral_id' => $request->referral_id
        ]);

        $request->session()->flash('status','comment added successfuly!');
        return redirect('referrals');
    }

    public function delete($id){
        $comment = Comment::query()->find($id);
        $comment->delete();

        request()->session()->flash('status','comment deleted successfuly!');
        return redirect('referrals');
    }

}
