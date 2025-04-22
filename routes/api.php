<?php

use App\Http\Controllers\api\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-posts', [BlogController::class, 'get_posts']);

Route::get('/get-post/{slug}', [BlogController::class, 'get_post']);

Route::get('/get-last-posts', [BlogController::class, 'get_last_posts']);

Route::get('/get-related-posts/{category_id}/{id}', [BlogController::class, 'get_related_posts']);

Route::get('/get-category-posts/{slug}', [BlogController::class, 'get_category_posts']);

Route::get('/get-categories', [BlogController::class, 'get_categories']);

Route::get('/get-tags', [BlogController::class, 'get_tags']);

Route::get('/get-tag-posts/{id}', [BlogController::class, 'get_tag_posts']);