<?php namespace Square1\Wordpressed;

use Square1\Wordpressed\Term as Term;

class Category extends Term
{
    /**
     * Override the default query to do all the category joins
     * 
     * @param boolean $excludeDeleted Include soft deleted columns
     * 
     * @return object The query object
     */
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        $query->where('taxonomy', '=', 'category');
        return $query;
    }

    /**
     * Return parent category
     *
     * @return 
     */
    public function parents()
    {
        return $this->hasOne(
            '\Square1\Wordpressed\Category',
            'term_taxonomy_id',
            'parent'
        );
    }
}
