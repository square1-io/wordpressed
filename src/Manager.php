<?php namespace Square1\Wordpressed;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Cache\CacheManager as CacheManager;
use \Illuminate\Filesystem\Filesystem as Filesystem;

class Manager
{
    /**
     * @var Default database connection params
     */
    protected $config = [
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
     * @var Illuminate\Database\Capsule\Manager
     */
    private $capsule;

     /**
     * @var Illuminate\Database\Capsule\Manager
     */
    private $cache;

    /**
     * Connect to the Wordpress database
     * 
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection(array_merge($this->config, $config));
        $this->capsule->bootEloquent();
    }

    /**
     * Get the query log
     * 
     * @return array
     */
    public function getQueryLog()
    {
        return $this->capsule->getConnection()->getQueryLog();
    }

    /**
     * Cache callback
     *
     * @param string  $key      The cache key
     * @param int     $ttl      The time in minutes
     * @param Closure $callback The callback query
     *
     * @return array
     */
    public function remember($key, $ttl, $callback)
    {
        return $this->cache->remember($key, $ttl, $callback);
    }

    /**
     * Cache callback, remember forever
     *
     * @param string  $key      The cache key
     * @param Closure $callback The callback query
     *
     * @return array
     */
    public function rememberForever($key, $callback)
    {
        return $this->cache->rememberForever($key, $callback);
    }

    /**
     * Enable cache
     *
     * @param array $config The cache config
     */
    public function enableCache($config)
    {
        $container = $this->capsule->getContainer();

        if ($config['driver'] == 'file') {
            $container->offsetGet('config')
                ->offsetSet('cache.driver', 'file');
            $container->offsetGet('config')
                ->offsetSet('cache.path', $config['path']);
            $container->offsetGet('config')
                ->offsetSet('cache.connection', $config['connection']);
            $container['files'] = new Filesystem();

        } elseif ($config['driver'] == 'apc') {
            $container->offsetGet('config')->offsetSet('cache.driver', 'apc');
        }

        $cacheManager = new CacheManager($container);
        $this->cache = $cacheManager->driver();
        $this->capsule->setCacheManager($cacheManager);
    }
}
