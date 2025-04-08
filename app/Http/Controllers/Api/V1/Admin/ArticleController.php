<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\SearchOptions\ArticleAuthorSearchOptions;
use App\Http\Resources\Admin\Article\ArticleDetailsApiResource;
use App\Http\Resources\Admin\Article\ArticlesListApiResource;
use App\Services\ArticleService;
use App\RestfulApi\Facades\ApiResponse;
use App\Http\Requests\Admin\Article\StoreArticleRequest;
use App\Http\Requests\Admin\Article\UpdateArticleRequest;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        try {
            $articles = Article::with(['user', 'category'])
                ->latest()
                ->paginate(10);

            return ApiResponse::withData(ArticlesListApiResource::collection($articles))->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $validated = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $validated['image'] = 'articles/' . $imageName;
            }

            $validated['user_id'] = auth()->id();
            $validated['slug'] = Str::slug($request->title);
            $validated['view'] = 0;

            $article = Article::create($validated);

            return ApiResponse::withMessage('Article created successfully')
                ->withData(new ArticleDetailsApiResource($article))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        try {
            $article->load(['user', 'category']);

            return ApiResponse::withData(new ArticleDetailsApiResource($article))->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Update the specified article in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        try {
            $validated = $request->validated();

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                // Delete old image
                if ($article->image) {
                    Storage::delete('public/' . $article->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $validated['image'] = 'articles/' . $imageName;
            }

            if (isset($validated['title'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            $article->update($validated);

            return ApiResponse::withMessage('Article updated successfully')
                ->withData(new ArticleDetailsApiResource($article))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        try {
            // Delete associated image
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }

            $article->delete();

            return ApiResponse::withMessage('Article deleted successfully')->withStatus(200)->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later!')->withStatus(500)->build()->response();
        }
    }
}
