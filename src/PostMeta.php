<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PostMeta extends Eloquent
{
    /**
     * @var string The DB table name
     */
    protected $table = 'postmeta';

    /**
     * @var string Primary DB key
     */
    protected $primaryKey = 'meta_id';

    /**
     * @var array Mass-assignable attributes
     */
    protected $fillable = ['post_id', 'meta_key', 'meta_value'];

    /**
     * @var bool Disable 'created_at' and 'updated_at' timestamp columns
     */
    public $timestamps = false;

    /**
     * Override the default Collection.
     *
     * @param array $models
     *
     * @return \Square1\Wordpressed\MetaCollection
     */
    public function newCollection(array $models = [])
    {
        return new MetaCollection($models);
    }

    /**
     * Define post relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Square1\Wordpressed\Post');
    }
}
