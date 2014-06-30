<?php namespace Square1\Wordpressed;

use Square1\Wordpressed\Term as Term;

class Tag extends Term
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
        $query->where('taxonomy', '=', 'tag');
        return $query;
    }

    /**
     * Get tag(s) with given slug(s)
     *
     * @param object       $query The query object
     * @param array|string $slug  The name(s) of the slug(s)
     * 
     * @return object The query object
     */
    public function scopeSlug($query, $slug)
    {
        if (!is_array($slug)) {
            return $query->where('slug', $slug);
        }
        return $query->whereIn('slug', $slug);
    }
}
