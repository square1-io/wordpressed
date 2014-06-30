<?php namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Square1\Wordpressed\MetaTrait;

class User extends Eloquent
{
    /**
     * @var string The DB table name
     */
    protected $table = 'users';

    /**
     * @var string Primiary DB key
     */
    protected $primaryKey = 'ID';

    /**
     * @var array Models to lazy load
     */
    protected $with = ['meta'];

    /**
     * @var boolean Disable 'created_at' and 'updated_at' timestamp columns
     */
    public $timestamps = false;

    /**
     * Define user meta relationship
     * 
     * @return object
     */
    public function meta()
    {
        return $this->hasMany('Square1\Wordpressed\UserMeta', 'user_id');
    }

    /**
     * Define post relationship
     *
     * @return object
     */
    public function posts()
    {
        return $this->hasMany('Square1\Wordpressed\Post', 'post_author');
    }
}
