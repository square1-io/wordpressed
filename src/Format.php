<?php

namespace Square1\Wordpressed;

class Format extends Term
{
    /**
     * Override the default query to do all the post format joins.
     *
     * @param bool $excludeDeleted Include soft deleted columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->where('taxonomy', '=', 'post_format');

        return $query;
    }
}
