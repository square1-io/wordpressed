<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent
{
    /*
     * Load MetaTrait
     */
    use MetaTrait;

    /**
     * @var string The DB table name
     */
    protected $table = 'comments';

    /**
     * @var string Primary DB key
     */
    protected $primaryKey = 'comment_ID';

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
        return $this->hasMany('Square1\Wordpressed\CommentMeta', 'comment_id');
    }

    /**
     * Define post relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Square1\Wordpressed\Post', 'comment_post_ID');
    }
}
