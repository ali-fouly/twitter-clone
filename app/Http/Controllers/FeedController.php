<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Tweet;

class FeedController extends Controller
{
    public function __construct(){

		$this->middleware('auth');

	}

    public function newsFeed(){

    	$tweets = array();

		$auth_tweets = auth()->user()->tweets;
		foreach ($auth_tweets as $tweet) {
			$tweets[] = json_decode($tweet, true);
		}

		$followers = auth()->user()->followers;
		foreach ($followers as $follower) {
			foreach ($follower->tweets as $tweet) {
				$tweets[] = json_decode($tweet, true);
			}
		}

		usort($tweets, array('App\Http\Controllers\FeedController', 'sort_by_time'));

		return response()->json($tweets);

		/*foreach ($tweets as $tweet) {
		 	echo 'User ' . $tweet['user_id'] . ' tweeted ' . '\'' .$tweet['body'] . '\' at ' . $tweet['created_at'] .'<br>'; //return tweets ordered by date & time
		 }*/
	}

	public function activityFeed(){


	}


	private static function sort_by_time($a,$b)
	{

        return strtotime($b['created_at']) - strtotime($a['created_at']);
    }
}
