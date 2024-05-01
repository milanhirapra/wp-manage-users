<?php # -*- coding: utf-8 -*-
namespace Milan\ManageUsers;

// define test environment
define( 'PLUGIN_PHPUNIT', true );

// define fake ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() );
}

// define fake PLUGIN_ABSPATH
if ( ! defined( 'PLUGIN_ABSPATH' ) ) {
	define( 'PLUGIN_ABSPATH', sys_get_temp_dir() . '/wp-content/plugins/wp-manage-users/' );
}

require_once dirname( __DIR__ ) . '/vendor/autoload.php';
