<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreReviewRequest;
use App\Http\Requests\Customer\UpdateReviewRequest;
use App\Services\Customer\ReviewService;
use App\Traits\Customer\AuthTrait;

/**
 * Handles customer review operations via API.
 */
class ReviewController extends Controller
{
    use AuthTrait;

    // Service responsible for handling review business logic
    protected $reviewService;

    /**
     * Inject ReviewService into the controller.
     *
     * @param ReviewService $reviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Display a list of all reviews for the specified property.
     *
     * @param int $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($propertyId)
    {
        return $this->reviewService->getAllReviews($propertyId);
    }

    /**
     * Store a newly created review for a property.
     *
     * @param StoreReviewRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReviewRequest $request)
    {
        return $this->reviewService->storeReview($request->validated());
    }

    /**
     * Display the specified review.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->reviewService->showReview($id);
    }

    /**
     * Update the specified review.
     *
     * @param UpdateReviewRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        return $this->reviewService->updateReview($request->validated(), $id);
    }

    /**
     * Delete the specified review.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->reviewService->deleteReview($id);
    }
}
