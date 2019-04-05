<?php

/*define('DB_NAME', 'tysus636_wp7');*/

/** MySQL database username */
/*define('DB_USER', 'tysus636_wp7');*/

/** MySQL database password */
/*define('DB_PASSWORD', 'G#doKYA&C6zQO7&ex9.74.(5');*/

/** MySQL hostname */
/*define('DB_HOST', 'localhost');*/

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
/*define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0gkbRf3HBjvbeKmLvPA81050dR4JLFlOmLWGQ1Sbzqtbvo6VcvHBJPRnLOpcKyn9');
define('SECURE_AUTH_KEY',  'Nf1i2W4brZU8Bd4h43GCvMJp2qv7y3WutSK8HpARBZCs5TxTvNh5DZFpVjmaBn6U');
define('LOGGED_IN_KEY',    '1Ki9v7lTa4JGHiaxxcuYPYKXpGQJJIaofrBWN3NOxBMs846jRL55j1jF7PkpAzBO');
define('NONCE_KEY',        'Ecxd3Tacha54lJrg4FzqZPetoBJjTNHWfNMidzggVrecTp4hGS7p6Unu8L2XXcJH');
define('AUTH_SALT',        'jDQ1dZvYq0DZ2PjdNtnS1p7Lj9qXYQ1v3yftkShgi8XZ2JjE2Ept1QUWgTiVfsUV');
define('SECURE_AUTH_SALT', '12lIDGSkwnjix2ZvZZfsxxzKG8DGJjEutbbNsG5M2eX5pBsXL6q4OSxc895JNp6K');
define('LOGGED_IN_SALT',   '4eUfLYSXW55T7B0vF1zN1D6YvWh7sWgEdrjEu6FYOXevAZroR5mHpQ8q3Hrd8a0U');
define('NONCE_SALT',       'Ywc8uS6BR5gzlgOJwvr4uBXwH4BPvWFOTbWhojJo3okkXxFKoJwddpNnzhFS6UjI');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
/* define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads'); */ /* Commented by CLV 4/26/17 */

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
/* require_once(ABSPATH . 'wp-settings.php'); */   /* Commented by CLV 4/26/17 */

$GLOBALS['today'] = '4/25/17';


?>