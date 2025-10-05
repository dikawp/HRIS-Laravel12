@extends('layouts.app')
@section('content')
    <h1>Employee List</h1>
    <a href="{{ route('employees.create') }}">Add New Employee</a>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Position</th>
                <th>Hire Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->full_name }}</td>
                    <td>{{ $employee->user->email }}</td>
                    <td>{{ $employee->department->name }}</td>
                    <td>{{ $employee->position->name }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    <td>
                        <a href="#">Edit</a>
                        <a href="#">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
