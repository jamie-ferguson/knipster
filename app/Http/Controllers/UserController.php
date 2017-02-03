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
	/* Add user.
	/**********************************************************************************/
	public function addUser(Request $request)
	{
		// curl -X POST -H 'Content-Type: application/json'
		// -d '{"first_name":"Jamie","last_name":"Ferguson","gender":"M","country":"UK","email":"jamiekferguson@gmail.com"}'
		// http://localhost:8888/knipster/public/add-user

		$first_name 	= $request->json('first_name');
		$last_name 		= $request->json('last_name');
		$gender 		= $request->json('gender');
		$country 		= $request->json('country');
		$email 			= $request->json('email');

		// response will be an array
		$response = $this->User->addUser($first_name, $last_name, $gender, $country, $email);

		return response()->json($response) . PHP_EOL;
	}

	/**********************************************************************************/
	/* Update user.
	/**********************************************************************************/
	public function updateUser(Request $request)
	{
		// curl -X POST -H 'Content-Type: application/json'
		// -d '{"id":3,"first_name":"Jamie","last_name":"Ferguson","gender":"M","country":"UK","email":"jamiekferguson@gmail.com"}'
		// http://localhost:8888/knipster/public/update-user

		$id 			= $request->json('id');
		$first_name 	= $request->json('first_name');
		$last_name 		= $request->json('last_name');
		$gender 		= $request->json('gender');
		$country 		= $request->json('country');
		$email 			= $request->json('email');

		// response will be an array
		$response = $this->User->updateUser($id, $first_name, $last_name, $gender, $country, $email);

		return response()->json($response) . PHP_EOL;
	}

	/**********************************************************************************/
	/* Deposit cash
	/**********************************************************************************/
	public function depositCash(Request $request)
	{
		// curl -X POST -H 'Content-Type: application/json' 
		// -d '{"user_id":2,"amount":21.34}'
		// http://localhost:8888/knipster/public/deposit

		$user_id 	= $request->json('user_id');
		$amount 	= $request->json('amount');

		// response will be an array
		$response = $this->User->addTransaction($user_id, 'deposit', $amount);

		return response()->json($response) . PHP_EOL;
	}

	/**********************************************************************************/
	/* Withdraw cash
	/**********************************************************************************/
	public function withdrawCash(Request $request)
	{
		// curl -X POST -H 'Content-Type: application/json' 
		// -d '{"user_id":2,"amount":21.34}'
		// http://localhost:8888/knipster/public/withdraw

		$user_id 	= $request->json('user_id');
		$amount 	= $request->json('amount');

		// response will be an array
		$response = $this->User->addTransaction($user_id, 'withdraw', $amount);

		return response()->json($response) . PHP_EOL;
	}

	/**********************************************************************************/
	/* Get report data
	/**********************************************************************************/
	public function reportTransactions(Request $request)
	{
		// curl -X POST -H 'Content-Type: application/json' 
		// -d '{"from":"2017-01-01","to":"2017-01-20"}'
		// http://localhost:8888/knipster/public/report

		$from 	= $request->json('from');
		$to 	= $request->json('to');

		// response will be an array
		$response = $this->User->getTransactions($from, $to);

		return response()->json($response) . PHP_EOL;
	}






}
