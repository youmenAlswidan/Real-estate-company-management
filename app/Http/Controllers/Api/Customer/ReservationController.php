<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Resources\Customer\ReservationResource;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Traits\Customer\AuthTrait;
use App\Services\Customer\ReservationService;

/**
 * Handles reservation operations for customers via API.
 */
class ReservationController extends Controller
{
    use AuthTrait;

    // Service handling reservation business logic
    protected $reservation_service;

    /**
     * Inject the ReservationService into the controller.
     *
     * @param ReservationService $reservation_service
     */
    public function __construct(ReservationService $reservation_service)
    {
        $this->reservation_service = $reservation_service;
    }

    /**
     * Display a list of reservations for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->reservation_service->getAllReservation();
    }

    /**
     * Store a newly created reservation.
     *
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReservationRequest $request)
    {
        return $this->reservation_service->storeReservation($request->validated());
    }

    /**
     * Display the specified reservation details.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->reservation_service->showReservation($id);
    }

    /**
     * Update the specified reservation.
     *
     * @param UpdateReservationRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReservationRequest $request, $id)
    {
        return $this->reservation_service->updateReservation($request->validated(), $id);
    }

    /**
     * Delete the specified reservation.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->reservation_service->deleteReservation($id);
    }
}
