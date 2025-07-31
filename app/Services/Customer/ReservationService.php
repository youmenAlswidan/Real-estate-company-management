<?php

namespace App\Services\Customer;
use App\Traits\Customer\ReservationTrait;
use App\Models\Reservation;
use App\Http\Resources\Customer\ReservationResource;

class ReservationService {
    use ReservationTrait;
    
    public function getAllReservation(){
        try {
            $reservations=auth()->user()->reservations()->with('property')->latest()->get();
            return $this->successResponse( ReservationResource::collection($reservations),'All Reservations');
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function storeReservation(array $data){
        try{
        $is_booked = Reservation::where('property_id', $data['property_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->exists();
    
        if ($is_booked) {
            return  $this->errorResponse('The property is booking in this time');
        }
    
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';
    
        $reservation = Reservation::create($data);
    
        return  $this->successResponse(new ReservationResource($reservation), 'Reservation Stored Successfully');
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function showReservation($id)
    {
        try{
        $reservation = auth()->user()->reservations()
        ->with('property')->findOrFail($id);
        return  $this->successResponse(new ReservationResource($reservation), 'Show One Reservation');
        } catch(\Throwable $e){
            return $this->errorResponse($e->getMessage());
        }
    }


    public function updateReservation(array $data , $id) {
    try {
        $reservation = auth()->user()->reservations()->findOrFail($id);
    
        if (in_array($reservation->status, ['confirmed'])) {
            return  $this->errorResponse('You cannot modify a reservation that is confirmed or cancelled.');
        }
    
        if ($reservation->status === 'cancelled' && $reservation->property_id != $data['property_id']) {
            return  $this->errorResponse('You can only change the date and time in a reschedule request.');
        }
    
        $is_booked = Reservation::where('property_id', $data['property_id'])
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->where('id', '!=', $reservation->id)
            ->exists();
    
        if ($is_booked) {
            return  $this->errorResponse('The property is already booked at this time');
        }

       
        $data['status'] = 'pending';

        $reservation->update($data);
        return  $this->successResponse(new ReservationResource($reservation), 'Update One Reservation');

    } catch(\Throwable $e){
        return $this->errorResponse($e->getMessage());
    }
}


     public function deleteReservation($id) {
        try {
            $reservation = auth()->user()->reservations()->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return $this->errorResponse('You can only delete reservations that are still pending.');
        }
        $reservation->delete();
        return $this->successResponse(null,'Reservation deleted Successfully');

        } catch(\Throwable $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}