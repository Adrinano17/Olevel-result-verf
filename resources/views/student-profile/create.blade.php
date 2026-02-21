@extends('layouts.app')

@section('title', 'Create Student Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i> Create Student Profile
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student-profile.store') }}" id="profileForm">
                        @csrf

                        <h5 class="mb-3 text-primary"><i class="fas fa-user"></i> Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="first_name" class="form-label"><strong>First Name <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                    id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="middle_name" class="form-label"><strong>Middle Name</strong></label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                    id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="last_name" class="form-label"><strong>Last Name <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                    id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label"><strong>Date of Birth <span class="text-danger">*</span></strong></label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                    id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label"><strong>Gender <span class="text-danger">*</span></strong></label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone_number" class="form-label"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                    id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label"><strong>Address <span class="text-danger">*</span></strong></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="state_of_origin" class="form-label"><strong>State of Origin <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('state_of_origin') is-invalid @enderror" 
                                    id="state_of_origin" name="state_of_origin" value="{{ old('state_of_origin') }}" required>
                                @error('state_of_origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="local_government_area" class="form-label"><strong>Local Government Area <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('local_government_area') is-invalid @enderror" 
                                    id="local_government_area" name="local_government_area" value="{{ old('local_government_area') }}" required>
                                @error('local_government_area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nationality" class="form-label"><strong>Nationality</strong></label>
                                <input type="text" class="form-control @error('nationality') is-invalid @enderror" 
                                    id="nationality" name="nationality" value="{{ old('nationality', 'Nigerian') }}">
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 text-primary"><i class="fas fa-users"></i> Next of Kin Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_name" class="form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('next_of_kin_name') is-invalid @enderror" 
                                    id="next_of_kin_name" name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" required>
                                @error('next_of_kin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_phone" class="form-label"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('next_of_kin_phone') is-invalid @enderror" 
                                    id="next_of_kin_phone" name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" required>
                                @error('next_of_kin_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_relationship" class="form-label"><strong>Relationship <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('next_of_kin_relationship') is-invalid @enderror" 
                                    id="next_of_kin_relationship" name="next_of_kin_relationship" value="{{ old('next_of_kin_relationship') }}" 
                                    placeholder="e.g., Father, Mother, Brother" required>
                                @error('next_of_kin_relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="next_of_kin_address" class="form-label"><strong>Address <span class="text-danger">*</span></strong></label>
                                <textarea class="form-control @error('next_of_kin_address') is-invalid @enderror" 
                                    id="next_of_kin_address" name="next_of_kin_address" rows="2" required>{{ old('next_of_kin_address') }}</textarea>
                                @error('next_of_kin_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 text-primary"><i class="fas fa-phone-alt"></i> Emergency Contact Information (Optional)</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_name" class="form-label"><strong>Name</strong></label>
                                <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                    id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}">
                                @error('emergency_contact_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_phone" class="form-label"><strong>Phone Number</strong></label>
                                <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                    id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
                                @error('emergency_contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_relationship" class="form-label"><strong>Relationship</strong></label>
                                <input type="text" class="form-control @error('emergency_contact_relationship') is-invalid @enderror" 
                                    id="emergency_contact_relationship" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship') }}">
                                @error('emergency_contact_relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_address" class="form-label"><strong>Address</strong></label>
                                <textarea class="form-control @error('emergency_contact_address') is-invalid @enderror" 
                                    id="emergency_contact_address" name="emergency_contact_address" rows="2">{{ old('emergency_contact_address') }}</textarea>
                                @error('emergency_contact_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Save Profile
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

