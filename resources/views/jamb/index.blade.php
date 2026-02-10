@extends('layouts.app')

@section('title', 'JAMB Result Submission')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap"></i> JAMB Result Submission
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

                    <form method="POST" action="{{ route('jamb.submit') }}" id="jambForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jamb_reg_number" class="form-label">
                                    <strong>JAMB Registration Number <span class="text-danger">*</span></strong>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('jamb_reg_number') is-invalid @enderror" 
                                    id="jamb_reg_number" 
                                    name="jamb_reg_number" 
                                    value="{{ old('jamb_reg_number') }}" 
                                    placeholder="e.g., 12345678AB"
                                    required
                                    autofocus
                                >
                                @error('jamb_reg_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="jamb_score" class="form-label">
                                    <strong>JAMB Score <span class="text-danger">*</span></strong>
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control @error('jamb_score') is-invalid @enderror" 
                                    id="jamb_score" 
                                    name="jamb_score" 
                                    value="{{ old('jamb_score') }}" 
                                    min="0"
                                    max="400"
                                    required
                                >
                                @error('jamb_score')
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
                            <label class="form-label">
                                <strong>JAMB Subjects (4 subjects) <span class="text-danger">*</span></strong>
                            </label>
                            <div id="subjectsContainer">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                name="subjects[{{ $i }}][subject]" 
                                                placeholder="Subject name (e.g., Mathematics)"
                                                value="{{ old("subjects.$i.subject") }}"
                                                required
                                            >
                                        </div>
                                        <div class="col-md-6">
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                name="subjects[{{ $i }}][score]" 
                                                placeholder="Score (0-100)"
                                                value="{{ old("subjects.$i.score") }}"
                                                min="0"
                                                max="100"
                                                required
                                            >
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            @error('subjects')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="first_choice_course_id" class="form-label">
                                    <strong>First Choice Course <span class="text-danger">*</span></strong>
                                </label>
                                <select 
                                    class="form-select @error('first_choice_course_id') is-invalid @enderror" 
                                    id="first_choice_course_id" 
                                    name="first_choice_course_id" 
                                    required
                                >
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('first_choice_course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->faculty->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('first_choice_course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="second_choice_course_id" class="form-label">
                                    <strong>Second Choice Course</strong>
                                </label>
                                <select 
                                    class="form-select @error('second_choice_course_id') is-invalid @enderror" 
                                    id="second_choice_course_id" 
                                    name="second_choice_course_id"
                                >
                                    <option value="">Select Course (Optional)</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('second_choice_course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->faculty->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('second_choice_course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="third_choice_course_id" class="form-label">
                                    <strong>Third Choice Course</strong>
                                </label>
                                <select 
                                    class="form-select @error('third_choice_course_id') is-invalid @enderror" 
                                    id="third_choice_course_id" 
                                    name="third_choice_course_id"
                                >
                                    <option value="">Select Course (Optional)</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('third_choice_course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->faculty->code }} - {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('third_choice_course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-save"></i> Submit JAMB Result
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($jambResults->count() > 0)
            <div class="card mt-4 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Previous JAMB Results</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Registration Number</th>
                                    <th>Score</th>
                                    <th>Year</th>
                                    <th>First Choice</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jambResults as $result)
                                    <tr>
                                        <td>{{ $result->jamb_reg_number }}</td>
                                        <td><span class="badge bg-info">{{ $result->jamb_score }}</span></td>
                                        <td>{{ $result->exam_year }}</td>
                                        <td>{{ $result->firstChoiceCourse->name ?? 'N/A' }}</td>
                                        <td>{{ $result->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('jamb.result', $result->id) }}" class="btn btn-sm btn-primary">
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
    document.getElementById('jambForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Submitting...';
    });
</script>
@endpush
@endsection



