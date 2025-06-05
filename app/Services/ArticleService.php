<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function getAllArticles(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $perPage = max(1, (int) ($inputs['per_page'] ?? 10));
            $page = max(1, (int) ($inputs['page'] ?? 1));
            
            $query = Article::with(['user', 'category'])
                ->when(isset($inputs['category_id']), function ($q) use ($inputs) {
                    $q->where('category_id', $inputs['category_id']);
                });
                
            // Apply search if provided
            if (!empty($inputs['search'])) {
                $query->where('title', 'like', '%' . $inputs['search'] . '%');
            }
            
            // Get the total count
            $total = $query->count();
            
            // If no results, return empty collection with pagination info
            if ($total === 0) {
                return new \Illuminate\Pagination\LengthAwarePaginator(
                    collect([]),
                    0,
                    $perPage,
                    $page,
                    ['path' => '']
                );
            }
            
            // Calculate pagination
            $lastPage = max(1, (int) ceil($total / $perPage));
            $page = min($page, $lastPage);
            
            // Get the results
            $items = $query->latest()
                         ->skip(($page - 1) * $perPage)
                         ->take($perPage)
                         ->get();
            
            return new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => '']
            );
        });
    }

    public function getArticleInfo(Article $article): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($article) {
            $article->load(['user', 'category', 'comments.user']);

            return $article;
        });
    }

    public function createArticle(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            // Handle image upload
            if (isset($inputs['image'])) {
                $image = $inputs['image'];
                $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $inputs['image'] = 'articles/'.$imageName;
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
                    Storage::delete('public/'.$article->image);
                }

                $image = $inputs['image'];
                $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $inputs['image'] = 'articles/'.$imageName;
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
                Storage::delete('public/'.$article->image);
            }

            return $article->delete();
        });
    }

    public function getLatestArticles(int $count = 4): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($count) {
            return Article::with(['user', 'category'])
                ->latest()
                ->take($count)
                ->get();
        });
    }
}
