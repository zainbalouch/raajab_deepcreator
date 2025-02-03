<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// define( 'DB_NAME', 'u117044314_MEIVv' );

// /** Database username */
// define( 'DB_USER', 'u117044314_FiaPq' );

// /** Database password */
// define( 'DB_PASSWORD', 'oHHYlN5wjq' );

define( 'DB_NAME', 'raajab_deepcreator' );

/** Database username */
define( 'DB_USER', 'zain' );

/** Database password */
define( 'DB_PASSWORD', 'root' );


/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'G9BXctzFfdI<@Ae+_lwDFk{pCah6a</@63;0mbPc}~D,|?f3+M}-Qi5xT_)n,}]X' );
define( 'SECURE_AUTH_KEY',   'LRD.@;E VfHk[yWUK(g,%sM$ln!G,A@x;*C=vRPwptSh*Is@+4K`6*80B-f-u99;' );
define( 'LOGGED_IN_KEY',     'd}6TF2R!UgTWf<h#ZZovc_T<Xk(cxKn%SB,5g14(3BfIkv%aB9%82I!Y%$!h#dXY' );
define( 'NONCE_KEY',         '2GvP+RaY54}Z(I]he5okhmh/4Av<fOU/M=`^s:WuaNk94Q*W[)d_%H&Q(B>$Yn|N' );
define( 'AUTH_SALT',         'ye3Sb@Jxv$r8-7IzMke<EC*y|MZ.|*:jy6f>*y)51mgqG-OK7%-fwqf:1>VJpG|{' );
define( 'SECURE_AUTH_SALT',  '0q!I6,h=5-@3l1:xu<%Z8}ykz;xzAL8q0KF77 R|:{~Ommq?Z:U`1(d;)A1&fSo3' );
define( 'LOGGED_IN_SALT',    '`-fn:=,`n)cB:=:~lT#FYw~(iVCE??2Yw!Y6zh). FviE%R[7au$K3KL4dxV_HRD' );
define( 'NONCE_SALT',        '20E+|Hk vn>{[zctx7%5Wr<d9m5V3b61p5VQT:>?U66H~Ax:j<on{/(Q<UK,%AJI' );
define( 'WP_CACHE_KEY_SALT', '=o&_7i!&|dms!@$3h]X-*~1e$9.^JD}r+zy%x|9E=JM?BHzP.#<`)|wF;;5xC95/' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '6504f414ebf5ccaf070b79a969e0abcd' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
