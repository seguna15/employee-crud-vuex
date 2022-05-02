<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * * Function to get data of employees
     * 
     */

     public function index()
     {

        return view('employee.index');
     }

    public function create()
    {
        $data = [
            'scope' => 'create',
        ];
        return view('employee.form')->with($data);
    }

    public function storeEmployee(Request $request)
    {
        try{

            $employee = new Employee;
            $employee->name = $request->name;
            $employee->department = $request->department;
            $employee->section = $request->section;
            $employee->email = $request->email;
            $employee->save();

            return response()->json([
                'status' => 200,
                'message' => 'Employee added successfully',
            ]);

        }catch(Exception $e){
            dd($e);
        }
    }

    /**
     * * Getting all employees for list page
     * 
     */

    public function getEmployeeData(Request $request)
    {
        try{
            $query = Employee::select('id','name','department','section','email');

            if($request->searchQuery){
                $query->where(function($q) use ($request){
                    $q->orWhere('name', 'like', '%'.$request->searchQuery.'%');
                });
            }

            $employeeData = $query->get();
            return $employeeData; 

            return Employee::all();

        }catch(Exception $e){
            
            dd($e);

        }
    }

    /**
     * 
     * Edit page
     */
    public function edit($id)
    {
        $data = [
            'scope' => 'edit',
            'id' => $id,
        ];

        return view('employee.form')->with($data);
    }

    /**
     * * Get single employee data by id.
     */
    public function getEmployeeDataById($id)
    {
        $employeeData =  Employee::find($id);

        return response()->json([
            'status' => 200,
            'data' => $employeeData,
        ]);
    }

    /**
     * * Updating each employee
     */
    public function update(Request $request, $id)
    {
        try{
            $employee =  Employee::find($id);
                       
            $employee->name = $request->name;
            $employee->department = $request->department;
            $employee->section = $request->section;
            $employee->email = $request->email;
            $employee->update();

            return response()->json([
                'status' => 200,
                'message' => 'Employee updated successfully',
            ]);

        }catch(Exception $e){

            dd($e);

        }
    }

    /**
     * * Function for showing employee
     */

    public function show($id)
    {
        $data = [
            'scope' => 'show',
            'id' => $id,
        ];

        return view('employee.form')->with($data);
    }

    /**
     * * Function to delete employee
     */
    public function destroy($id){

        try{

            $employee = Employee::find($id);
            $employee->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Employee deleted successfully',
            ]);

        }catch(Exception $e){

            dd($e);
        }
        
    }
    
}
