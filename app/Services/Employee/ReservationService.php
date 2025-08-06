<?php
namespace App\Services\Employee;

use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationService
{
    /**
     * Retrieve all reservations with status 'pending' including related property and user data,
     * ordered by latest.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingReservations()
    {
        return Reservation::where('status', 'pending')
            ->with('property', 'user')
            ->latest()
            ->get();
    }
 /**
     * Retrieve all reservations with status 'confirmed' including related property and user data,
     * ordered by latest.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConfirmedReservations()
{
    return Reservation::where('status', 'confirmed')
        ->with('property', 'user')
        ->latest()
        ->get();
}
/**
     * Retrieve all reservations with status 'cancelled' including related property and user data,
     * ordered by latest.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
public function getCancelledReservations()
{
    return Reservation::where('status', 'cancelled')
        ->with('property', 'user')
        ->latest()
        ->get();
}

    /**
     * Update the status of a given reservation and send an email notification to the user.
     *
     * @param Reservation $reservation The reservation instance to update.
     * @param string $status The new status to set (e.g., 'confirmed', 'cancelled').
     * @return bool Returns true on success, false on failure.
     */

    public function updateReservationStatus(Reservation $reservation, string $status)
    {
        try {
            $reservation->status = $status;
            $reservation->save();

            Mail::raw(
                "Hello  {$reservation->user->name}،Your reservation status has been updated to: {$status}.",
                function ($message) use ($reservation) {
                    $message->to($reservation->user->email)
                        ->subject('Reservation Status Update');
                }
            );

            return true; 
        } catch (\Throwable $e) {
            
            \Log::error('Error updating reservation status: ' . $e->getMessage());
            return false;
        }
    }
}
