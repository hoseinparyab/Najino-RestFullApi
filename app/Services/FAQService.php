<?php

namespace App\Services;

use App\Models\FAQ;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FAQService
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = FAQ::query();

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    public function getActiveFAQs(): Collection
    {
        return FAQ::where('is_active', true)->get();
    }

    public function find(int $id): ?FAQ
    {
        return FAQ::find($id);
    }

    public function create(array $data): FAQ
    {
        return FAQ::create($data);
    }

    public function update(FAQ $faq, array $data): bool
    {
        return $faq->update($data);
    }

    public function delete(FAQ $faq): bool
    {
        return $faq->delete();
    }
}
