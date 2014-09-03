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
            'database' => __DIR__ . '/resources/db.sqlite'
        ];
        //fopen($this->config['database'], 'w');

        //Initiate manager
        $m = new Manager($this->config);
    }

    /**
     * Teardown
     */
    protected function tearDown()
    {
        //Delete db file
        //unlink($this->config['database']);
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

    /**
     * Test slug scope
     */
    public function testPostInsert()
    {
        $post = new Post();
        $post->ID = 1;
        $post->post_title = 'this-is-the-post-name';
        $post->post_name = 'this-is-the-post-name';
        $post->post_content = 'Hello world, this is some content!';
        $post->post_excerpt = 'Hello world, this is some excerpt!';
        $pint->post_content_filtered = '0';
        $post->to_ping = '0';
        $post->pinged = '0';
        $post->save();

        //$this->assertEquals($sql, 'select * from "wp_posts" where "post_type" = ? and "post_name" = ?');
    }
}
