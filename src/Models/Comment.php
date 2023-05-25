<?php

namespace GlebRed\LaravelVueSimpleComments\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
  protected $fillable = [
      'body',
      'commentable_id',
      'commentable_type',
      'user_id',
  ];

  public function getCreatedAtAttribute($value)
  {
    //Day month year format
    return Carbon::parse($value)->format('d.m.Y');
  }

  public function commentable(): MorphTo
  {
    return $this->morphTo();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

}
