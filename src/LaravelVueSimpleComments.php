<?php

namespace GlebRed\LaravelVueSimpleComments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use GlebRed\LaravelVueSimpleComments\Requests\CommentRequest;

abstract class LaravelVueSimpleComments extends Controller
{

  //Authorise, validate, store and return a flash message
  abstract public function store(CommentRequest $request);


  //Check if authorised and then delete a comment, return a flash message on success
  abstract public function destroy(Comment $comment);

}
