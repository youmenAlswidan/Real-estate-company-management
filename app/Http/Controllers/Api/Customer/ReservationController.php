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

class ReservationController extends Controller
{
    use AuthTrait;
    protected $reservation_service;

    public function __construct(ReservationService $reservation_service){
        $this->reservation_service=$reservation_service;
    }

    public function index()
    {
        return $this->reservation_service->getAllReservation();        
    }

<<<<<<< HEAD
    public function store(StoreReservationRequest $request)
    {
        return $this->reservation_service->storeReservation($request->validated());
    }
=======
        $is_booked = Reservation::where('property_id', $data['property_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->exists();

        if ($is_booked) {
            return response()->json([
                'status' => false,
                'message' => 'The property is booking in this time'
            ], 409);
        }

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        $reservation = Reservation::create($data);

        return response()->json([
            'status' => true,
            'message' => 'The property is booking Successfully',
            'data' => new ReservationResource($reservation),
        ], 201);
>>>>>>> ali_last

    public function show($id)
    {
        return  $this->reservation_service->showReservation($id);
    }


    public function update(UpdateReservationRequest $request, $id)
    {
<<<<<<< HEAD
       return $this->reservation_service->updateReservation($request->validated(), $id);
=======
        $data = $request->validated();

        $reservation = auth()->user()->reservations()->findOrFail($id);

        // 🔒 منع التعديل إذا الحالة confirmed أو cancelled
        if (in_array($reservation->status, ['confirmed', 'cancelled'])) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot modify a reservation that is confirmed or cancelled.',
            ], 403);
        }

        // ⚠️ حالة reschedule: يسمح فقط بتعديل الوقت والتاريخ وليس العقار
        if ($reservation->status === 'reschedule' && $reservation->property_id != $data['property_id']) {
            return response()->json([
                'status' => false,
                'message' => 'You can only change the date and time in a reschedule request.',
            ], 403);
        }

        // 💥 تحقق من تعارض الموعد
        $is_booked = Reservation::where('property_id', $data['property_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->where('id', '!=', $reservation->id)
            ->exists();

        if ($is_booked) {
            return response()->json([
                'status' => false,
                'message' => 'The property is already booked at this time',
            ], 409);
        }

        $reservation->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Reservation updated successfully',
            'data' => new ReservationResource($reservation),
        ]);
>>>>>>> ali_last
    }


    public function destroy($id)
    {
<<<<<<< HEAD
        return  $this->reservation_service->deleteReservation($id);
=======
        $reservation = auth()->user()->reservations()->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return response()->json([
                'status' => false,
                'message' => 'You can only delete reservations that are still pending.',
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reservation deleted successfully',
        ]);
>>>>>>> ali_last
    }
}
