<?php namespace Square1\Wordpressed;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    /**
     * Load MetaTrait
     */
    use MetaTrait;

    /**
     * @var string The DB table name
     */
    protected $table = 'posts';

    /**
     * @var string Primiary DB key
     */
    protected $primaryKey = 'ID';

    /**
     * @var array Models to lazy load
     */
    protected $with = ['meta'];

    /**
     * @var string The type of WP post
     */
    protected $postType = 'post';

    /**
     * @var boolean Disable 'created_at' and 'updated_at' timestamp columns
     */
    public $timestamps = false;

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
        return $query->where(
            'post_type',
            $this->postType
        )->orderBy(
            'post_date',
            'desc'
        );
    }

    /**
     * Define post meta relationship
     * 
     * @return object
     */
    public function meta()
    {
        return $this->hasMany('Square1\Wordpressed\PostMeta', 'post_id');
    }

    /**
     * Define author relationship
     *
     * @return object
     */
    public function author()
    {
        return $this->belongsTo('Square1\Wordpressed\User', 'post_author');
    }

    /**
     * Define image relationship
     *
     * @return object
     */
    public function attachments()
    {
        return $this->hasMany('Square1\Wordpressed\Attachment', 'post_parent');
    }

    /**
     * Define image relationship
     *
     * @return object
     */
    public function comments()
    {
        return $this->hasMany('Square1\Wordpressed\Comment', 'comment_post_ID');
    }

    /**
     * Get thumbnail attachment
     *
     * @return object
     */
    public function thumbnail()
    {
        return $this->belongsToMany(
            'Square1\Wordpressed\Attachment',
            'postmeta',
            'post_id',
            'meta_value'
        )->where('meta_key', '_thumbnail_id');
    }

    /**
     * Define categories relationship
     *
     * @return object
     */
    public function categories()
    {
        return $this->belongsToMany(
            'Square1\Wordpressed\Category',
            'term_relationships',
            'object_id',
            'term_taxonomy_id'
        )->select('terms.*');
    }

    /**
     * Define tags relationship
     *
     * @return object
     */
    public function tags()
    {
        return $this->belongsToMany(
            'Square1\Wordpressed\Tag',
            'term_relationships',
            'object_id',
            'term_taxonomy_id'
        )->select('terms.*');
    }

    /**
     * Define formats relationship
     *
     * @return object
     */
    public function formats()
    {
        return $this->belongsToMany(
            'Square1\Wordpressed\Format',
            'term_relationships',
            'object_id',
            'term_taxonomy_id'
        )->select('terms.*');
    }

    /**
     * Get posts with a given slug
     *
     * @param object       $query The query object
     * @param array|string $slug  The name(s) of the article(s)
     * 
     * @return object The query object
     */
    public function scopeSlug($query, $slug)
    {
        if (!is_array($slug)) {
            return $query->where('post_name', $slug);
        }
        return $query->whereIn('post_name', $slug);
    }

    /**
     * Get posts within an array of ID's
     *
     * @param object $query The query object
     * @param string $ids   The list of post ids
     *
     * @return object The query object
     */
    public function scopeId($query, $id)
    {
        if (!is_array($id)) {
            return $query->where('ID', $id);
        }
        return $query->whereIn('ID', $id);
    }

    /**
     * Get posts with a given category
     *
     * @param object $query The query object
     * @param string $slug  The slug name of the category
     * 
     * @return object The query object
     */
    public function scopeCategory($query, $slug)
    {
        return $this->taxonomy($query, 'category', $slug);
    }

    /**
     * Get posts with a given tag
     *
     * @param object $query The query object
     * @param string $slug  The slug name of the tag
     * 
     * @return object The query object
     */
    public function scopeTag($query, $slug)
    {
        return $this->taxonomy($query, 'post_tag', $slug);
    }

    /**
     * Get posts with a given format
     *
     * @param object $query The query object
     * @param string $slug  The slug name of the format
     *
     * @return object The query object
     */
    public function scopeFormat($query, $slug)
    {
        return $this->taxonomy($query, 'post_format', $slug);
    }

    /**
     * Get posts with a given taxonomy
     *
     * @param object $query The query object
     * @param string $name The taxonomy name
     * @param string $slug The slug name
     * 
     * @return object The query object
     */
    protected function taxonomy($query, $name, $slug)
    {
        $query->select('posts.*')
        ->leftjoin('term_relationships', 'object_id', '=', 'id')
            ->leftjoin(
                'term_taxonomy',
                'term_relationships.term_taxonomy_id',
                '=',
                'term_taxonomy.term_taxonomy_id'
            )
            ->leftjoin(
                'terms',
                'term_taxonomy.term_id',
                '=',
                'terms.term_id'
            )
            ->where('taxonomy', '=', $name);

        if (!is_array($slug)) {
            return $query->where('slug', $slug);
        }
        return $query->whereIn('slug', $slug);
    }

    /**
     * Get posts with a given status
     *
     * @param object $query  The query object
     * @param string $status The status of the post
     * 
     * @return object The query object
     */
    public function scopeStatus($query, $status = '')
    {
        return $query->where('post_status', $status);
    }

    /**
     * Get posts with a given post type
     * 
     * @param string $type
     * @return \Corcel\PostBuilder
     */
    public function scopeType($query, $type)
    {
        return $query->where('post_type', $type);
    }
}
