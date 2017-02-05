<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Models\User;


/**********************************************************************************/
/* Note:
/* 
/* \App\Http\Middleware\VerifyCsrfToken::class,
/* was removed from Line 35 of app/Http/Kernel.php
/* to prevent csrf token check
/*
/**********************************************************************************/

class UserController extends Controller {

	private $User;

	public function __construct()
	{
		//parent::__construct();
		$this->User = new User;
	}

	
	/**********************************************************************************/
	/* Add user
	/**********************************************************************************/
	public function addUser(Request $request)
	{
		$first_name 	= $request->json('first_name');
		$last_name 		= $request->json('last_name');
		$gender 		= $request->json('gender');
		$country 		= $request->json('country');
		$email 			= $request->json('email');

		// response will be an array
		$response = $this->User->addUser($first_name, $last_name, $gender, $country, $email);

		return response()->json($response);
	}

	/**********************************************************************************/
	/* Update user
	/**********************************************************************************/
	public function updateUser(Request $request)
	{
		$id 			= $request->json('id');
		$first_name 	= $request->json('first_name');
		$last_name 		= $request->json('last_name');
		$gender 		= $request->json('gender');
		$country 		= $request->json('country');
		$email 			= $request->json('email');

		// response will be an array
		$response = $this->User->updateUser($id, $first_name, $last_name, $gender, $country, $email);

		return response()->json($response);
	}

	/**********************************************************************************/
	/* Deposit cash
	/**********************************************************************************/
	public function deleteUser(Request $request)
	{
		$user_id 	= $request->json('user_id');

		// response will be an array
		$response = $this->User->deleteUser($user_id);

		return response()->json($response);
	}

	/**********************************************************************************/
	/* Deposit cash
	/**********************************************************************************/
	public function depositCash(Request $request)
	{
		$user_id 	= $request->json('user_id');
		$amount 	= $request->json('amount');

		// response will be an array
		$response = $this->User->addTransaction($user_id, 'deposit', $amount);

		return response()->json($response);
	}

	/**********************************************************************************/
	/* Withdraw cash
	/**********************************************************************************/
	public function withdrawCash(Request $request)
	{
		$user_id 	= $request->json('user_id');
		$amount 	= $request->json('amount');

		// response will be an array
		$response = $this->User->addTransaction($user_id, 'withdraw', $amount);

		return response()->json($response);
	}

	/**********************************************************************************/
	/* Get report data
	/**********************************************************************************/
	public function reportTransactions(Request $request)
	{
		$from 	= $request->json('from');
		$to 	= $request->json('to');

		// response will be an array
		$response = $this->User->getTransactions($from, $to);

		return response()->json($response);
	}






}
