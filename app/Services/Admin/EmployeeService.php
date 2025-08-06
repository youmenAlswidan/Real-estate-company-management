<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class EmployeeService
{
    /**
     * Get all users with the 'employee' role.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByID()
    {
        return User::role('employee')->get();
    }

    /**
     * Create and store a new employee user.
     *
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function store(array $data)
    {
        try {
            $employee = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $employee->assignRole('employee');

            return $employee;
        } catch (Exception $e) {
            
            throw $e;
        }
    }

    /**
     * Update an existing employee user.
     *
     * @param User $employee
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function update(User $employee, array $data)
    {
        try {
            $employee->name  = $data['name'];
            $employee->email = $data['email'];

            if (!empty($data['password'])) {
                $employee->password = Hash::make($data['password']);
            }

            $employee->save();

            return $employee;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete an employee user.
     *
     * @param User $employee
     * @return bool|null
     * @throws Exception
     */
    public function delete(User $employee)
    {
        try {
            return $employee->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
