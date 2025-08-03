<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\ReportService;

/**
 * Class ReportController
 *
 * Handles reporting functionality for the admin panel,
 * including statistics on properties and reservations.
 *
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    protected $reportService;

    /**
     * ReportController constructor.
     *
     * Injects the ReportService used to gather reporting data.
     *
     * @param \App\Services\ReportService $reportService
     */
    public function __construct(ReportService $reportService ){
        $this->reportService=$reportService;
    }

    /**
     * Display the report dashboard for the admin panel.
     *
     * Retrieves various statistics including total properties, most requested properties,
     * reservation status, and latest reservations, based on the selected period.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $period=$request->input('period','daily');

        $startDate=$this->reportService->getStartDateByPeriod($period);

        $status=$this->reportService->getReservationStatus($startDate);

        return view('admin.reports.index',[
            'totalProperties' => $this->reportService->getTotalProperties(),
            'mostRequestedProperties' => $this->reportService->getMostRequestedProperties(),
            'reservationInPeriod' => $status['reservationInPeriod'],
            'confirmedReservations' => $status['confirmedReservations'],
            'cancelledReservations' => $status['cancelledReservations'],
            'period' => $period,
            'reservationWithUsers' => $this->reportService->getLatestReservationWithUsers(),
        ]);
    }
}
