<?php

namespace App\Services\Employee;

use App\Models\Review;

class ReviewService
 /**
     * Retrieve all reviews with their related user and property, ordered by latest.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Throwable If there is any error during retrieval.
     */
{
     public function getAllReviews()
    {
        try {
            return Review::with(['user', 'property'])->latest()->get();
        } catch (\Throwable $e) {
            Log::error('Get All Reviews Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
