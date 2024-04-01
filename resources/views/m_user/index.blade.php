@extends('layouts.app') <!-- Assuming 'layouts.app' is your preferred theme/template -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title mb-0">User Management</h2>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Level ID</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($useri as $m_user)
                            <tr>
                                <td>{{ $m_user->user_id }}</td>
                                <td>{{ $m_user->level_id }}</td>
                                <td>{{ $m_user->username }}</td>
                                <td>{{ $m_user->nama }}</td>
                                <td>{{ $m_user->password }}</td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('m_user.destroy', $m_user->user_id) }}" method="POST">
                                            <a class="btn btn-info btn-sm" href="{{ route('m_user.show', $m_user->user_id) }}">Show</a>
                                            <a class="btn btn-primary btn-sm" href="{{ route('m_user.edit', $m_user->user_id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <a href="{{ route('m_user.create') }}" class="btn btn-success">Add User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
