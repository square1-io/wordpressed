<?php

namespace Square1\Wordpressed;

class Tag extends Term
{
    /**
     * Override the default query to do all the tag joins.
     *
     * @param bool $excludeDeleted Include soft deleted columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder query object
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->where('taxonomy', '=', 'post_tag');

        return $query;
    }
}
