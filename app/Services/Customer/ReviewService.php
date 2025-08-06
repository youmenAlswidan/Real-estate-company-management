<?php

namespace App\Services\Customer;

use App\Models\Review;

class ReviewService
{
    public function storeReview($data)
    {
        return Review::create($data);
    }

    public function updateReview($review, $data)
    {
        $review->update($data);
        return $review;
    }

    public function deleteReview($review)
    {
        return $review->delete();
    }
}
