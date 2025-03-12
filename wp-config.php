<?php
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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'linkora' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         ':!Y?fJs1y>/Cw}C{OM&pw`*raYgs))=;X38P4mglNRG<bRk3.=Gzw3ID%N!]$0`T' );
define( 'SECURE_AUTH_KEY',  '{R5>|WfK@mqYU?K<tOL$M(]<A4agHKf*nVT?KXW/*3;Gy/v>U:Tq~6KSq^BHllQW' );
define( 'LOGGED_IN_KEY',    'gI5,Unh6}# Y%B:))5u@gYvQRh%MjE.XkOP:oR7y|}[Y~+&<5Xiw*3(]DJ `w7=f' );
define( 'NONCE_KEY',        'Z=/R;~>?}eaOz[w_~)6s=K(1d!KhX),c8_G%yeK`a375R?dA>zYh~bc5?P;W~?54' );
define( 'AUTH_SALT',        'm+a`qJXF/?Q[9gTyM3V#i@eq&`];$SNb :;fgsl+A)r=I}>pzNTIJX<V7L2.C5x.' );
define( 'SECURE_AUTH_SALT', ').-x?Q?*>P|H<m~D>FO/ (V,fYak1(WD;?]^6Y54K`G[@)gk>FJtJme.L3a&__~k' );
define( 'LOGGED_IN_SALT',   'Snr/LxkeY3JWV_t29Z,SX|g?84BU4{5A+wYJV!G._G}~>UjwQj}Gvg`Y^>`&nQFD' );
define( 'NONCE_SALT',       'fyFUzDwHq$02v@f0.e*H3EtZ:m0a%Yq!Z)xC>=9y4U-.W=93qd+;^%Jf| )X{s{!' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
