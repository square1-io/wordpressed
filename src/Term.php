<?php

namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Term extends Eloquent
{
    /**
     * @var string The DB table name
     */
    protected $table = 'term_taxonomy';

    /**
     * @var string Primary DB key
     */
    protected $primaryKey = 'term_taxonomy_id';

    /**
     * @var bool Disable 'created_at' and 'updated_at' timestamp columns
     */
    public $timestamps = false;

    /**
     * Override the default query to do all the category joins.
     *
     * @param bool $excludeDeleted Include soft deleted columns
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder The query object
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id');

        return $query;
    }

    /**
     * Get term with given slug(s).
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query The query object
     * @param array|string                                                             $slug  The name(s) of the slug(s)
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder The query object
     */
    public function scopeSlug($query, $slug)
    {
        if (!is_array($slug)) {
            return $query->where('slug', $slug);
        }

        return $query->whereIn('slug', $slug);
    }
}
