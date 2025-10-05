@extends('layouts.app')
@section('content')
    <h1>Add New Employee</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <h3>Login Information</h3>
        <label for="name">Username:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <hr>

        <h3>Personal Information</h3>
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br>

        <label for="department_id">Department:</label><br>
        <select name="department_id" id="department_id" required>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select><br>

        <label for="position_id">Position:</label><br>
        <select name="position_id" id="position_id" required>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
            @endforeach
        </select><br>

        <label for="date_of_birth">Date of Birth:</label><br>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br>

        <label for="gender">Gender:</label><br>
        <input type="text" id="gender" name="gender" required><br>

        <label for="hire_date">Hire Date:</label><br>
        <input type="date" id="hire_date" name="hire_date" required><br>

        <button type="submit">Save Employee</button>
    </form>
@endsection
