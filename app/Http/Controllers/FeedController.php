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

		$followers = auth()->user()->followers;

		foreach ($followers as $follower) {
			$tweets = $auth_tweets->merge($follower->tweets);
		}

		$tweets = json_decode($tweets, true);

		usort($tweets, array('App\Http\Controllers\FeedController', 'sort_by_time'));

		return response()->json($tweets);
		
	}

	public function activityFeed(){


	}


	private static function sort_by_time($a,$b)
	{

        return strtotime($b['created_at']) - strtotime($a['created_at']);
    }
}
