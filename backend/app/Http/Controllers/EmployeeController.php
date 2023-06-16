<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    public function index()
    {

        $employees = Employee::all();
        return response([
            'message' => 'Employees found!',
            'data' => EmployeeResource::collection($employees)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'other_name' => 'nullable|string',
            'email' => 'required|string|email|unique:employees,email',
            'mobile_contact' => 'required|numeric',
            'home_contact' => 'nullable|numeric',
            'dob' => 'required|date',
            'joining_date' => 'required|date',
            'next_of_kin' => 'required|string',
            'next_of_kin_contact' => 'required|string'
        ]);

        $employee = Employee::create([
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'other_name' => $data['other_name'],
            'email' => $data['email'],
            'mobile_contact' => $data['mobile_contact'],
            'home_contact' => $data['home_contact'],
            'dob' => $data['dob'],
            'joining_date' => $data['joining_date'],
            'next_of_kin' => $data['next_of_kin'],
            'next_of_kin_contact' => $data['next_of_kin_contact']
        ]);

        return response([
            'message' => 'Employee Created!',
            'data' =>  new EmployeeResource($employee)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employee = Employee::findOrFail($id);
        return response([
            'message' => 'Employee found!',
            'data' => new EmployeeResource($employee)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'other_name' => 'nullable|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'mobile_contact' => 'required|numeric',
            'home_contact' => 'nullable|numeric',
            'dob' => 'required|date',
            'joining_date' => 'required|date',
            'next_of_kin' => 'required|string',
            'next_of_kin_contact' => 'required|string'
        ]);


        $employee = Employee::findOrFail($id);


        $employee->update([
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'other_name' => $data['other_name'],
            'email' => $data['email'],
            'mobile_contact' => $data['mobile_contact'],
            'home_contact' => $data['home_contact'],
            'dob' => $data['dob'],
            'joining_date' => $data['joining_date'],
            'next_of_kin' => $data['next_of_kin'],
            'next_of_kin_contact' => $data['next_of_kin_contact']
        ]);

        return response([
            'message' => 'Employee updated successfully!',
            'data' => new EmployeeResource($employee)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return response([
            'message' => 'Employee deleted successfully!',
            'data' => new EmployeeResource($employee)
        ], 200);
    }
}
