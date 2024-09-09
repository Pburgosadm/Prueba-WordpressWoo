<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define( 'ITSEC_ENCRYPTION_KEY', 'QWp2d21eeWMjWiRFe3oqSUl8Ky9vUFU5KXw8IC5CSD1edU1MamhafjFWfns+OXtnUj1NZStDIHhiJj13dV5CTg==' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'PruebaWordpressWoo' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'AKjyCcJnMoTs0BlUdQHay2Js0Nmbec4OxYXNc5HQtMNmlCdSxMe5pJLnUq2mE7Lt' );
define( 'SECURE_AUTH_KEY',  'Slz4z1iAw2KFVbzL6XQ5AwfIKEvHwpr0RVGDpASwKd9QDzX5aCODBU0ghPytUjjy' );
define( 'LOGGED_IN_KEY',    'YXL08WOyVJfi6toRfCFKKNdQmGYK6qPaIYbngtTt1wkTpVqx0mvklVp3bDnQ4cxR' );
define( 'NONCE_KEY',        'qIJ14ZBOVE5tI0MQnLAvvFGnNd20EEy97mVNsG3KhKgeLHyktrkg7WeHMd1UK215' );
define( 'AUTH_SALT',        'NN2IcJHFPg7tNpIyB6nvYNXcUuvoiuXFFLgbR2NMygaqhVUSUPRf4dGESUoo4pI3' );
define( 'SECURE_AUTH_SALT', 'L7Rw06QM2k2JSOBaY9ZIxzATQYR84GFLRRXR893fO8hcoeTS0bX39MaZN1JBsooP' );
define( 'LOGGED_IN_SALT',   '4H726Tp1KYSVEpP2Qe9Cz670rP1DlT48bOGHkFdV5zCGFbD5M2xBlYyT0phIIBWU' );
define( 'NONCE_SALT',       'K6Osd8WXb0PSrQ6YzDtkvWgxdsiFwK8US64fHoUanEIBm5KOATykpSTnIrR7Tdva' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
