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
     * @var int Cache timeout
     */
    private $ttl;

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
     * Enable cache
     * @todo Need to finished this section off!!
     */
    public function cache()
    {
        $container = $this->capsule->getContainer();
        $container->offsetGet('config')->offsetSet('cache.driver', 'file');
        $container->offsetGet('config')->offsetSet('cache.path', __DIR__ . '/cache');
        $container->offsetGet('config')->offsetSet('cache.connection', null);
        $container['files'] = new Filesystem();
        $cacheManager = new CacheManager($container);
        $this->capsule->setCacheManager($cacheManager);
    }
}
