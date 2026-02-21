@extends('layouts.app')

@section('title', 'All Student Profiles - Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-users"></i> All Student Profiles
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($profiles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profiles as $profile)
                                        <tr>
                                            <td>{{ $profiles->firstItem() + $loop->index }}</td>
                                            <td>
                                                <strong>{{ $profile->full_name }}</strong>
                                            </td>
                                            <td>{{ $profile->user->email }}</td>
                                            <td>{{ $profile->phone_number ?? 'N/A' }}</td>
                                            <td>{{ $profile->state_of_origin ?? 'N/A' }}</td>
                                            <td>{{ $profile->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('student-profile.show', $profile->id) }}" 
                                                   class="btn btn-sm btn-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('student-profile.edit', $profile->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $profiles->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No student profiles found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

