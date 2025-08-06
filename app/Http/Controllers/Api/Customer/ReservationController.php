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

    public function store(StoreReservationRequest $request)
    {
        return $this->reservation_service->storeReservation($request->validated());
    }


    public function show($id)
    {
        return  $this->reservation_service->showReservation($id);
    }


    public function update(UpdateReservationRequest $request, $id)
    {

       return $this->reservation_service->updateReservation($request->validated(), $id);
    }


    public function destroy($id)
    {
        return  $this->reservation_service->deleteReservation($id);
    }
}
