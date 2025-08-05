<?php
namespace App\Services\Admin;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Property;
use App\Models\Reservation;

class ReportService {

    /**
     * Get the total number of properties in the system.
     *
     * @return int|\Illuminate\Support\Collection  Total property count, or empty collection on failure.
     */
    public function getTotalProperties(){
        try{
            return Property::count();
        } catch(Exception $e) {
            Log::error('Error fetching Total Properties: ' . $e->getMessage());
            return collect();
        }
    }

    /**
    * Get the top 5 most requested properties based on reservation count.
     *
    * @return \Illuminate\Support\Collection  Collection of properties with highest reservation count, or empty collection on failure.
    */
    public function getMostRequestedProperties(){
        try{
            return Property::withCount('reservations')->orderByDesc('reservations_count')->take(5)->get();
        } catch(Exception $e) {
            Log::error('Error fetching Most Requested Properties ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get the start date based on a given period.
     *
     * Supported periods:
     * - daily   => start of today
     * - weekly  => start of the current week
     * - monthly => start of the current month
     *
     * @param string $period  The period to calculate start date for ('daily', 'weekly', 'monthly').
     * @return \Carbon\Carbon|\Illuminate\Support\Collection  Start date as Carbon instance, or empty collection on failure.
     */
    public function getStartDateByPeriod($period) {
        try{
        return match($period) {
            'daily' => Carbon::now()->startOfDay(),
            'weekly' => Carbon::now()->startOfWeek(),
            'monthly' => Carbon::now()->startOfMonth(),
            default => Carbon::now()->startOfDay(),
        };  
        } catch(Exception $e) {
            Log::error('Error fetching Start Date By Period' . $e->getMessage());
            return collect();
        }
    }

    
    /**
     * Get reservation statistics starting from a given date.
     *
     * Returns an array containing:
     * - reservationInPeriod: Number of reservations created after or on the given start date.
     * - confirmedReservations: Total number of confirmed reservations.
     * - cancelledReservations: Total number of cancelled reservations.
     *
     * @param \Carbon\Carbon|string $startDate  The start date for filtering reservations.
     * @return array<string, int>|\Illuminate\Support\Collection  Array of reservation stats or empty collection on failure.
     */
    public function getReservationStatus($startDate) {
        try{
            return [
            'reservationInPeriod' => Reservation::where('created_at', '>=' , $startDate)->count(),
            'confirmedReservations' => Reservation::where('status' , 'confirmed')->count(),
            'cancelledReservations' => Reservation::where('status' , 'cancelled')->count(),
        ]; 
        } catch(Exception $e) {
            Log::error('Error fetching Reservation Status' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get the latest 7 reservations with their associated users and properties.
     *
     * This method retrieves the most recent reservations,
     * including related property and user data using eager loading.
     *
     * @return \Illuminate\Support\Collection  Collection of Reservation models or empty collection on failure.
     */
    public function getLatestReservationWithUsers(){
        try{
            return Reservation::with(['property','user'])->latest()->take(7)->get();
        } catch(Exception $e) {
            Log::error('Error fetching Reservation with Users' . $e->getMessage());
            return collect();
    }
    }
}