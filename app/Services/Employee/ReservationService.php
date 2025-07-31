<?php
namespace App\Services\Employee;

use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationService
{
    public function getPendingReservations()
    {
        return Reservation::where('status', 'pending')
            ->with('property', 'user')
            ->latest()
            ->get();
    }

    public function updateReservationStatus(Reservation $reservation, string $status)
    {
        try {
            $reservation->status = $status;
            $reservation->save();

            Mail::raw(
                "مرحبًا {$reservation->user->name}،\n\nتم تحديث حالة الحجز الخاص بك إلى: {$status}.",
                function ($message) use ($reservation) {
                    $message->to($reservation->user->email)
                        ->subject('تحديث حالة الحجز');
                }
            );

            return true;  // أو ترجع الـ reservation لو حابب
        } catch (\Throwable $e) {
            // ممكن تسجل الخطأ لو حابب
            \Log::error('Error updating reservation status: ' . $e->getMessage());
            return false;
        }
    }
}
