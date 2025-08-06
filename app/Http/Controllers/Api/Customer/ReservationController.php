<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Resources\Customer\ReservationResource;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function index(){
        $reservations=auth()->user()->reservations()
        ->with('property')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => ReservationResource::collection($reservations),
        ]);
    }

    public function store(StoreReservationRequest $request){
        $data = $request->validated();

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

    }


    public function update(UpdateReservationRequest $request, $id)
    {
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
    }


    public function destroy($id)
    {
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
    }
}
