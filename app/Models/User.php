<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;

class User extends Eloquent {

	protected $table = 'users';


	public function addUser($first_name, $last_name, $gender, $country, $email){

		// check if the email address has been stored.
		$email_id = DB::table('users')
			->select('id')
			->where('email', '=', $email)
			->get();


		if(!empty($email_id[0]->id)){
			return array('error' => 'Email address already exists.');
		}

		// create a new user record including random bonus parameter
		$bonus_parameter = rand(5,20);
		$user_id = DB::table('users')->insertGetId(
		    array(	'first_name' 	=> $first_name,
		    		'last_name' 	=> $last_name,
		    		'gender' 		=> $gender,
		    		'country_code' 	=> $country,
		    		'email' 		=> $email,
		    		'bonus_parameter' => $bonus_parameter,
		    	)
		);

		return array('User ID' => $user_id);
	}


	public function updateUser($id, $first_name, $last_name, $gender, $country, $email){
		// check if the user exists.
		$id_check = DB::table('users')
			->select('id')
			->where('id', '=', $id)
			->get();

		if(empty($id_check[0]->id)){
			return array('error' => 'User does not exist.');
		}

		// check if the email address has been stored.
		$email_id = DB::table('users')
			->select('id')
			->where('email', '=', $email)
			->get();

		if(!empty($email_id[0]->id)){
			return array('error' => 'Email address already exists.');
		}

		// update user record including random bonus parameter
		$affectedRows = DB::table('users')
			->where('id', '=', $id)
			->update(
				array(	'first_name' 	=> $first_name,
			    		'last_name' 	=> $last_name,
			    		'gender' 		=> $gender,
			    		'country_code' 	=> $country,
			    		'email' 		=> $email,
				    )
		);

		return array('Affected rows' => $affectedRows);
	}


	public function deleteUser($user_id){
		// delete the user's transactions.
		$user = DB::table('transactions')
			->where('user_id', '=', $user_id)
			->delete();

		// delete the user.
		$user = DB::table('users')
			->where('id', '=', $user_id)
			->delete();

		return array('Deleted user' => $user_id);
	}


	public function addTransaction($user_id, $type, $value){

		$cash_value = 0;
		$bonus_value = 0;
		$bonus_parameter = 0;
		$deposit_no = 0;
		$withdrawal_no = 0;

		// check if the user exists.
		$user = DB::table('users')
			->select('id', 'cash_value', 'bonus_value', 'bonus_parameter', 'no_deposits', 'no_withdrawals')
			->where('id', '=', $user_id)
			->get();


		if(empty($user[0]->id)){
			return array('error' => 'User does not exist.');
		}else{
			$cash_value = $user[0]->cash_value;
			$bonus_value = $user[0]->bonus_value;
			$bonus_parameter = $user[0]->bonus_parameter;
			$deposit_no = $user[0]->no_deposits;
			$withdrawal_no = $user[0]->no_withdrawals;
		}

		// If it is a withdrawal then check cash available.
		if($type == 'withdraw'){
			if($cash_value - $value < 0){
				return array('error' => 'Not enough cash funds.');
			}
			// Everything OK. Negate the value.
			$value = -1 * $value;
		}


		// this transaction will be rolled back if any one statement fails.
		$transaction_id = DB::transaction(function() use ($user_id, $type, $value, $cash_value, $bonus_value, $bonus_parameter, $deposit_no, $withdrawal_no){

			// add the transaction record.
			$transaction_id = DB::table('transactions')->insertGetId(
				array(	'user_id' 	=> $user_id,
						'type' 		=> $type,
						'value' 	=> $value,
					)
			);

			$bonus = 0;
			// add a bonus transaction record if this is a deposit and the deposit number is a factor of three.
			$rem = $deposit_no % 3;
			if($type == 'deposit' && $deposit_no % 3 == 2){
				$bonus = $value * $bonus_parameter/100;
				$transaction_id = DB::table('transactions')->insertGetId(
					array(	'user_id' 	=> $user_id,
							'type' 		=> 'bonus',
							'value' 	=> $bonus,
						)
				);
			}

			// calculate the updated values for the user
			$new_cash_value = $cash_value + $value;
			$new_bonus_value = $bonus_value + $bonus;
			$new_no_deposits = $type == 'deposit' ? ++$deposit_no : $deposit_no;
			$new_no_withdrawals = $type == 'withdraw' ? ++$withdrawal_no : $withdrawal_no;

			$affectedRows = DB::table('users')
				->where('id', '=', $user_id)
				->update(
					    array(	'cash_value' 		=> $new_cash_value,
					    		'bonus_value' 		=> $new_bonus_value,
					    		'no_deposits' 		=> $new_no_deposits,
					    		'no_withdrawals' 	=> $new_no_withdrawals
					    	)
			);

			return $transaction_id;

		});


		return array('Transaction ID' => $transaction_id);
	}


	public function getTransactions($start = null, $end = null){

		// default start date is seven days ago.
		$default = date("Y-m-d", strtotime("-1 week"));
		$today = date("Y-m-d");
		$start_date = !empty($start) ? $start : $default;
		$end_date = !empty($end) ? $end : $today;

		$sql = "SELECT 	u.country_code AS 'Country',
						COUNT(DISTINCT(u.email)) AS 'Unique Customers',
						COUNT(CASE WHEN t.type = 'deposit' THEN u.id ELSE NULL END) AS 'No. of Deposits',
						SUM(CASE WHEN t.type = 'deposit' THEN t.value ELSE 0 END) AS 'Total Deposit Amount',
						COUNT(CASE WHEN t.type = 'withdraw' THEN u.id ELSE NULL END) AS 'No. of Withdrawals',
						SUM(CASE WHEN t.type = 'withdraw' THEN t.value ELSE 0 END) AS 'Total Withdraw Amount'
				FROM Users u JOIN transactions t ON u.id = t.user_id
				WHERE (t.type = 'deposit' OR t.type = 'withdraw') AND t.created_at >= ? AND t.created_at <= ? 
				GROUP BY u.country_code";

		$params = [
			$start_date,
			$end_date
		];

		$transactions = DB::select($sql, $params);


		return $transactions;
	}



}





