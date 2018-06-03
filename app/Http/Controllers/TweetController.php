<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function __construct(){

		$this->middleware('auth');

	}

    public function store(){

        return Auth::user()->mentioners;

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
                return 'you have posted a tweet and mentioned ' .$user->name . ' successfully!';
            }
        }

        return 'you have posted a tweet';

    }

    public function like(){

        $tweet = Tweet::find(request('tweet_id'));

        foreach (Auth::user()->likes as $liked_tweet) {
            if($liked_tweet->id == $tweet->id){
                $tweet->no_likes--;
                $tweet->update();
                Auth::user()->likes()->detach($tweet->id);
                return 'you have unliked the tweet with the ID of ' . $tweet->id;
            }
        }

        $tweet->no_likes++;
        $tweet->update();

        Auth::user()->likes()->attach($tweet->id);
        return 'you have liked the tweet with the ID of ' . $tweet->id;

    }

    public function destroy(){

        $tweet = Tweet::findOrFail(request('tweet_id'));

    	if(Auth::user()->id == $tweet->user_id){
            $tweet = Tweet::find(request('tweet_id'));
    		$tweet->delete();

            return 'you have deleted the tweet with the ID of ' . $tweet->id;
        }

        return 'you can not delete other users\' tweets';

    }
}