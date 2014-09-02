<?php namespace Square1\Wordpressed\Test;

use Square1\Wordpressed\Manager;
use Square1\Wordpressed\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Connection config
     */
    protected $config;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->config = [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/db.sqlite'
        ];
        fopen($this->config['database'], 'w');

        //Initiate manager
        $m = new Manager($this->config);
    }

    /**
     * Teardown
     */
    protected function tearDown()
    {
        //Delete db file
        unlink($this->config['database']);
    }

    /**
     * Test instance
     */
    public function testInstance()
    {
        $post = Post::query();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $post);
    }

    /**
     * Test slug scope
     */
    public function testSlugScope()
    {
        $sql = Post::slug('name')->toSql();
        $this->assertEquals($sql, 'select * from "wp_posts" where "post_type" = ? and "post_name" = ?');
    }
}
