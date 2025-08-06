<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreReviewRequest;
use App\Http\Resources\Customer\ReviewResource;
use App\Models\Property;
use App\Models\Review;
use App\Services\Customer\ReviewService;
use App\Traits\Customer\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{


    use ApiResponseTrait;

    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

  public function index($propertyId)
{

    $property = Property::find($propertyId);
    $reviews = Review::where('property_id', $propertyId)->latest()->get();

    return $this->successResponse(ReviewResource::collection($reviews), 'Property Reviews');
}



    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $review = $this->reviewService->storeReview($data);
        return $this->successResponse(new ReviewResource($review), 'Review created successfully', 201);
    }

    public function show(Review $review)
{

    return $this->successResponse(new ReviewResource($review), 'Review details');
}

    public function update(StoreReviewRequest $request, Review $review)
    {
        if ($review->user_id != Auth::id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $data = $request->validated();
        $review = $this->reviewService->updateReview($review, $data);

        return $this->successResponse(new ReviewResource($review), 'Review updated successfully');
    }


    public function destroy(Review $review)
    {
        if ($review->user_id != Auth::id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $this->reviewService->deleteReview($review);
        return $this->successResponse(null, 'Review deleted successfully');
    }
}
