@extends('layouts.app')

@section('title', 'Admission Validation History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-history"></i> Admission Validation History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Eligible</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($validations as $validation)
                                    <tr>
                                        <td>{{ $validation->course->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $validation->status_badge }}">
                                                {{ ucfirst(str_replace('_', ' ', $validation->validation_status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($validation->overall_eligible)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $validation->created_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('admission.result', $validation->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $validations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection






