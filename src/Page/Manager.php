<?php

namespace Milan\ManageUsers\Page;

/**
 * Class Manager.
 *
 * @since   1.0.0
 * @package Milan\ManageUsers\Page
 */
class Manager {

	/**
	 * Collection of interfaces.
	 *
	 * @since 1.0.0
	 *
	 * @var PageInterface[]
	 */
	private $pages = [];

	/**
	 * Add interfaces to the variable.
	 *
	 * @since 1.0.0
	 *
	 * @param PageInterface $page Interface of the page.
	 *
	 * @return void
	 */
	public function add_page( PageInterface $page ) {
		$this->pages[ $page->get_query_var() ] = $page;
	}

	/**
	 * Add actions to register new rules for pages and enqueue.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_pages() {

		// Register new rewrite rules.
		add_action( 'init', array( $this, 'register_rewrite_rules' ) );

		// Enqueue the css and js files.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css_js' ) );
	}

	/**
	 * Register new rewrite rules.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_rewrite_rules() {

		foreach ( $this->pages as $query_var => $page ) {

			// Register custom endpoint.
			add_rewrite_rule( "{$query_var}/?$", "index.php?{$query_var}={$page->get_query_var_val()}", 'top' );

			// Add endpoints to query vars.
			add_filter( 'query_vars', array( $page, 'add_query_vars' ) );

			// Load template for custom endpoints.
			add_filter( 'template_include', array( $page, 'add_page_template' ) );
		}

		// Flush rewrite rules after adding new rules.
		flush_rewrite_rules();
	}

	/**
	 * Enqueue the css and js files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_css_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Enqueue CSS files.
		wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap' . $suffix . '.css', array(), '5.3.3' );
		wp_enqueue_style( 'wp-manage-users-styles', WP_MANAGE_USERS_PLUGIN_URL . 'assets/css/wp-manage-users' . $suffix . '.css', array(), '1.0.0' );

		// Enqueue JS file.
		wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle' . $suffix . '.js', array( 'jquery' ), '5.3.3', true );
		wp_enqueue_script( 'wp-manage-users-js', WP_MANAGE_USERS_PLUGIN_URL . 'assets/js/wp-manage-users' . $suffix . '.js', array( 'jquery', 'wp-util' ), '1.0.0', true );

		// Localize the variable to use in JS files.
		wp_localize_script(
			'wp-manage-users-js',
			'ManageUsers',
			apply_filters(
				'wp_manage_users_localize_data',
				array(
					'admin_url' => admin_url( 'admin-ajax.php' ),
				)
			)
		);

		/**
		 * Fires after enqueue the css and js files.
		 *
		 * @since 1.0.0
		 */
		do_action( 'wp_manage_users_enqueue_scripts' );
	}
}
