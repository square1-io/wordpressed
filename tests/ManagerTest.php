<?php namespace Square1\Wordpressed\Test;

use Square1\Wordpressed\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
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
        $m = new Manager($this->config);
        $this->assertInstanceOf('\Square1\Wordpressed\Manager', $m);
    }

    /**
     * Test Capsule instance
     */
    public function testCapsule()
    {
        $m = new Manager($this->config);
        $this->assertInstanceOf('\Illuminate\Database\Capsule\Manager', $m->getCapsule());
    }

    /**
     * Test connecton
     */
    public function testConnecton()
    {
        $m = new Manager($this->config);
        $this->assertInstanceOf('\Illuminate\Database\Connection', $m->getCapsule()->getConnection());
    }

    /**
     * Test connection exception
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Database does not exist.
     */
    public function testConnectionException()
    {
        $m = new Manager(array_merge($this->config, ['database' => 'invalid-file-name.sqlite']));
        $this->assertInstanceOf('\Illuminate\Database\Connection', $m->getCapsule()->getConnection());
    }

    /**
     * Test query
     */
    public function testQuery()
    {
        $query = 'SELECT \'world\' AS hello';
        $m = new Manager($this->config);
        $result = $m->getCapsule()->getConnection()->select($query);
        $this->assertInternalType('array', $result);
        $this->assertEquals(key($result[0]), 'hello');
        $this->assertEquals($result[0][key($result[0])], 'world');
    }

    /**
     * Test query exception
     *
     * @expectedException Illuminate\Database\QueryException
     */
    public function testQueryException()
    {
        $m = new Manager($this->config);
        $m->getCapsule()->getConnection()->select('SELECT * FROM invalide_table');
    }

    /**
     * Test query log
     */
    public function testQueryLog()
    {
        $query = 'SELECT 1';
        $m = new Manager($this->config);
        $m->getCapsule()->getConnection()->select($query);
        $this->assertInternalType('array', $m->getQueryLog());
        $this->assertEquals($m->getQueryLog()[0]['query'], $query);
    }
}
