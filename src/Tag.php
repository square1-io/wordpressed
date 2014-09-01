<?php namespace Square1\Wordpressed;

use Square1\Wordpressed\Term as Term;

class Tag extends Term
{
    /**
     * Override the default query to do all the tag joins
     *
     * @param boolean $excludeDeleted Include soft deleted columns
     *
     * @return object The query object
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->where('taxonomy', '=', 'post_tag');

        return $query;
    }
}
