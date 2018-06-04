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

		$tweets = auth()->user()->tweets;

		$followers = auth()->user()->followers;

		foreach ($followers as $follower) {
			$tweets = $tweets->merge($follower->tweets);
		}

		$tweets = $tweets->sortByDesc('created_at');

		//return response()->json($tweets);
		return response([
			'data' => $tweets
		]);

	}

	public function activityFeed(){

		$logs = auth()->user()->logs;

		$followings = auth()->user()->followings;
		
		foreach ($followings as $following) {
			$logs = $logs->merge($following->logs);
		}

		$logs = $logs->sortByDesc('created_at');

		return response([
			'data' => $logs
		]);


	}
}
