<?php

namespace Square1\Wordpressed;

class Category extends Term
{
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
        $query->where('taxonomy', '=', 'category');

        return $query;
    }

    /**
     * Return parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parents()
    {
        return $this->hasOne(
            '\Square1\Wordpressed\Category',
            'term_taxonomy_id',
            'parent'
        );
    }

    /**
     * Return children categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(
            '\Square1\Wordpressed\Category',
            'parent',
            'term_taxonomy_id'
        );
    }
}
