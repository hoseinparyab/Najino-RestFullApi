<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UsersItemSchema",
 *
 *                          @OA\Property(
 *                              property="id",
 *                              type="integer",
 *                              nullable=false,
 *                              example=1,
 *                          ),
 *                          @OA\Property(
 *                              property="full_name",
 *                              type="string",
 *                              nullable=false,
 *                              example="Amir",
 *                          ),
 * )
 */
class UsersListApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
        ];
    }
}
