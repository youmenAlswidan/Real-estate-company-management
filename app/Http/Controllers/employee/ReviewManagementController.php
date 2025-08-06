<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ReviewService;
use App\Traits\Admin\ResponseTrait;

class ReviewManagementController extends Controller
{
    use ResponseTrait;

    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index()
    {
        $reviews = $this->reviewService->getAllReviews();
        return view('employee.reviews.index', compact('reviews'));
    }
}


