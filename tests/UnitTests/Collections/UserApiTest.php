<?php

use Milan\ManageUsers\Collections\UserApi;
use Milan\ManageUsers\Tests\AbstractTestCase;
use Brain\Monkey\Functions;

/**
 * Class UserApiTest
 * Test Class for UserApi
 */
class UserApiTest extends AbstractTestCase {

	/**
	 * Validate the response data to retrieve from the API.
	 */
	public function test_get_user_list() {

		$response = [
			'response' => [
				'code'    => 200,
				'message' => 'OK',
				'body'    => json_encode( $this->get_result_array() ),
			],
		];

		Functions\expect( 'wp_cache_add_global_groups' )->once()->andReturn( true );
		Functions\expect( 'wp_cache_get' )->once()->andReturn( false );
		Functions\expect( 'wp_cache_set' )->once()->andReturn( true );
		Functions\expect( 'wp_remote_get' )
			->once()
			->andReturn( $response );

		Functions\expect( 'wp_remote_retrieve_response_code' )->once()->andReturn( 200 );
		Functions\expect( 'wp_remote_retrieve_body' )->once()->andReturn( $response['response']['body'] );

		$user_api = new UserApi();
		$user_api->get_user_list();
		$result = $user_api->user_list;

		$this->assertEquals( 200, $response['response']['code'] );
		$this->assertEquals( 'OK', $response['response']['message'] );
		$this->assertContains( 'Graham', $result[0]->name );
	}

	/**
	 * Validate the response error to retrieve from the API.
	 */
	public function test_get_user_list_error() {

		$response = [
			'response' => [
				'code'    => 500,
				'message' => 'Internal Server Error',
				'body'    => '',
			],
		];

		Functions\expect( 'wp_cache_add_global_groups' )->once()->andReturn( true );
		Functions\expect( 'wp_cache_get' )->once()->andReturn( false );
		Functions\expect( 'wp_remote_get' )
			->once()
			->andReturn( $response );

		Functions\expect( 'wp_remote_retrieve_response_code' )->once()->andReturn( 500 );

		$user_api = new UserApi();
		$user_api->get_user_list();

		$this->assertEquals( 500, $response['response']['code'] );
		$this->assertEquals( 'Internal Server Error', $response['response']['message'] );
	}

	/**
	 * Validate the response data to retrieve from the API.
	 */
	public function test_get_user_details() {

		$response = [
			'response' => [
				'code'    => 200,
				'message' => 'OK',
				'body'    => json_encode( current( $this->get_result_array() ) ),
			],
		];

		Functions\expect( 'wp_cache_add_global_groups' )->once()->andReturn( true );
		Functions\expect( 'wp_cache_get' )->once()->andReturn( false );
		Functions\expect( 'wp_cache_set' )->once()->andReturn( true );
		Functions\expect( 'wp_remote_get' )
			->once()
			->andReturn( $response );

		Functions\expect( 'wp_remote_retrieve_response_code' )->once()->andReturn( 200 );
		Functions\expect( 'wp_remote_retrieve_body' )->once()->andReturn( $response['response']['body'] );

		$user_id  = 1;
		$user_api = new UserApi();
		$user_api->get_user_details( $user_id );
		$result = $user_api->user_details;

		$this->assertEquals( 200, $response['response']['code'] );
		$this->assertEquals( 'OK', $response['response']['message'] );
		$this->assertEquals( $user_id, $result->id );
		$this->assertContains( 'Graham', $result->name );
	}

	/**
	 * Validate the response error to retrieve from the API.
	 */
	public function test_get_user_details_error() {

		$response = [
			'response' => [
				'code'    => 500,
				'message' => 'Internal Server Error',
				'body'    => '',
			],
		];

		Functions\expect( 'wp_cache_add_global_groups' )->once()->andReturn( true );
		Functions\expect( 'wp_cache_get' )->once()->andReturn( false );
		Functions\expect( 'wp_remote_get' )
			->once()
			->andReturn( $response );

		Functions\expect( 'wp_remote_retrieve_response_code' )->once()->andReturn( 500 );

		$user_id  = 1;
		$user_api = new UserApi();
		$user_api->get_user_details( $user_id );

		$this->assertEquals( 500, $response['response']['code'] );
		$this->assertEquals( 'Internal Server Error', $response['response']['message'] );
	}

