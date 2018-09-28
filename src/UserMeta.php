<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserMeta extends Eloquent
{
    /**
     * @var string The DB table name
     */
    protected $table = 'usermeta';

    /**
     * @var string Primary DB key
     */
    protected $primaryKey = 'meta_id';

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
     * Define user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Square1\Wordpressed\User');
    }
}
