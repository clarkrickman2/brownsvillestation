<?php

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

//Begin Really Simple SSL Load balancing fix
if ((isset($_ENV["HTTPS"]) && ("on" == $_ENV["HTTPS"]))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))
|| (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))
|| (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))
) {
$_SERVER["HTTPS"] = "on";
}
//END Really Simple SSL
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'brownsville' );
/** MySQL database username */
define( 'DB_USER', 'admin' );
/** MySQL database password */
define( 'DB_PASSWORD', '3Catfish3' );
/** MySQL hostname */
define( 'DB_HOST', 'clizoud.czcekk3nt7cq.us-east-1.rds.amazonaws.com' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '2 {^)T@YtkDwqBcK9~O-c[Sp1S2Aif]&VIWl4^g*RloX<+%X{DMB21dXMy4V}Ra+' );
define( 'SECURE_AUTH_KEY',  'W6J;Tu-8{]L#![Dqi-06<Ly$wh x`bIRx(r)%RP=GEwE2Cx#Yvu?yO`TKL#VNeV>' );
define( 'LOGGED_IN_KEY',    'I5~r2j28yaSiKKw|EH4$|PrlGbYf*A]M DqKgF ,3/cr lOvF7qMy|EPFfMQlPRf' );
define( 'NONCE_KEY',        'j!;WpR8le8(3G@7V^`vAM@}tmg@8]q,sk6#vEJS8][HhrIQ=HXv*N-X XarFZk41' );
define( 'AUTH_SALT',        '5<Rz*.~Q9&s$ib})L$$[J[rCYP^Wh,Vt>XvB}:(Lrx|v7,5j}`-fPyo;c1)+9M`|' );
define( 'SECURE_AUTH_SALT', 'A[K9M]7BGeLUWpOx5&9^zua?*ZX,-z+*%cG%wy+M=9flCKm^xyoh7QZ+>3.NJX:o' );
define( 'LOGGED_IN_SALT',   '/:]CIR=~S|G/QW)wjHD#dV4n[]sh!&O3PXzktcsPzO-4V7.LfI3p-#0:C~H4,AqH' );
define( 'NONCE_SALT',       '3!dx@wv?xH(]wJqU)&%`-1zNV/M75QLI|wTF#[tMr}_pf+|a6{wq4})`_~oG7!,_' );
/**#@-*/
/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}


if(!defined('WP_MEMORY_LIMIT')){
    define('WP_MEMORY_LIMIT','256M');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD','direct');

