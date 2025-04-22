<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function get_posts(Request $request) {

        $tagSlug = $request->query('tag');

        $posts = Post::with('category');

        if ($tagSlug) {
            $tag = Tag::where('slug', $tagSlug)->first();
            if ($tag) {
                $posts = Post::whereHas('tags', function($query) use ($tag) {
                    $query->where('tag_id', $tag->id);
                })->with('category');
            } else {
                return abort(404);
            }
        }

        $checkPosts = $posts->get();

        if ($checkPosts->isEmpty()) {
            return abort(404);
        }

        $posts = $posts->orderBy('updated_at', 'desc')
            ->paginate(8);
        return $posts;
    }
    
    public function get_post($slug) {
        $post = Post::where('slug', $slug)
            ->with('tags') 
            ->with('category')
            ->firstOrFail();
        return $post;
    }

    public function get_last_posts() {
        $posts = Post::with('category')
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
        return $posts;
    }

    public function get_related_posts($category_id, $id) {
        $posts = Post::with('category')
            ->where([
                ['category_id', '=', $category_id],
                ['id', '<>', $id]
            ])
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
        return $posts;
    }

    public function get_category_posts(Request $request, $slug) {

        $tagSlug = $request->query('tag');

        $posts = Post::with('category');
        $category = Category::where('slug', $slug)->first();
        
        if ($category) {
            if ($tagSlug) {
                $tag = Tag::where('slug', $tagSlug)->first();
                
                if ($tag) {
                    $posts = Post::whereHas('tags', function($query) use ($tag) {
                        $query->where('tag_id', $tag->id);
                    })
                        ->with('category')
                        ->where('category_id', $category->id);
                } else {
                    abort(404);
                }
            }
            
            $checkPosts = $posts->get();

            if ($checkPosts->isEmpty()) {
                return abort(404);
            }
            
            $posts = $posts->orderBy('updated_at', 'desc')
                ->paginate(8);
        } else {
            abort(404);
        }
        
        return $posts;
    }

    public function get_categories() {
        $categories = Category::all();
        return $categories;
    }

    public function get_tags() {
        $tags = Tag::all();
        return $tags;
    }

    public function get_tag_posts($id) {
        $tag = Tag::find($id)
            ->with('posts')
            ->get();
        return $tag;
    }
}
