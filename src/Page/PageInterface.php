<?php

namespace Milan\ManageUsers\Page;

/**
 * Interface PageInterface
 *
 * @package Milan\ManageUsers\Page
 */
interface PageInterface {

	/**
	 * Return the page title.
	 *
	 * @since 1.0.0
	 */
	public function get_page_title();

	/**
	 * Return the query parameter of page.
	 *
	 * @since 1.0.0
	 */
	public function get_query_var();

	/**
	 * Return the value of query parameter.
	 *
	 * @since 1.0.0
	 */
	public function get_query_var_val();
}
