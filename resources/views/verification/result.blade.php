@extends('layouts.app')

@section('title', 'Verification Result')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt"></i> Verification Result
                    </h4>
                    <a href="{{ route('verification.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> New Verification
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Request Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Request Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Exam Number:</th>
                                    <td>{{ $verificationRequest->exam_number }}</td>
                                </tr>
                                <tr>
                                    <th>Exam Year:</th>
                                    <td>{{ $verificationRequest->exam_year }}</td>
                                </tr>
                                <tr>
                                    <th>Exam Body:</th>
                                    <td>
                                        <span class="badge bg-info">{{ $verificationRequest->exam_body }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Result Type:</th>
                                    <td>{{ $verificationRequest->result_type }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($verificationRequest->status === 'success')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($verificationRequest->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($verificationRequest->status === 'timeout')
                                            <span class="badge bg-danger">Timeout</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Request Date:</th>
                                    <td>{{ $verificationRequest->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Verification Result -->
                    @if($verificationRequest->verificationResult)
                        @php
                            $result = $verificationRequest->verificationResult;
                        @endphp

                        @if($result->isSuccessful())
                            <div class="alert alert-success">
                                <h5 class="alert-heading">
                                    <i class="fas fa-check-circle"></i> Verification Successful
                                </h5>
                                <p class="mb-0">{{ $result->response_message }}</p>
                            </div>

                            @if($result->candidate_name)
                                <div class="mb-4">
                                    <h5 class="text-primary">
                                        <i class="fas fa-user"></i> Candidate Information
                                    </h5>
                                    <p class="lead"><strong>Name:</strong> {{ $result->candidate_name }}</p>
                                </div>
                            @endif

                            @if($result->subjects && count($result->subjects) > 0)
                                <div class="mb-4">
                                    <h5 class="text-primary">
                                        <i class="fas fa-book"></i> Subject Results
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($result->subjects as $index => $subject)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $subject['subject'] }}</td>
                                                        <td>
                                                            <span class="badge bg-primary">{{ $subject['grade'] }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger">
                                <h5 class="alert-heading">
                                    <i class="fas fa-times-circle"></i> Verification Failed
                                </h5>
                                <p class="mb-0">
                                    <strong>Error Code:</strong> {{ $result->response_code }}<br>
                                    <strong>Message:</strong> {{ $result->response_message }}
                                </p>
                            </div>
                        @endif

                        @if($result->verified_at)
                            <div class="text-muted small">
                                <i class="fas fa-clock"></i> Verified at: {{ $result->verified_at->format('F d, Y h:i A') }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> No result available yet. Please wait...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




