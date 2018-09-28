<?php

namespace Square1\Wordpressed;

class Page extends Post
{
    /**
     * @var string The type of WP post
     */
    protected $postType = 'page';

    /**
     * @var array Models to lazy load
     */
    protected $with = ['meta'];
}
