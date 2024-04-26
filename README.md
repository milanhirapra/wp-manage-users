# WP Manage Users

## Description:
This plugin for WordPress helps control users with a special web address. When you go to this specific web address, like https://example.com/wp-developer-team/, it will show a list of users in a table.

To make this table, the plugin gets information about users from a third party REST API like https://jsonplaceholder.typicode.com/users. It reads the information there and puts it into the table on the WordPress site page.

Each row in the table has details about one user.
Some parts of the details are links.
If you click one of these links, it shows more information about that user.
To do this, the plugin asks for more details from  a third party REST API like https://jsonplaceholder.typicode.com/users/id.


## Requirements
1. PHP 5.6 +
2. WordPress 4.x or later

## Installation
1. Clone the plugin repository into the `/wp-content/plugins/` folder. 
2. Open the plugin folder and run the command `composer install`. 
3. Go to the `Plugins` menu in WordPress and turn on the plugin.

## Usage
Once you turn on this plugin, go to the web address https://example.com/wp-developer-team/. You'll see a table with a list of users.

If you click on any user's row or column, it will get more information about that user and show it in a pop-up window.


## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details


