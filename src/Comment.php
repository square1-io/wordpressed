<?php namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent
{
    /**
     * Load MetaTrait
     */
    use MetaTrait;

    /**
     * @var string The DB table name
     */
    protected $table = 'comments';

    /**
     * @var string Primiary DB key
     */
    protected $primaryKey = 'comment_ID';

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
        return $this->hasMany('Square1\Wordpressed\CommentMeta', 'comment_id');
    }

    /**
     * Define post relationship
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo('Square1\Wordpressed\Post', 'comment_post_ID');
    }
}
