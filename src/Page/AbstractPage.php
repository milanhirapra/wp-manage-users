<?php

namespace Milan\ManageUsers\Page;

/**
 * Class AbstractPage
 *
 * @package Milan\ManageUsers\Page
 */
abstract class AbstractPage {

	/**
	 * Return the page title.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_page_title() {
		return esc_html__( 'WP User Management', 'wp-manage-users' );
	}

	/**
	 * Return the query parameter of page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_query_var() {
		return sanitize_title_with_dashes( $this->get_page_title() );
	}

	/**
	 * Return the value of query parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_query_var_val() {
		return 1;
	}
}
