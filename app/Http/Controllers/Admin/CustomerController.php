<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     /**
     * Display a paginated list of customers in the admin dashboard.
     *
     * This method fetches users who have the 'customer' role
     * using the Spatie Permission package under the 'api' guard,
     * orders them by latest, and returns the view with the data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch users who have the 'customer' role under the 'api' guard
        // Sort them by newest first, and paginate the results (10 per page)
        
       $customers = User::role('customer', 'api')->latest()->paginate(10);

        // Return the view with the customers data
        // View path: resources/views/admin/customers/index.blade.php
        return view('admin.customers.index', compact('customers'));
    }
}

