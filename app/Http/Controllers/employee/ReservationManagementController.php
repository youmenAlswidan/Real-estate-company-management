<?php
namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ReservationService;
use App\Traits\Admin\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationManagementController extends Controller
{
    use ResponseTrait;

    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $reservations = $this->reservationService->getPendingReservations();

        return view('employee.reservations.pending', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $updated = $this->reservationService->updateReservationStatus($reservation, $validated['status']);

        if ($updated) {
            return $this->successResponse('تم تحديث حالة الحجز بنجاح.','employee.reservations.pending');
        } else {
            return $this->errorResponse('فشل في تحديث حالة الحجز.', 'employee.reservations.pending');
        }
    }
}
