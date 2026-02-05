@extends('layouts.app')

@section('title', 'Verify O-Level Result')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-certificate"></i> O-Level Result Verification
                    </h4>
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

                    <form method="POST" action="{{ route('verification.submit') }}" id="verificationForm">
                        @csrf

                        <div class="mb-3">
                            <label for="exam_number" class="form-label">
                                <strong>Exam Number <span class="text-danger">*</span></strong>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('exam_number') is-invalid @enderror" 
                                id="exam_number" 
                                name="exam_number" 
                                value="{{ old('exam_number') }}" 
                                placeholder="e.g., 12345678901"
                                required
                                autofocus
                            >
                            @error('exam_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Enter your examination number</small>
                        </div>

                        <div class="mb-3">
                            <label for="exam_year" class="form-label">
                                <strong>Examination Year <span class="text-danger">*</span></strong>
                            </label>
                            <select 
                                class="form-select @error('exam_year') is-invalid @enderror" 
                                id="exam_year" 
                                name="exam_year" 
                                required
                            >
                                <option value="">Select Year</option>
                                @for($year = date('Y'); $year >= 2000; $year--)
                                    <option value="{{ $year }}" {{ old('exam_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('exam_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exam_body" class="form-label">
                                <strong>Examination Body <span class="text-danger">*</span></strong>
                            </label>
                            <select 
                                class="form-select @error('exam_body') is-invalid @enderror" 
                                id="exam_body" 
                                name="exam_body" 
                                required
                            >
                                <option value="">Select Examination Body</option>
                                <option value="WAEC" {{ old('exam_body') == 'WAEC' ? 'selected' : '' }}>
                                    WAEC (West African Examinations Council)
                                </option>
                                <option value="NECO" {{ old('exam_body') == 'NECO' ? 'selected' : '' }}>
                                    NECO (National Examinations Council)
                                </option>
                            </select>
                            @error('exam_body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="result_type" class="form-label">
                                <strong>Result Type <span class="text-danger">*</span></strong>
                            </label>
                            <select 
                                class="form-select @error('result_type') is-invalid @enderror" 
                                id="result_type" 
                                name="result_type" 
                                required
                            >
                                <option value="">Select Result Type</option>
                                <option value="SSCE" {{ old('result_type') == 'SSCE' ? 'selected' : '' }}>
                                    SSCE (Senior School Certificate Examination)
                                </option>
                                <option value="GCE" {{ old('result_type') == 'GCE' ? 'selected' : '' }}>
                                    GCE (General Certificate Examination)
                                </option>
                                <option value="MAY/JUN" {{ old('result_type') == 'MAY/JUN' ? 'selected' : '' }}>
                                    MAY/JUN
                                </option>
                                <option value="NOV/DEC" {{ old('result_type') == 'NOV/DEC' ? 'selected' : '' }}>
                                    NOV/DEC
                                </option>
                            </select>
                            @error('result_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-search"></i> Verify Result
                            </button>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ route('verification.history') }}" class="text-decoration-none">
                                <i class="fas fa-history"></i> View Verification History
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i> Important Information
                    </h5>
                    <ul class="mb-0">
                        <li>Ensure all information is correct before submitting</li>
                        <li>Verification may take a few seconds</li>
                        <li>Results are verified directly from examination body databases</li>
                        <li>All verification requests are logged for security purposes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('verificationForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Verifying...';
    });
</script>
@endpush
@endsection