	/**
	 * Prepare the response data.
	 */
	public function get_result_array() {
		return array(
			0 =>
				array(
					'id'       => 1,
					'name'     => 'Leanne Graham',
					'username' => 'Bret',
					'email'    => 'Sincere@april.biz',
					'address'  =>
						array(
							'street'  => 'Kulas Light',
							'suite'   => 'Apt. 556',
							'city'    => 'Gwenborough',
							'zipcode' => '92998-3874',
							'geo'     =>
								array(
									'lat' => - 37.3159,
									'lng' => 81.1496,
								),
						),
					'phone'    => '1-770-736-8031 x56442',
					'website'  => 'hildegard.org',
					'company'  =>
						array(
							'name'        => 'Romaguera-Crona',
							'catchPhrase' => 'Multi-layered client-server neural-net',
							'bs'          => 'harness real-time e-markets',
						),
				),
			1 =>
				array(
					'id'       => 2,
					'name'     => 'Ervin Howell',
					'username' => 'Antonette',
					'email'    => 'Shanna@melissa.tv',
					'address'  =>
						array(
							'street'  => 'Victor Plains',
							'suite'   => 'Suite 879',
							'city'    => 'Wisokyburgh',
							'zipcode' => '90566-7771',
							'geo'     =>
								array(
									'lat' => - 43.9509,
									'lng' => - 34.4618,
								),
						),
					'phone'    => '010-692-6593 x09125',
					'website'  => 'anastasia.net',
					'company'  =>
						array(
							'name'        => 'Deckow-Crist',
							'catchPhrase' => 'Proactive didactic contingency',
							'bs'          => 'synergize scalable supply-chains',
						),
				),
			2 =>
				array(
					'id'       => 3,
					'name'     => 'Clementine Bauch',
					'username' => 'Samantha',
					'email'    => 'Nathan@yesenia.net',
					'address'  =>
						array(
							'street'  => 'Douglas Extension',
							'suite'   => 'Suite 847',
							'city'    => 'McKenziehaven',
							'zipcode' => '59590-4157',
							'geo'     =>
								array(
									'lat' => - 68.6102,
									'lng' => - 47.0653,
								),
						),
					'phone'    => '1-463-123-4447',
					'website'  => 'ramiro.info',
					'company'  =>
						array(
							'name'        => 'Romaguera-Jacobson',
							'catchPhrase' => 'Face to face bifurcated interface',
							'bs'          => 'e-enable strategic applications',
						),
				),
			3 =>
				array(
					'id'       => 4,
					'name'     => 'Patricia Lebsack',
					'username' => 'Karianne',
					'email'    => 'Julianne.OConner@kory.org',
					'address'  =>
						array(
							'street'  => 'Hoeger Mall',
							'suite'   => 'Apt. 692',
							'city'    => 'South Elvis',
							'zipcode' => '53919-4257',
							'geo'     =>
								array(
									'lat' => 29.4572,
									'lng' => '-164.2990',
								),
						),
					'phone'    => '493-170-9623 x156',
					'website'  => 'kale.biz',
					'company'  =>
						array(
							'name'        => 'Robel-Corkery',
							'catchPhrase' => 'Multi-tiered zero tolerance productivity',
							'bs'          => 'transition cutting-edge web services',
						),
				),
			4 =>
				array(
					'id'       => 5,
					'name'     => 'Chelsey Dietrich',
					'username' => 'Kamren',
					'email'    => 'Lucio_Hettinger@annie.ca',
					'address'  =>
						array(
							'street'  => 'Skiles Walks',
							'suite'   => 'Suite 351',
							'city'    => 'Roscoeview',
							'zipcode' => 33263,
							'geo'     =>
								array(
									'lat' => - 31.8129,
									'lng' => 62.5342,
								),
						),
					'phone'    => '(254)954-1289',
					'website'  => 'demarco.info',
					'company'  =>
						array(
							'name'        => 'Keebler LLC',
							'catchPhrase' => 'User-centric fault-tolerant solution',
							'bs'          => 'revolutionize end-to-end systems',
						),
				),
			5 =>
				array(
					'id'       => 6,
					'name'     => 'Mrs. Dennis Schulist',
					'username' => 'Leopoldo_Corkery',
					'email'    => 'Karley_Dach@jasper.info',
					'address'  =>
						array(
							'street'  => 'Norberto Crossing',
							'suite'   => 'Apt. 950',
							'city'    => 'South Christy',
							'zipcode' => '23505-1337',
							'geo'     =>
								array(
									'lat' => - 71.4197,
									'lng' => 71.7478,
								),
						),
					'phone'    => '1-477-935-8478 x6430',
					'website'  => 'ola.org',
					'company'  =>
						array(
							'name'        => 'Considine-Lockman',
							'catchPhrase' => 'Synchronised bottom-line interface',
							'bs'          => 'e-enable innovative applications',
						),
				),
			6 =>
				array(
					'id'       => 7,
					'name'     => 'Kurtis Weissnat',
					'username' => 'Elwyn.Skiles',
					'email'    => 'Telly.Hoeger@billy.biz',
					'address'  =>
						array(
							'street'  => 'Rex Trail',
							'suite'   => 'Suite 280',
							'city'    => 'Howemouth',
							'zipcode' => '58804-1099',
							'geo'     =>
								array(
									'lat' => 24.8918,
									'lng' => 21.8984,
								),
						),
					'phone'    => '210.067.6132',
					'website'  => 'elvis.io',
					'company'  =>
						array(
							'name'        => 'Johns Group',
							'catchPhrase' => 'Configurable multimedia task-force',
							'bs'          => 'generate enterprise e-tailers',
						),
				),
			7 =>
				array(
					'id'       => 8,
					'name'     => 'Nicholas Runolfsdottir V',
					'username' => 'Maxime_Nienow',
					'email'    => 'Sherwood@rosamond.me',
					'address'  =>
						array(
							'street'  => 'Ellsworth Summit',
							'suite'   => 'Suite 729',
							'city'    => 'Aliyaview',
							'zipcode' => 45169,
							'geo'     =>
								array(
									'lat' => '-14.3990',
									'lng' => - 120.7677,
								),
						),
					'phone'    => '586.493.6943 x140',
					'website'  => 'jacynthe.com',
					'company'  =>
						array(
							'name'        => 'Abernathy Group',
							'catchPhrase' => 'Implemented secondary concept',
							'bs'          => 'e-enable extensible e-tailers',
						),
				),
			8 =>
				array(
					'id'       => 9,
					'name'     => 'Glenna Reichert',
					'username' => 'Delphine',
					'email'    => 'Chaim_McDermott@dana.io',
					'address'  =>
						array(
							'street'  => 'Dayna Park',
							'suite'   => 'Suite 449',
							'city'    => 'Bartholomebury',
							'zipcode' => '76495-3109',
							'geo'     =>
								array(
									'lat' => 24.6463,
									'lng' => - 168.8889,
								),
						),
					'phone'    => '(775)976-6794 x41206',
					'website'  => 'conrad.com',
					'company'  =>
						array(
							'name'        => 'Yost and Sons',
							'catchPhrase' => 'Switchable contextually-based project',
							'bs'          => 'aggregate real-time technologies',
						),
				),
			9 =>
				array(
					'id'       => 10,
					'name'     => 'Clementina DuBuque',
					'username' => 'Moriah.Stanton',
					'email'    => 'Rey.Padberg@karina.biz',
					'address'  =>
						array(
							'street'  => 'Kattie Turnpike',
							'suite'   => 'Suite 198',
							'city'    => 'Lebsackbury',
							'zipcode' => '31428-2261',
							'geo'     =>
								array(
									'lat' => - 38.2386,
									'lng' => 57.2232,
								),
						),
					'phone'    => '024-648-3804',
					'website'  => 'ambrose.net',
					'company'  =>
						array(
							'name'        => 'Hoeger LLC',
							'catchPhrase' => 'Centralized empowering task-force',
							'bs'          => 'target end-to-end models',
						),
				),
		);
	}

}
