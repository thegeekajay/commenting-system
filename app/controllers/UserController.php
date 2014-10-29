<?php

class UserController extends \BaseController {

	public function login(){

		// get data from input
		$code = Input::get( 'code' );

		// get fb service
		$fb = OAuth::consumer( 'Facebook' );

		if ( !empty( $code ) ) {

			// This was a callback request from facebook, get the token
			$token = $fb->requestAccessToken( $code );

			// Send a request with it
			$result = json_decode( $fb->request( '/me' ), true );


			// Storing the data in variable
			$name 	=	$result['name'];
			$email 	=	$result['email'];
			$id		=	$result['id'];


			// Check whether user is registered

			$user = User::where('email',$email)->first();

			if(!isset($user->id))
			{

			// Register a user

			$user = new User;
			$user->email		=	$email;
			$user->facebook_id	=	$id;
			$user->name 		=	$name;
			$user->save();

			}


			// Login

			Auth::loginUsingId($user->id);

			return Redirect::route('yoda');


		}else{
			echo "Something went wrong";
		}

	}

	public function logout(){
		Auth::logout();
		return Redirect::to('/');
	}

}