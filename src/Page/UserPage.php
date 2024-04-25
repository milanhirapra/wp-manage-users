<?php

namespace Milan\ManageUsers\Page;

use Milan\ManageUsers\Collections;

/**
 * Class UserPage.
 *
 * @since   1.0.0
 * @package Milan\ManageUsers\Page
 */
class UserPage extends AbstractPage implements PageInterface {

	/**
	 * API collection object.
	 *
	 * @since 1.0.0
	 *
	 * @var Collections\UserApi
	 */
	private $api;

	/**
	 * UserPage constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Register ajax actions to retrieve the user data.
		add_action( 'wp_ajax_wpmu_user_details', array( $this, 'get_user_details' ) );
		add_action( 'wp_ajax_nopriv_wpmu_user_details', array( $this, 'get_user_details' ) );

		add_filter( 'wp_manage_users_localize_data', array( $this, 'add_localize_data' ) );
		add_action( 'wp_footer', array( $this, 'enqueue_js_templates' ) );
	}

	/**
	 * Return the page title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_page_title() {
		return esc_html__( 'User Management', 'wp-manage-users' );
	}

	/**
	 * Return the query parameter of page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_query_var() {
		return 'wp-developer-team';
	}

	/**
	 * Return the value of query parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_query_var_val() {
		return 'users';
	}

	/**
	 * Return the page template.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_template() {
		return trailingslashit( constant( 'WP_MANAGE_USERS_PLUGIN_DIR' ) ) . 'templates/user.php';
	}

	/**
	 * Return the query var with new query parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_query_vars( $query_vars ) {

		// Register custom endpoint.
		$query_vars[] = $this->get_query_var();

		return $query_vars;
	}

	/**
	 * Return the page template based on query parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function add_page_template( $template ) {

		if (
			false === get_query_var( $this->get_query_var() ) ||
			empty( get_query_var( $this->get_query_var() ) ) ||
			$this->get_query_var_val() !== get_query_var( $this->get_query_var() )
		) {
			return $template;
		}

		return $this->get_template();
	}

	/**
	 * Add localise variable.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function add_localize_data( $data ) {
		$data['user'] = array(
			'page_title' => $this->get_page_title(),
			'nonce'      => wp_create_nonce( 'wpmu_user' ),
			'error'      => __( 'Unable to fetch user details. Please try again.', 'wp-manage-users' ),
		);

		return $data;
	}

	/**
	 * Load the text HTML template to footer.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_js_templates() {
		$template_parts = apply_filters(
			'wp_manage_users_js_template_parts',
			array(
				WP_MANAGE_USERS_PLUGIN_DIR . 'templates/parts/details.php',
			)
		);

		foreach ( $template_parts as $template_part ) {
			load_template( $template_part );
		}
	}

	/**
	 * Get the user list from the API and render the user list.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render_user_list() {
		$this->api = new Collections\UserApi();
		$this->api->get_user_list();
		$this->get_list();
		$this->get_notice();
	}

	/**
	 * Display the list of user.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function get_list() {
		if ( ! empty( $this->api->user_list ) ) {
			foreach ( $this->api->user_list as $user ) {
				?>
				<tr>
					<td>
						<a href="#" data-user-id="<?php echo esc_attr( $user->id ); ?>">
							<?php echo esc_html( $user->id ); ?>
						</a>
					</td>
					<td>
						<a href="#" data-user-id="<?php echo esc_attr( $user->id ); ?>">
							<?php echo esc_html( $user->name ); ?>
						</a>
					</td>
					<td>
						<a href="#" data-user-id="<?php echo esc_attr( $user->id ); ?>">
							<?php echo esc_html( $user->username ); ?>
						</a>
					</td>
					<td>
						<a href="#" data-user-id="<?php echo esc_attr( $user->id ); ?>">
							<?php echo esc_html( $user->email ); ?>
						</a>
					</td>
				</tr>
				<?php
			}
		} else {
			?>
			<tr>
				<td colspan="4"><?php echo esc_html__( 'No users were found.', 'wp-manage-users' ); ?></td>
			</tr>
			<?php
		}
	}

	/**
	 * Display the error.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function get_notice() {

		if ( ! empty( $this->api->is_error() ) ) {
			?>
			<tr>
				<td colspan="4"><?php echo esc_html( $this->api->get_error_message() ); ?></td>
			</tr>
			<?php
		}
	}

	/**
	 * Retrieve the user details.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_user_details() {

		// Validate the user ID.
		$user_id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );
		if ( empty( $user_id ) ) {
			wp_send_json_error( __( 'The user ID is required.', 'wp-manage-users' ) );
		}

		// Validate nonce.
		$nonce = filter_input( INPUT_POST, '__nonce' );
		if ( ! wp_verify_nonce( $nonce, 'wpmu_user' ) ) {
			wp_send_json_error( __( 'Unable to fetch user details, please refresh and try again.', 'wp-manage-users' ) );
		}

		// Fetch the user details.
		$this->api = new Collections\UserApi();
		$this->api->get_user_details( $user_id );
		$is_error = $this->api->is_error();

		// Send error when found the error.
		if ( ! empty( $is_error ) ) {
			wp_send_json_error( esc_html( $is_error->get_error_message() ) );
		}

		// Send success response.
		wp_send_json_success( $this->api->user_details );
	}
}
