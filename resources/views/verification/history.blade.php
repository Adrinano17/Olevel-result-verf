@extends('layouts.app')

@section('title', 'Verification History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-history"></i> Verification History
                    </h4>
                    <a href="{{ route('verification.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> New Verification
                    </a>
                </div>
                <div class="card-body">
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Exam Number</th>
                                        <th>Exam Body</th>
                                        <th>Year</th>
                                        <th>Result Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $index => $request)
                                        <tr>
                                            <td>{{ $requests->firstItem() + $index }}</td>
                                            <td>{{ $request->exam_number }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $request->exam_body }}</span>
                                            </td>
                                            <td>{{ $request->exam_year }}</td>
                                            <td>{{ $request->result_type }}</td>
                                            <td>
                                                @if($request->status === 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($request->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($request->status === 'timeout')
                                                    <span class="badge bg-danger">Timeout</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('verification.result', $request->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> No verification history found.
                            <a href="{{ route('verification.index') }}" class="alert-link">Start a new verification</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




