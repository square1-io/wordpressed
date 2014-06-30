# Wordpressed

** Work in progress **


## Install

Via Composer

``` json
{
    "require": {
        "square1/wordpressed": "~1.0"
    }
}
```

## Example Usage

``` php
use \Square1\Wordpressed\Manager;
use \Square1\Wordpressed\Post;
use \Square1\Wordpressed\Category;
use \Square1\Wordpressed\User;

//Connect to DB
Manager::connect(
    'host'      => '127.0.0.1',
    'database'  => 'your_db_name',
    'username'  => 'your_username',
    'password'  => 'some_secure_password',
);

//Get Query Log
print_r(Manager::getQueryLog());

//Get post by id
$post = Post::find(12345);
echo $post->post_name;

//Get posts by ids
$posts = Post::id([12345, 54321])->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

//Get post by slug
$posts = Post::slug('this-is-a-post-title')->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

//Get posts by slugs
$posts = Post::slug(['this-is-a-post-title', 'another-post-title'])->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

//Load all relationships
$post = Post::with('author', 'attachments', 'thumbnail', 'categories', 'tags')
    ->find(12345);
print_r($post);

//Load a selection of posts
$posts = Post::status('publish')->skip(10)->take(10)->get();
print_r($posts->toArray());

//Load all categories
$category = Category::get();
print_r($category->toArray());

//Load categories by slug name
$category = Category::slug(['sport', 'golf'])->get();
print_r($category->toArray());

//Load user by id
$author = User::find(123);
print_r($author->toArray());

//Load user by name
$users = User::name(['john', 'mary'])->get();
print_r($users->toArray());

//Load posts by user
$posts = User::find(123)->posts()->status('publish')->first();
print_r($posts->toArray());
```

## Testing

``` bash
$ vendor/bin/phpunit --coverage-text
$ vendor/bin/phpcs --standard=psr2 src/
```

## Contributing

Please see [CONTRIBUTING](https://github.com/square1-io/wordpressed/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/square1-io/wordpressed/blob/master/LICENSE) for more information.
