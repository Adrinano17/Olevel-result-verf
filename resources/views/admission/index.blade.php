@extends('layouts.app')

@section('title', 'Admission Validation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-check-circle"></i> Admission Eligibility Validation</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($jambResults->count() == 0 || $olevelVerifications->count() == 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> You need to submit JAMB result and verify O-Level result first.
                            <div class="mt-2">
                                @if($jambResults->count() == 0)
                                    <a href="{{ route('jamb.index') }}" class="btn btn-sm btn-primary">Submit JAMB Result</a>
                                @endif
                                @if($olevelVerifications->count() == 0)
                                    <a href="{{ route('verification.index') }}" class="btn btn-sm btn-primary">Verify O-Level Result</a>
                                @endif
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('admission.validate') }}" id="validationForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jamb_result_id" class="form-label"><strong>JAMB Result <span class="text-danger">*</span></strong></label>
                                    <select class="form-select" id="jamb_result_id" name="jamb_result_id" required>
                                        <option value="">Select JAMB Result</option>
                                        @foreach($jambResults as $jamb)
                                            <option value="{{ $jamb->id }}">{{ $jamb->jamb_reg_number }} - Score: {{ $jamb->jamb_score }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="olevel_verification_id" class="form-label"><strong>O-Level Verification <span class="text-danger">*</span></strong></label>
                                    <select class="form-select" id="olevel_verification_id" name="olevel_verification_id" required>
                                        <option value="">Select O-Level Verification</option>
                                        @foreach($olevelVerifications as $verification)
                                            <option value="{{ $verification->id }}">
                                                {{ $verification->exam_body }} - {{ $verification->exam_number }} ({{ $verification->exam_year }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="course_id" class="form-label"><strong>Course <span class="text-danger">*</span></strong></label>
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->faculty->code }} - {{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                    <i class="fas fa-check-circle"></i> Validate Admission Eligibility
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            @if($validations->count() > 0)
            <div class="card mt-4 shadow-sm">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-history"></i> Validation History</h5></div>
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
                                        <td>{{ $validation->created_at->format('M d, Y') }}</td>
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
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('validationForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Validating...';
    });
</script>
@endpush
@endsection






