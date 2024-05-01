<?php

namespace Milan\ManageUsers\Collections;

/**
 * Class UserApi.
 *
 * @since   1.0.0
 * @package Milan\ManageUsers\Collections
 */
class UserApi extends AbstractApis {

	/**
	 * User list object.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public $user_list;

	/**
	 * User details object.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public $user_details;

	/**
	 * Cache group key.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private $cache_group = 'wpmu_user_api';

	/**
	 * UserApi constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		wp_cache_add_global_groups( $this->cache_group );
	}

	/**
	 * Retrieve the user list from the REST API.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_user_list() {

		// Attempt to retrieve the cached data from the object cache
		$cached_data = wp_cache_get( 'wpmu_users', $this->cache_group );

		if ( $cached_data !== false ) {

			// Set cached data to the variable.
			$this->user_list = $cached_data;

		} else {

			// Set endpoints to get the user list.
			$this->endpoint = '/users';

			// Send the HTTP request.
			$this->send();

			// Assign the latest data to the variable.
			$this->user_list = $this->get_data();

			// Cached the date when no error found.
			if ( empty( $this->get_error() ) ) {

				// Cached the latest data.
				wp_cache_set( 'wpmu_users', $this->user_list, $this->cache_group, 3600 ); // Expires in 1 hour.
			}

		}

	}

	/**
	 * Retrieve the user details from the REST API.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_user_details( $id = 0 ) {

		// Attempt to retrieve the cached data from the object cache
		$cached_data = wp_cache_get( $id, $this->cache_group );

		if ( $cached_data !== false ) {

			// Set cached data to the variable.
			$this->user_details = $cached_data;

		} else {

			// Set endpoints to get the user list.
			$this->endpoint = '/users/' . $id;

			// Send the HTTP request.
			$this->send();

			// Assign the latest data to the variable.
			$this->user_details = $this->get_data();

			// Cached the date when no error found.
			if ( empty( $this->get_error() ) ) {

				// Cached the latest data.
				wp_cache_set( $id, $this->user_details, $this->cache_group, 3600 ); // Expires in 1 hour.
			}

		}

	}

	/**
	 * Return the errors when getting to fetch the details.
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error Return the WP_Error.
	 */
	public function is_error() {
		return $this->get_error();
	}

	/**
	 * Return the error message.
	 *
	 * @since 1.0.0
	 *
	 * @return string.
	 */
	public function get_error_message() {
		return $this->get_error()->get_error_message();
	}
}
