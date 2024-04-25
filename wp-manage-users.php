<?php
/**
 * Plugin Name:  WP Manage Users
 * Plugin URI:   https://github.com/milanhirapra/wp-manage-users
 * Description:  WP Manage Users enhances WordPress by introducing custom endpoints that allow users to view lists and details of users.
 * Author:       Milan Hirapra
 * Author URI:   https://github.com/milanhirapra
 * Version:      1.0.0
 * Text Domain:  wp-manage-users
 * Domain Path:  /languages
 * Tested up to: 6.5.2
 * Requires PHP: 5.6 or later
 * License:      GPLv2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

use Milan\ManageUsers\Page;

defined( 'ABSPATH' ) || die( 'No direct access!' );

register_activation_hook( __FILE__, 'wp_manage_users_activate' );
register_deactivation_hook( __FILE__, 'wp_manage_users_deactivate' );

/**
 * Fire after the plugin activation.
 *
 * @since 1.0.0
 */
function wp_manage_users_activate() {
	$required_php_version = '5.6.0';

	wp_manage_users_textdomain();

	if ( ! version_compare( PHP_VERSION, $required_php_version, '>=' ) ) {

		// De-activate the plugin when the requirement doesn't specify.
		deactivate_plugins( basename( __FILE__ ) );

		// Throw notice.
		wp_die(
			sprintf(
				'<p>%1$s</p><a href="%2$s">%3$s</a>',
				sprintf(
					esc_html__( 'Your site is currently running PHP version %1$s, while this plugin requires version %2$s or greater.', 'wp-manage-users' ),
					PHP_VERSION,
					$required_php_version
				),
				admin_url( 'plugins.php' ),
				esc_attr__( 'Back to Plugin', 'wp-manage-users' )
			)
		);
	}

	/**
	 * Fires during the activation.
	 *
	 * @since 1.0.0
	 */
	do_action( 'wp_manage_users_activation' );
}

/**
 * Fire after the plugin deactivation.
 *
 * @since 1.0.0
 */
function wp_manage_users_deactivate() {
	/**
	 * Fires during the deactivation.
	 *
	 * @since 1.0.0
	 */
	do_action( 'wp_manage_users_deactivation' );

	// Flush rewrite rules after deactivate the plugin.
	flush_rewrite_rules();
}

/**
 * Load the plugin.
 *
 * @since 1.0.0
 */
function wp_manage_users_load() {

	if ( ! defined( 'WP_MANAGE_USERS_PLUGIN_DIR' ) ) {
		define( 'WP_MANAGE_USERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( ! defined( 'WP_MANAGE_USERS_PLUGIN_URL' ) ) {
		define( 'WP_MANAGE_USERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	$file = __DIR__ . '/vendor/autoload.php';
	if ( file_exists( $file ) ) {

		// Load the plugin translations.
		wp_manage_users_textdomain();

		// Load plugin files and classes.
		include_once $file;

		// Register the custom endpoints.
		$page_manager = new Page\Manager();
		$page_manager->add_page( new Page\UserPage() );
		$page_manager->init_pages();
	}
}

add_action( 'plugins_loaded', 'wp_manage_users_load' );

/**
 * Load the plugin translations.
 */
function wp_manage_users_textdomain() {

	load_plugin_textdomain(
		'wp-manage-users',
		false,
		plugin_basename( __DIR__ ) . '/languages/'
	);
}