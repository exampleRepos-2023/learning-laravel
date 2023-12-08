<?php

namespace App\Models;

use Cache;
use App\Traits\Taggable;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BlogPost extends Model
{

    // protected $fillable = ['title', 'content'];

    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderByDesc(static::CREATED_AT);
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query
            ->withCount('comments')
            ->orderByDesc('comments_count');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query
            ->latest()
            ->withCount('comments')
            ->with('user', 'tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());

        parent::boot();

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        // Listen for the 'updating' event on the 'BlogPost' model
        // Clear the cache for the specific blog post
        static::updating(function (BlogPost $blogPost) {
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
