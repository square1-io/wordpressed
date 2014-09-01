<?php namespace Square1\Wordpressed;

use Square1\Wordpressed\Term as Term;

class Format extends Term
{
    /**
     * Override the default query to do all the post format joins
     *
     * @param boolean $excludeDeleted Include soft deleted columns
     *
     * @return object The query object
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->where('taxonomy', '=', 'post_format');

        return $query;
    }
}
