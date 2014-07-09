<?php namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    /**
     * Load MetaTrait
     */
    use MetaTrait;

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

    /**
     * Get users with a given (nice)name
     *
     * @param object       $query The query object
     * @param array|string $name  The (nice)name(s) of the author(s)
     *
     * @return object The query object
     */
    public function scopeName($query, $name)
    {
        if (!is_array($name)) {
            return $query->where('user_nicename', $name);
        }
        return $query->whereIn('user_nicename', $name);
    }
}
