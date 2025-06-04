<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Base\ServiceResult;
use App\Base\ServiceWrapper;

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
            $storagePath = 'portfolios/' . date('Y/m/d');
            
            // Create directory if not exists
            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->makeDirectory($storagePath, 0755, true);
            }

            // Handle cover image upload
            if (isset($inputs['cover_image']) && $inputs['cover_image']->isValid()) {
                $coverImage = $inputs['cover_image'];
                $coverImageName = 'cover_' . time() . '_' . Str::random(10) . '.' . $coverImage->getClientOriginalExtension();
                $coverImagePath = $coverImage->storeAs('public/' . $storagePath, $coverImageName);
                $inputs['cover_image'] = str_replace('public/', '', $coverImagePath);
            }

            // Handle single image upload
            if (isset($inputs['images']) && $inputs['images']->isValid()) {
                $image = $inputs['images'];
                $imageName = 'image_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/' . $storagePath, $imageName);
                $inputs['images'] = str_replace('public/', '', $imagePath);
            }

            return Portfolio::create($inputs);
        });
    }

    public function updatePortfolio(array $inputs, Portfolio $portfolio): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $portfolio) {
            $storagePath = 'portfolios/' . date('Y/m/d');
            
            // Create directory if not exists
            if (!Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->makeDirectory($storagePath, 0755, true);
            }

            // Handle cover image update
            if (isset($inputs['cover_image']) && $inputs['cover_image']->isValid()) {
                // Delete old cover image
                if ($portfolio->cover_image) {
                    Storage::delete('public/'.$portfolio->cover_image);
                }
                
                $coverImage = $inputs['cover_image'];
                $coverImageName = 'cover_'.time().'_'.Str::random(10).'.'.$coverImage->getClientOriginalExtension();
                $coverImagePath = $coverImage->storeAs('public/' . $storagePath, $coverImageName);
                $inputs['cover_image'] = str_replace('public/', '', $coverImagePath);
            }

            // Handle single image update
            if (isset($inputs['images'])) {
                // Delete old image if exists
                if ($portfolio->images) {
                    Storage::delete('public/'.$portfolio->images);
                }
                
                // Upload new image
                if ($inputs['images']->isValid()) {
                    $image = $inputs['images'];
                    $imageName = 'image_'.time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('public/' . $storagePath, $imageName);
                    $inputs['images'] = str_replace('public/', '', $imagePath);
                }
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
                $this->removeEmptyDirectory(dirname($portfolio->cover_image));
            }

            // Delete portfolio image (if exists)
            if ($portfolio->images) {
                Storage::delete('public/'.$portfolio->images);
                $this->removeEmptyDirectory(dirname($portfolio->images));
            }

            return $portfolio->delete();
        });
    }
    
    /**
     * Remove empty directory after file deletion
     */
    protected function removeEmptyDirectory(string $directory): void
    {
        $fullPath = storage_path('app/public/' . $directory);
        
        // Check if directory exists and is empty
        if (is_dir($fullPath) && count(scandir($fullPath)) == 2) { // 2 because of . and ..
            rmdir($fullPath);
            // Also try to remove parent directory if empty
            $parentDir = dirname($directory);
            if ($parentDir !== '.') {
                $this->removeEmptyDirectory($parentDir);
            }
        }
    }

    public function getPortfolio(Portfolio $portfolio): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($portfolio) {
            return $portfolio;
        });
    }

}
