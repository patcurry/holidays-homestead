<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;


use Datetime;
use App\CustomClass\DateTools;

class EmployeeController extends Controller
{

    public function showAllEmployees()
    {
        return response()->json(Employee::all());
    }

    public function showOneEmployee($id)
    {
        return response()->json(Employee::find($id));
    }

    public function create(Request $request)
    {
        $employee = Employee::create($request->all());

        return response()->json($employee, 201);
    }

    public function update($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json($employee, 200);
    }

    public function delete($id)
    {
        Employee::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function addOneHoliday($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->increment('holidays', 1);

        return response()->json($employee, 200);
    }

    public function subtractOneHoliday($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->decrement('holidays', 1);

        return response()->json($employee, 200);
    }

    public function addHolidays($id, $days, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->increment('holidays', $days);

        return response()->json($employee, 200);
    }

    public function subtractHolidays($id, $days, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->decrement('holidays', $days);

        return response()->json($employee, 200);
    }

    public function takeVacation($id, Request $request)
    {

        // make new DateTools class
        $dt = new DateTools;

        // get employee
        $employee = Employee::findOrFail($id);

        // get holiday dates from the request
        // calculate the number of work days between the dates
        $days = $dt->WorkDays($request->from, $request->to);

        // subtract work days from paid holidays, the holidays field
        $employee->decrement('holidays', $days);

        return response()->json($employee, 200);

    }

}
