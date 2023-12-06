<?php
namespace App\View\Composers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer {
  /**
   * Composes a view by retrieving the most commented blog posts,
   * the most active users, and the most active users in the last month.
   *
   * @param View $view The view to be composed.
   * @return void
   */
  public function compose(View $view) {
    $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-commented', 60, function () {
      return BlogPost::mostCommented()->take(5)->get();
    });

    $mostActive = Cache::remember('users-most-active', 60, function () {
      return User::withMostBlogPosts()->take(5)->get();
    });

    $mostActiveLastMonth = Cache::remember('users-most-active-last-month', 60, function () {
      return User::withMostBlogPostsLastMonth()->take(5)->get();
    });

    $view->with('mostCommented', $mostCommented);
    $view->with('mostActive', $mostActive);
    $view->with('mostActiveLastMonth', $mostActiveLastMonth);
  }
}
