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
        $query->where('post_type', $this->postType);

        return $query;
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
        return $this->hasMany('Square1\Wordpressed\Attachment', 'post_parent')
            ->orderBy('menu_order');
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
        )->select(['terms.*', 'term_taxonomy.*']);
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
        )->select(['terms.*', 'term_taxonomy.*']);
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
        )->select(['terms.*', 'term_taxonomy.*']);
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
     * @param string|array $slug  List of categories
     *
     * @return object The query object
     */
    public function scopeCategory($query, $slug)
    {
        return $query->whereHas('categories', function ($q) use ($slug) {
            if (is_array($slug)) {
                $q->whereIn('terms.slug', $slug);
            }
            $q->where('terms.slug', $slug);
        })->distinct('posts.ID');
    }

    /**
     * Get posts with a given tag
     *
     * @param object $query The query object
     * @param string|array $slug  List of tags
     *
     * @return object The query object
     */
    public function scopeTag($query, $slug)
    {
        return $query->whereHas('tags', function ($q) use ($slug) {
            if (is_array($slug)) {
                $q->whereIn('terms.slug', $slug);
            }
            $q->where('terms.slug', $slug);
        })->distinct('posts.ID');
    }

    /**
     * Get posts with a given format
     *
     * @param object $query The query object
     * @param string|array $slug  List of formats
     *
     * @return object The query object
     */
    public function scopeFormat($query, $slug)
    {
        return $query->whereHas('formats', function ($q) use ($slug) {
            if (is_array($slug)) {
                $q->whereIn('terms.slug', $slug);
            }
            $q->where('terms.slug', $slug);
        })->distinct('posts.ID');
    }

    /**
     * Get posts with a given taxonomy
     *
     * @param object $query The query object
     * @param string $name  The taxonomy name
     * @param string $slug  The slug name
     *
     * @return object The query object
     */
    protected function taxonomy($query, $name, $slug)
    {
        /**
         * The reasoning behind the pre and post fixing is so that a
         * category and tag search can be executed at the same time.
         */
        $postfix = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 10)), 0, 10);
        $prefix = $query->getQuery()->getConnection()->getTablePrefix();

        $query->select("posts.*")
            ->leftjoin(
                "term_relationships AS {$prefix}term_relationships{$postfix}",
                "term_relationships{$postfix}.object_id",
                "=",
                "id"
            )->leftjoin(
                "term_taxonomy AS {$prefix}term_taxonomy{$postfix}",
                "term_relationships{$postfix}.term_taxonomy_id",
                "=",
                "term_taxonomy{$postfix}.term_taxonomy_id"
            )->leftjoin(
                "terms AS {$prefix}terms{$postfix}",
                "term_taxonomy{$postfix}.term_id",
                "=",
                "terms{$postfix}.term_id"
            )->where(
                "term_taxonomy{$postfix}.taxonomy",
                "=",
                $name
            )->distinct();

        if (!is_array($slug)) {
            return $query->where("terms{$postfix}.slug", $slug);
        }

        return $query->whereIn("terms{$postfix}.slug", $slug);
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
     * @param  string              $type
     * @return \Corcel\PostBuilder
     */
    public function scopeType($query, $type)
    {
        return $query->where('post_type', $type);
    }
}
