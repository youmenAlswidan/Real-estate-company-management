<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ReservationService;
use App\Traits\Admin\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\Employee\UpdateReservationStatusRequest;

/**
 * Handles reservation management for employees (viewing and updating statuses).
 */
class ReservationManagementController extends Controller
{
    use ResponseTrait;

    protected $reservationService;

    /**
     * Inject the ReservationService to handle reservation logic.
     *
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a list of all pending reservations for the employee.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = $this->reservationService->getPendingReservations();

        return view('employee.reservations.pending', compact('reservations'));
    }

    /**
     * Display a list of all confirmed reservations.
     *
     * @return \Illuminate\View\View
     */
    public function indexConfirmed()
    {
        $reservations = $this->reservationService->getConfirmedReservations();
        return view('employee.reservations.confirmed', compact('reservations'));
    }

    /**
     * Display a list of all cancelled reservations.
     *
     * @return \Illuminate\View\View
     */
    public function indexCancelled()
    {
        $reservations = $this->reservationService->getCancelledReservations();
        return view('employee.reservations.cancelled', compact('reservations'));
    }

    /**
     * Update the status of a specific reservation.
     *
     * @param UpdateReservationStatusRequest $request
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(UpdateReservationStatusRequest $request, Reservation $reservation)
    {
        $updated = $this->reservationService->updateReservationStatus($reservation, $request->status);

        if ($updated) {
            // Success response with redirect to pending reservations
            return $this->successResponse('Reservation status updated successfully.', 'employee.reservations.pending');
        } else {
            // Error response with redirect to pending reservations
            return $this->errorResponse('Failed to update reservation status.', 'employee.reservations.pending');
        }
    }
}
