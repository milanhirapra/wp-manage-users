<?php

namespace Milan\ManageUsers\Collections;

/**
 * Class AbstractApis.
 *
 * @since   1.0.0
 * @package Milan\ManageUsers\Collections
 */
abstract class AbstractApis {

	/**
	 * The Rest API URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	private $api_url = 'https://jsonplaceholder.typicode.com';

	/**
	 * The endpoint to retrieve the data.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $endpoint = '';

	/**
	 * Store the data to retrieve from the Rest API.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private $data = array();

	/**
	 * Store the WP_Error.
	 *
	 * @since 1.0.0
	 *
	 * @var \WP_Error
	 */
	private $error;

	/**
	 * Send a request to retrieve the data.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function send() {

		if ( ! empty( $this->endpoint ) ) {

			// Make the HTTP GET request to the API endpoint.
			$response = wp_remote_get( $this->api_url . $this->endpoint );

			// Check if the request was successful.
			if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
				// Parse the response body as JSON.
				$data       = wp_remote_retrieve_body( $response );
				$this->data = json_decode( $data );
			} else {
				$this->error = $response;
			}

		} else {
			$this->error = new \WP_Error( 'http_request_failed', __( 'The endpoint is required.', 'wp-manage-users' ) );
		}
	}

	/**
	 * Return the data to retrieve from the Rest API.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	protected function get_data() {
		return $this->data;
	}

	/**
	 * Return the WP_Error.
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error Return the WP_Error.
	 */
	protected function get_error() {
		return $this->error;
	}
}
