<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Tweet;

class TweetController extends Controller
{
    public function __construct(){

		$this->middleware('auth');

	}

    public function store(){

        $body = request('body');

    	$tweet = new Tweet;
    	$tweet->body = $body;
    	$tweet->user_id = Auth::user()->id;
    	$tweet->save();

        if(strpos($body, '@') !== false){
            $body = explode('@', $body);
            $partial_body = explode(' ', $body[1]);

            if($user = User::where('name', $partial_body[0])->first()){
                Auth::user()->mentions()->attach($tweet->id, ['user_id' => $user->id]);
                event(new \App\Events\ActionTrigerred(Auth::user()->id, 'mentioned', $tweet->id, $user->id));
                
                return response([
                        'message' => 'you have posted a tweet and mentioned ' .$user->name . ' successfully!',
                        'status' => '200'
                ]);
            }
        }
        event(new \App\Events\ActionTrigerred(Auth::user()->id, 'tweeted', $tweet->id));
        
        return response([
                'message' => 'you have posted a tweet',
                'status' => '200'
        ]);

    }

    public function like(){

        $tweet = Tweet::find(request('tweet_id'));

        foreach (Auth::user()->likes as $liked_tweet) {
            if($liked_tweet->id == $tweet->id){
                $tweet->no_likes--;
                $tweet->update();
                Auth::user()->likes()->detach($tweet->id);

                return response([
                        'message' => 'you have unliked the tweet with the ID of ' . $tweet->id,
                        'status' => '200'
                ]);
            }
        }

        $tweet->no_likes++;
        $tweet->update();

        Auth::user()->likes()->attach($tweet->id);
        event(new \App\Events\ActionTrigerred(Auth::user()->id, 'liked', $tweet->id));

        return response([
                'message' => 'you have liked the tweet with the ID of ' . $tweet->id,
                'status' => '200'
        ]);

    }

    public function destroy(){

        $tweet = Tweet::findOrFail(request('tweet_id'));

    	if(Auth::user()->id == $tweet->user_id){
            $tweet = Tweet::find(request('tweet_id'));
    		$tweet->delete();

            return response([
                'message' => 'you have deleted the tweet with the ID of ' . $tweet->id,
                'status' => '200'
            ]);
        }

        return response([
                'message' => 'you can not delete other users\' tweets',
                'status' => '404'
        ]);

    }
}
