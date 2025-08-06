<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\User;
use App\Services\Admin\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Service instance responsible for handling business logic
    protected $employeeService;

    /**
     * EmployeeController constructor.
     *
     * Apply middleware to restrict access to admin users only.
     * Inject the EmployeeService for employee-related operations.
     *
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        // Restrict access to users with 'admin' role
        $this->middleware(['role:admin']);

        // Assign the injected service to the controller property
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of all employees.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch employees using the service layer
        $employees = $this->employeeService->getByID();

        // Return the index view with employee data
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view for creating a new employee
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in the database.
     *
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request)
    {
        // Validate and store employee using the service
        $this->employeeService->store($request->validated());

        // Redirect to the employee list page
        return redirect()->route('admin.employees.index');
    }

    /**
     * Display the details of a specific employee.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        // Find employee by ID or throw 404 if not found
        $employee = User::findOrFail($id);

        // Return the show view with employee data
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find employee by ID or throw 404 if not found
        $employee = User::findOrFail($id);

        // Return the edit view with employee data
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     *
     * @param EmployeeRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeRequest $request, string $id)
    {
        // Find employee by ID or throw 404 if not found
        $employee = User::findOrFail($id);

        // Validate and update employee using the service
        $this->employeeService->update($employee, $request->validated());

        // Redirect with success message
        return redirect()->route('admin.employees.index')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find employee by ID or throw 404 if not found
        $employee = User::findOrFail($id);

        // Delete the employee using the service
        $this->employeeService->delete($employee);

        // Redirect with success message
        return redirect()->route('admin.employees.index')->with('success', 'Deleted Successfully!');
    }
}
