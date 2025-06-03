<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ServiceResult;
use App\Services\ServiceWrapper;

class PortfolioService
{
    public function getAllPortfolios(): ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            return Portfolio::latest()->get();
        });
    }

    public function createPortfolio(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            // Handle cover image upload
            if (isset($inputs['cover_image']) && $inputs['cover_image']->isValid()) {
                $coverImage = $inputs['cover_image'];
                $coverImageName = time().'_cover_'.Str::random(10).'.'.$coverImage->getClientOriginalExtension();
                $coverImage->storeAs('public/portfolios', $coverImageName);
                $inputs['cover_image'] = 'portfolios/'.$coverImageName;
            }

            // Handle multiple images upload
            if (isset($inputs['images']) && is_array($inputs['images'])) {
                $imagesPaths = [];
                foreach ($inputs['images'] as $image) {
                    if ($image->isValid()) {
                        $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
                        $image->storeAs('public/portfolios', $imageName);
                        $imagesPaths[] = 'portfolios/'.$imageName;
                    }
                }
                $inputs['images'] = $imagesPaths;
            }

            return Portfolio::create($inputs);
        });
    }

    public function updatePortfolio(array $inputs, Portfolio $portfolio): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $portfolio) {
            // Handle cover image update
            if (isset($inputs['cover_image']) && $inputs['cover_image']->isValid()) {
                // Delete old cover image
                if ($portfolio->cover_image) {
                    Storage::delete('public/'.$portfolio->cover_image);
                }
                
                $coverImage = $inputs['cover_image'];
                $coverImageName = time().'_cover_'.Str::random(10).'.'.$coverImage->getClientOriginalExtension();
                $coverImage->storeAs('public/portfolios', $coverImageName);
                $inputs['cover_image'] = 'portfolios/'.$coverImageName;
            }

            // Handle multiple images update
            if (isset($inputs['images']) && is_array($inputs['images'])) {
                // Delete old images
                if ($portfolio->images) {
                    foreach ($portfolio->images as $oldImage) {
                        Storage::delete('public/'.$oldImage);
                    }
                }

                $imagesPaths = [];
                foreach ($inputs['images'] as $image) {
                    if ($image->isValid()) {
                        $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
                        $image->storeAs('public/portfolios', $imageName);
                        $imagesPaths[] = 'portfolios/'.$imageName;
                    }
                }
                $inputs['images'] = $imagesPaths;
            }

            $portfolio->update($inputs);
            return $portfolio;
        });
    }

    public function deletePortfolio(Portfolio $portfolio): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($portfolio) {
            // Delete cover image
            if ($portfolio->cover_image) {
                Storage::delete('public/'.$portfolio->cover_image);
            }

            // Delete all portfolio images
            if ($portfolio->images) {
                foreach ($portfolio->images as $image) {
                    Storage::delete('public/'.$image);
                }
            }

            return $portfolio->delete();
        });
    }

    public function getPortfolio(Portfolio $portfolio): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($portfolio) {
            return $portfolio;
        });
    }
}
