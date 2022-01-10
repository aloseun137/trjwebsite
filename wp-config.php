<?php


//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
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
define( 'DB_NAME', 'trjcompany' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'r2,BhENjwO^A3s{;am?m25hNJB:UWO=Ojz2VY`^9aLb qwI;PVj pLFE]SJ[V(B&' );
define( 'SECURE_AUTH_KEY',  '3^*+,c_C|#FRL/%bL=U7l<bfhi1Trb.:]f#nji$k$H1DL(L,Gz:WyTj]y%~9ZA@9' );
define( 'LOGGED_IN_KEY',    '396J{c(`*]>$!a5;w]sC/HQOd2@x&`uYvQ<8%p`PW^[R4x*0HiqU@%%yd1pK!3R7' );
define( 'NONCE_KEY',        '5$j*A&leN(&),ni{9rD7T$2e gwuS_$+7x)Gr}==)26me[|Us-%]pEYvp)8_[$h.' );
define( 'AUTH_SALT',        '(,()LJ9:I<fV$x Z(?H#~4Tm|?!(O|PsA{}^iH5hw? l#Krbx7@IF?qRG$.>H>/I' );
define( 'SECURE_AUTH_SALT', '1-0Ep-6?^rUn7O5I6ET/rm$A/d0XC?a+|t]}zN]1A;GXL3&B nW>>fCLq$?C<tVQ' );
define( 'LOGGED_IN_SALT',   'dZ;=F3`c. Q|4piRS2|)N^2hP%tk|hz1>$;M:h_AKtb$JZo.U8`A?;FYG2p>Zt?H' );
define( 'NONCE_SALT',       'csb@/`_m1<cgh)(Y]^l-B5tudMdTYfajV@K eY}& :6j-&~E9ganr.U$La<,B`Y9' );

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
