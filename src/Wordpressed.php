<?php namespace Square1\Wordpressed;

use Illuminate\Database\Capsule\Manager as Capsule;

class Wordpressed
{
    /**
     * Default database connection params
     */
    static protected $default = [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'database',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => 'wp_',
        'options'   => [],
    ];

    /**
     * Connect to the Wordpress database
     * 
     * @param array $params
     */
    public static function connect(array $params = [])
    {
        $capsule = new Capsule;
        $capsule->addConnection(array_merge(static::$default, $params));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Get the query log
     * 
     * @return array
     */
    public static function getQueryLog()
    {
        return Capsule::connection()->getQueryLog();
    }
}
