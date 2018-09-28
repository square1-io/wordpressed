<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Capsule\Manager as Capsule;

class Manager
{
    /**
     * @var array Default database connection params
     */
    protected $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'database',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => 'wp_',
        'options' => [],
    ];

    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    private $capsule;

    /**
     * Connect to the Wordpress database.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->capsule = new Capsule();
        $this->capsule->addConnection(array_merge($this->config, $config));
        $this->capsule->bootEloquent();
    }

    /**
     * Get the query log.
     *
     * @return array
     */
    public function getQueryLog()
    {
        return $this->capsule->getConnection()->getQueryLog();
    }
}
