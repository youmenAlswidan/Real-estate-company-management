<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ReviewService;
use App\Traits\Admin\ResponseTrait;

/**
 * Controller responsible for managing customer reviews by employees.
 */
class ReviewManagementController extends Controller
{
    use ResponseTrait;

    protected $reviewService;

    /**
     * Inject the ReviewService to handle business logic for reviews.
     *
     * @param ReviewService $reviewService
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Display a list of all customer reviews.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all reviews through the service layer
        $reviews = $this->reviewService->getAllReviews();

        // Return the view with the list of reviews
        return view('employee.reviews.index', compact('reviews'));
    }
}
