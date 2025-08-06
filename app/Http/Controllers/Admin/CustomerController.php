<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Get all users with 'customer' role
       $customers = User::role('customer', 'api')->latest()->paginate(10);


        return view('admin.customers.index', compact('customers'));
    }
}

