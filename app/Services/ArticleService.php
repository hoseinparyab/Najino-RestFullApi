<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function getAllArticles(array $filters = [])
    {
        $query = Article::with(['user', 'category'])
            ->latest();

        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function createArticle(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image'])) {
                $image = $data['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $data['image'] = 'articles/' . $imageName;
            }

            $data['user_id'] = auth()->id();
            $data['slug'] = Str::slug($data['title']);
            $data['view'] = 0;

            return Article::create($data);
        });
    }

    public function updateArticle(Article $article, array $data)
    {
        return DB::transaction(function () use ($article, $data) {
            if (isset($data['image'])) {
                // Delete old image
                if ($article->image) {
                    Storage::delete('public/' . $article->image);
                }

                $image = $data['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $data['image'] = 'articles/' . $imageName;
            }

            if (isset($data['title'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            $article->update($data);
            return $article;
        });
    }

    public function deleteArticle(Article $article)
    {
        return DB::transaction(function () use ($article) {
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }
            return $article->delete();
        });
    }
}