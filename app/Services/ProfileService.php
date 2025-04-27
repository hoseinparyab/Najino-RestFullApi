<?php

namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function updateProfile(Profile $profile, array $data): Profile
    {
        $profile->update($data);
        return $profile->fresh();
    }
}
