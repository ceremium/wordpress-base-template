<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
$server_name = array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : '';
$host        = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '';

$is_local = strpos($server_name, '.local') > 0;
$is_dev   = strpos($server_name, 'dev') > 0;
$is_uat   = strpos($server_name, 'uat') > 0;
$is_prod  = !$is_local && !$is_dev && !$is_uat;

$is_secure      = $is_dev || $is_uat || $is_prod;
$is_show_errors = $is_local || $is_dev;

if ($is_local) {
    // load env vars from .env if local
    $autoload_filepath = __DIR__ . '/wp-content/themes/jeffries/vendor/autoload.php';
    require_once $autoload_filepath;

    $path   = realpath(__DIR__ . '/../');
    $dotenv = Dotenv\Dotenv::createImmutable($path);
    $dotenv->load();
}

$db_host     = $_ENV['DB_HOST'];
$db_name     = $_ENV['DB_NAME'];
$db_user     = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];
$redis_host  = $_ENV['REDIS_HOST'];

// set variables
define('DB_NAME', $db_name);
define('DB_HOST', $db_host);
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_password);

define('WP_REDIS_HOST', $redis_host);
define('WP_REDIS_MAXTTL', "3600");

if ($is_local) {
    define('WP_HOME', 'http://' . $_SERVER['SERVER_NAME'] . '/jeffries/website');
} else {
    define('WP_HOME', 'https://' . $_SERVER['SERVER_NAME']);
    ini_set('session.cookie_httponly', true);
    ini_set('session.cookie_secure', true);
    ini_set('session.use_only_cookies', true);
}

define('WP_SITEURL', WP_HOME . '/wp');

define('WP_CONTENT_DIR', __DIR__ . '/wp-content');
define('WP_CONTENT_URL', WP_HOME . '/wp-content');

define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

define('WP_DEFAULT_THEME', 'jeffries');
define('DISALLOW_FILE_EDIT', true);

// Disable Redis promotional banners
define('WP_REDIS_DISABLE_BANNERS', true);

// Feature flags
if ($is_local) {
    define('JEF_FEATURE_', false);
} elseif ($is_prod) {
    define('JEF_FEATURE_', false);
} elseif ($is_uat) {
    define('JEF_FEATURE_', false);
} elseif ($is_dev) {
    define('JEF_FEATURE_', false);
} else {
    define('JEF_FEATURE_', false);
}

if ($is_secure) {
    // TLS config
    define('FORCE_SSL_ADMIN', true);
    if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
        $_SERVER['HTTPS'] = 'on';
    }
}

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Disable the default WP Cron since we are using a cron job */
define('DISABLE_WP_CRON', true);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'JvkZhuM8G^=v[Di>}qQT+o<ei1Ca;>:afvA``E&_?vYex:ava-i!:)Ju5$#0WBMs');
define('SECURE_AUTH_KEY', '^({URUY=MIcq6*4PS=[,Yd5):R-{x*K@9vHG.^+ ht#Dd;Ay)q8pvd+*:PZ&rzW-');
define('LOGGED_IN_KEY', 'Fmz-#K#BcH?u`$%{tR8:f>+:iZJbB=S=;Z6KWO+BGkn4?G-]]L6&=K7kExiXSB;E');
define('NONCE_KEY', '3*9p}^gH{!$6]<0Jp3|;%?nd;AzDy|<{t2|^ARgoS~jQE8f0)Df[jn8$Ea;Bh3fT');
define('AUTH_SALT', 'mTV#kgkdoE+E)-8hBR<N~=tRfuc0yE[GEd-G9yZL^#dZ|$-M%8{l=_eqONEaE3*~');
define('SECURE_AUTH_SALT', '>iY$C95^jjS0JC(n+P])MC{-`Xrh#-XMiOZI{8`@i7Tppe].].|O/uLJ6%<`>o]t');
define('LOGGED_IN_SALT', 'c-xT/D:ozm/b20.)l!M{?^rKpaI7I-B35)5YkREEEweCmX>A4hfbaRNR[6d.bOJ<');
define('NONCE_SALT', 'GXn1@>RQ>3VE-0n4xm)?rvErcJ&iu8<Ma|HlK+tCk#[+5CdS[OhCX<zX$-}0I13j');

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
if ($is_show_errors) {
    ini_set('display_errors', 'Off');
    ini_set('error_reporting', E_ALL);
    define('WP_DEBUG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('WP_DEBUG_LOG', true);
} else {
    ini_set('display_errors', 'Off');
    ini_set('error_reporting', E_ALL);
    define('WP_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
}

/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
