<?php

namespace App\Services\Employee;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class EmployeeService
{
    public function getByID()
    {
        return User::role('employee')->get();
    }

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

    public function delete(User $employee)
    {
        try {
            return $employee->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
