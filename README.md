# Simple comments plugin for Laravel Inertia Vue stack

[![Latest Version on Packagist](https://img.shields.io/packagist/v/glebred/laravel-vue-simple-comments.svg?style=flat-square)](https://packagist.org/packages/glebred/laravel-vue-simple-comments)
[![Total Downloads](https://img.shields.io/packagist/dt/glebred/laravel-vue-simple-comments.svg?style=flat-square)](https://packagist.org/packages/glebred/laravel-vue-simple-comments)

### Preview
![preview](https://github.com/GlebRed/Laravel-Vue-Simple-Comments/raw/master/preview.gif)

This package allows you to add comments to your Laravel Inertia Vue stack application. The comment form is implemented using TS and Daisy UI which is a kit of UI components for Tailwind CSS. I made it because I needed a simple comment form for my project. I hope it will be useful for you too. 

## Requirements
- inertiajs/vue3 
- Daisy UI, 
- Tailwind  
- Vue-toastification

```bash
npm i @inertiajs/inertia-vue3
npm i tailwindcss
npm i vue-toastification
npm i daisyui
```

## Installation

You can install the package via composer:

```bash
composer require glebred/laravel-vue-simple-comments
```

Publish the view 
```bash
php artisan vendor:publish --provider="GlebRed\LaravelVueSimpleComments\LaravelVueSimpleCommentsServiceProvider"

```
This will create a 

- Vue view:
`resources/js/vendor/laravel-vue-simple-comments/Comments.vue`
- Also a migration
`database/migrations/create_comments_table.php`
- Model
`app/Models/Comment.php`
- Request
`app/Http/Requests/CommentRequest.php`
- Resource
`app/Http/Resources/CommentResource.php`

Call the comments section in your Vue component:

Import the component
`import CommentForm from "@/vendor/laravel-vue-simple-comments/Comments.vue";`
and use it in your template, for example:
```vue
<CommentForm :commentable="answer" :commentable_type="'answers'"></CommentForm>
```
Where `commentable` is the object you want to comment on, and `commentable_type` is the model name.

## Usage

Implement abstact class LaravelVueSimpleComments in your controller. Here is an example:

```php
use GlebRed\LaravelVueSimpleComments\Requests\CommentRequest;
use GlebRed\LaravelVueSimpleComments\LaravelVueSimpleComments;

class CommentsController extends LaravelVueSimpleComments
{

    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        $this->authorize('create', [Comment::class, $validated['commentable_id'], $validated['commentable_type']]);

        Comment::create([
            'commentable_id' => $validated['commentable_id'],
            'commentable_type' => $validated['commentable_type'],
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);


        return back()->with('flash', [
            'message' => 'Comment added successfully!',
        ]);

    }


    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('flash', [
            'message' => 'Comment deleted successfully!',
        ]);
    }
}
```

After that add routes to your web.php file:

```php
<?php
use App\Http\Controllers\MyCommentsController;

Route::post('/comments', [MyCommentsController::class, 'store']);
Route::delete('/comments/{comment}', [MyCommentsController::class, 'destroy']);
?>
```

To show a list of comments, don't forget to add a relationship to your content model:

```php
public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
```
And then add comments to your content resource, for example:

```php
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            //...
            //order by latest first
            'comments' => CommentResource::collection($this->comments()->orderBy('created_at', 'desc')->get()),
        ];
    }
}
```

### Testing

```bash
npm test
```

### Wishlist:
- [ ] Likes
- [ ] Replies

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email gleb.redko@gmail.com instead of using the issue tracker.

## Credits

-   [Gleb Redko](https://github.com/glebred)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
