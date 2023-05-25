<?php

namespace GlebRed\LaravelVueSimpleComments;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GlebRed\LaravelVueSimpleComments\Skeleton\SkeletonClass
 */
class LaravelVueSimpleCommentsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-vue-simple-comments';
    }
}
