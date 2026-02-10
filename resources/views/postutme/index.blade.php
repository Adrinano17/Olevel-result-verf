@extends('layouts.app')

@section('title', 'Post-UTME Result Submission')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt"></i> Post-UTME Result Submission
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

                    @if($jambResults->count() == 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> You need to submit a JAMB result first before submitting Post-UTME result.
                            <a href="{{ route('jamb.index') }}" class="alert-link">Submit JAMB Result</a>
                        </div>
                    @else
                        <form method="POST" action="{{ route('postutme.submit') }}" id="postUtmeForm">
                            @csrf

                            <div class="mb-3">
                                <label for="jamb_result_id" class="form-label">
                                    <strong>Select JAMB Result <span class="text-danger">*</span></strong>
                                </label>
                                <select 
                                    class="form-select @error('jamb_result_id') is-invalid @enderror" 
                                    id="jamb_result_id" 
                                    name="jamb_result_id" 
                                    required
                                >
                                    <option value="">Select JAMB Result</option>
                                    @foreach($jambResults as $jamb)
                                        <option value="{{ $jamb->id }}" {{ old('jamb_result_id') == $jamb->id ? 'selected' : '' }}>
                                            {{ $jamb->jamb_reg_number }} - Score: {{ $jamb->jamb_score }} ({{ $jamb->exam_year }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('jamb_result_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="post_utme_reg_number" class="form-label">
                                        <strong>Post-UTME Registration Number <span class="text-danger">*</span></strong>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('post_utme_reg_number') is-invalid @enderror" 
                                        id="post_utme_reg_number" 
                                        name="post_utme_reg_number" 
                                        value="{{ old('post_utme_reg_number') }}" 
                                        required
                                    >
                                    @error('post_utme_reg_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="post_utme_score" class="form-label">
                                        <strong>Post-UTME Score <span class="text-danger">*</span></strong>
                                    </label>
                                    <input 
                                        type="number" 
                                        class="form-control @error('post_utme_score') is-invalid @enderror" 
                                        id="post_utme_score" 
                                        name="post_utme_score" 
                                        value="{{ old('post_utme_score') }}" 
                                        min="0"
                                        max="100"
                                        required
                                    >
                                    @error('post_utme_score')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="exam_year" class="form-label">
                                        <strong>Exam Year <span class="text-danger">*</span></strong>
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
                            </div>

                            <div class="mb-3">
                                <label for="course_id" class="form-label">
                                    <strong>Course Applied For <span class="text-danger">*</span></strong>
                                </label>
                                <select 
                                    class="form-select @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id" 
                                    required
                                >
                                    <option value="">Select Course</option>
                                    @php
                                        $courses = \App\Models\Course::where('is_active', true)
                                            ->with('faculty')
                                            ->orderBy('faculty_id')
                                            ->orderBy('name')
                                            ->get();
                                    @endphp
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->faculty->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Course must be one of your JAMB course choices</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-save"></i> Submit Post-UTME Result
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            @if($postUtmeResults->count() > 0)
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Previous Post-UTME Results</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Registration Number</th>
                                    <th>Score</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($postUtmeResults as $result)
                                    <tr>
                                        <td>{{ $result->post_utme_reg_number }}</td>
                                        <td><span class="badge bg-info">{{ $result->post_utme_score }}</span></td>
                                        <td>{{ $result->course->name }}</td>
                                        <td>{{ $result->exam_year }}</td>
                                        <td>{{ $result->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('postutme.result', $result->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('postUtmeForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Submitting...';
    });
</script>
@endpush
@endsection



