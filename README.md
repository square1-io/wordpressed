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
Wordpressed::connect(
    'host'      => '127.0.0.1',
    'database'  => 'your_db_name',
    'username'  => 'your_username',
    'password'  => 'some_secure_password',
);

$posts = Post::id([12345, 54321])->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

$post = Post::with('author', 'attachments', 'thumbnail', 'categories', 'tags')->find(8271);
print_r($post);

$posts = Post::slug(this-is-a-post-title')->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

$posts = Post::slug(['this-is-a-post-title', 'another-post-title'])->get();
foreach ($posts as $post) {
    echo $post->post_name;
}

$posts = Post::status('publish')->take(10)->get();
print_r($posts->toArray());

$category = Category::get();
print_r($category->toArray());

$category = Category::slug(['sport', 'golf'])->get();
print_r($category->toArray());

$author = User::find(123);
print_r($author->toArray());

$posts = User::find(24)->posts()->status('publish')->first();
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
