<?php
namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\Article;
use App\SearchOptions\ArticleAuthorSearchOptions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function getAllArticles(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Article::with(['user', 'category'])
                ->search($inputs, new ArticleAuthorSearchOptions())
                ->latest()
                ->paginate(10);
        });
    }

    public function getArticleInfo(Article $article): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($article) {
            $article->load(['user', 'category']);
            return $article;
        });
    }

    public function createArticle(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            // Handle image upload
            if (isset($inputs['image'])) {
                $image = $inputs['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $inputs['image'] = 'articles/' . $imageName;
            }

            $inputs['user_id'] = auth()->id();
            $inputs['slug'] = Str::slug($inputs['title']);
            $inputs['view'] = 0;

            return Article::create($inputs);
        });
    }

    public function updateArticle(array $inputs, Article $article): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $article) {
            // Handle image upload if new image is provided
            if (isset($inputs['image'])) {
                // Delete old image
                if ($article->image) {
                    Storage::delete('public/' . $article->image);
                }

                $image = $inputs['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $inputs['image'] = 'articles/' . $imageName;
            }

            if (isset($inputs['title'])) {
                $inputs['slug'] = Str::slug($inputs['title']);
            }

            $article->update($inputs);
            return $article;
        });
    }

    public function deleteArticle(Article $article): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($article) {
            // Delete associated image
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }

            return $article->delete();
        });
    }
}
