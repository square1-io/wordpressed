<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    /*
     * Load MetaTrait
     */
    use MetaTrait;

    /**
     * @var string The DB table name
     */
    protected $table = 'users';

    /**
     * @var string Primary DB key
     */
    protected $primaryKey = 'ID';

    /**
     * @var array Models to lazy load
     */
    protected $with = ['meta'];

    /**
     * @var bool Disable 'created_at' and 'updated_at' timestamp columns
     */
    public $timestamps = false;

    /**
     * Define user meta relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany('Square1\Wordpressed\UserMeta', 'user_id');
    }

    /**
     * Define post relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('Square1\Wordpressed\Post', 'post_author');
    }

    /**
     * Get users with a given (nice)name.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query The query object
     * @param array|string                                                             $name  The (nice)name(s) of
     *                                                                                        the author(s)
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder The query object
     */
    public function scopeName($query, $name)
    {
        if (!is_array($name)) {
            return $query->where('user_nicename', $name);
        }

        return $query->whereIn('user_nicename', $name);
    }
}
