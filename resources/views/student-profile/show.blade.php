@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm printable-area">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user"></i> Student Profile
                    </h4>
                    <div class="btn-group no-print" role="group">
                        <button type="button" class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        @if(Auth::user()->isAdmin() || $profile->user_id === Auth::id())
                            <a href="{{ route('student-profile.edit', $profile->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-12 text-center mb-4">
                            <h3 class="text-primary">{{ $profile->full_name }}</h3>
                            <p class="text-muted">Student Profile Information</p>
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary"><i class="fas fa-user"></i> Personal Information</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Full Name:</th>
                                <td>{{ $profile->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td>{{ $profile->date_of_birth ? $profile->date_of_birth->format('F d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>{{ ucfirst($profile->gender ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>{{ $profile->phone_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $profile->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>State of Origin:</th>
                                <td>{{ $profile->state_of_origin ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Local Government Area:</th>
                                <td>{{ $profile->local_government_area ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Nationality:</th>
                                <td>{{ $profile->nationality ?? 'Nigerian' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $profile->user->email ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3 text-primary"><i class="fas fa-users"></i> Next of Kin Information</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name:</th>
                                <td>{{ $profile->next_of_kin_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>{{ $profile->next_of_kin_phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Relationship:</th>
                                <td>{{ $profile->next_of_kin_relationship ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $profile->next_of_kin_address ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    @if($profile->emergency_contact_name)
                    <hr class="my-4">
                    <h5 class="mb-3 text-primary"><i class="fas fa-phone-alt"></i> Emergency Contact Information</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name:</th>
                                <td>{{ $profile->emergency_contact_name }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>{{ $profile->emergency_contact_phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Relationship:</th>
                                <td>{{ $profile->emergency_contact_relationship ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $profile->emergency_contact_address ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    @endif

                    <div class="mt-4 text-muted small">
                        <p><strong>Profile Created:</strong> {{ $profile->created_at->format('F d, Y h:i A') }}</p>
                        <p><strong>Last Updated:</strong> {{ $profile->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style media="print">
    @page {
        margin: 1cm;
        size: A4;
    }
    body * {
        visibility: hidden;
    }
    .printable-area, .printable-area * {
        visibility: visible;
    }
    .printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
    .card {
        border: none;
        box-shadow: none;
        page-break-inside: avoid;
    }
    .card-header .btn-group {
        display: none !important;
    }
    .table {
        border-collapse: collapse;
        width: 100%;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endpush
@endsection

