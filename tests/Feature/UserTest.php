<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	protected static $new_user_id;


    /**
     * Test the add-user endpoint for 200 OK.
     *
     * @return void
     */
    public function testAddUserEndpointTest()
    {
        $email = str_random(20) . '@test.com';

        $response = $this->json('POST', 'add-user', array(
            "first_name" => "testing",
            "last_name" => "test",
            "gender" => "M",
            "country" => "TT",
            "email" => $email,
        ));


		$user_id = $response->decodeResponseJson();
		self::$new_user_id = $user_id['User ID'];

		echo self::$new_user_id;

        $response->assertStatus(200);
    }

    /**
     * Test the update-user endpoint for 200 OK.
     *
     * @return void
     */
    public function testUpdateUserEndpointTest()
    {
        $email = str_random(10) . '@test.com';

        echo "update user = " . self::$new_user_id;

        $response = $this->json('POST', 'update-user', array(
            "id" => self::$new_user_id,
            "first_name" => "testing",
            "last_name" => "test",
            "gender" => "M",
            "country" => "TT",
            "email" => $email,
        ));

        $response->assertStatus(200);
    }

    /**
     * Test the deposit endpoint for 200 OK.
     *
     * @return void
     */
    public function testDepositEndpointTest()
    {
        $response = $this->json('POST', 'deposit', array(
            "user_id" => self::$new_user_id,
            "amount" => 123.45,
        ));

        $response->assertStatus(200);
    }

    /**
     * Test the withdraw endpoint for 200 OK.
     *
     * @return void
     */
    public function testWithdrawEndpointTest()
    {
        $response = $this->json('POST', 'withdraw', array(
            "user_id" => self::$new_user_id,
            "amount" => 123.45,
        ));

        $response->assertStatus(200);
    }

	/**
     * Test the delete-user endpoint for 200 OK.
     *
     * @return void
     */
    public function testDeleteUserEndpointTest()
    {
        $response = $this->json('POST', 'delete-user', array(
            "user_id" => self::$new_user_id,
        ));

        $response->assertStatus(200);
    }

    /**
     * Test the report endpoint for 200 OK.
     *
     * @return void
     */
    public function testReportEndpointTest()
    {
        $response = $this->json('POST', 'report');

        $response->assertStatus(200);
    }
}
