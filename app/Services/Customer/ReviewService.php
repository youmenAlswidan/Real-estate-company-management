<?php

namespace App\Services\Customer;

use App\Models\Review;
use App\Models\Reservation;
use App\Http\Resources\Customer\ReviewResource;
use App\Traits\Customer\AuthTrait;

class ReviewService
{
    use AuthTrait;
      /**
     * Get all reviews for a specific property, ordered by latest first.
     *
     * @param int $propertyId
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllReviews($propertyId)
    {
        try {
            $reviews = Review::where('property_id', $propertyId)->latest()->get();
            return $this->successResponse(ReviewResource::collection($reviews), 'Property Reviews');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    /**
     * Store a new review by the authenticated user for a property.
     * Only allows if the user has a confirmed reservation for that property.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */

    public function storeReview($data)
    {
        try {
            $hasConfirmedReservation = Reservation::where('user_id', auth()->id())
                ->where('property_id', $data['property_id'])
                ->where('status', 'confirmed')
                ->exists();

            if (!$hasConfirmedReservation) {
                return $this->errorResponse('You can only submit a review if you have a confirmed reservation for this property.');
            }

            $data['user_id'] = auth()->id();

            $review = Review::create($data);
            return $this->successResponse(new ReviewResource($review), 'Review created successfully', 201);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
 /**
     * Show the details of a single review by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showReview($id)
    {
        try {
            $review = Review::findOrFail($id);
            return $this->successResponse(new ReviewResource($review), 'Review details');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
     /**
     * Update a review by ID.
     * Only the owner of the review (authenticated user) can update it.
     *
     * @param array $data
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateReview($data, $id)
    {
        try {
            $review = Review::findOrFail($id);

            if ($review->user_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $review->update($data);
            return $this->successResponse(new ReviewResource($review), 'Review updated successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
     /**
     * Delete a review by ID.
     * Only the owner of the review (authenticated user) can delete it.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteReview($id)
    {
        try {
            $review = Review::findOrFail($id);

            if ($review->user_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 403);
            }

            $review->delete();
            return $this->successResponse(null, 'Review deleted successfully');
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
