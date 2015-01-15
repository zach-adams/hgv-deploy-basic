<?php
// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpe_{{ enviro }}');

/** MySQL database username */
define('DB_USER', 'wpe_{{ enviro }}');

/** MySQL database password */
define('DB_PASSWORD', 'wordpress');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', true);

global $memecached_servers;

$memcached_servers = array(
    'default' => array(
        '127.0.0.1:11211'
    )
);

if( isset($_SERVER['HTTP_HOST']) && 'cache.' === substr( $_SERVER['HTTP_HOST'], 0, 6) ){
    define('WP_SITEURL', 'http://cache.{{ enviro }}.{{ host }}');
    define('WP_HOME', 'http://cache.{{ enviro }}.{{ host }}');
    define('WP_CACHE_KEY_SALT', 'cache_wpe_{{ enviro }}_1');
}else{
    define('WP_CACHE_KEY_SALT', 'wpe_{{ enviro }}_1');
}
