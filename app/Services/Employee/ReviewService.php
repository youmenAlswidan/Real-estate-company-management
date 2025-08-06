<?php

namespace App\Services\Employee;

use App\Models\Review;

class ReviewService
{
    public function getAllReviews()
    {
        return Review::with(['user', 'property'])->latest()->get();
    }
}
