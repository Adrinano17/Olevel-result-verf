@extends('layouts.app')

@section('title', 'Admission Validation Result')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-check-circle"></i> Admission Validation Result</h4>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="downloadAsPDF()">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                        <a href="{{ route('admission.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-{{ $validation->overall_eligible ? 'success' : 'danger' }}">
                        <h5 class="alert-heading">
                            <i class="fas fa-{{ $validation->overall_eligible ? 'check-circle' : 'times-circle' }}"></i>
                            {{ $validation->overall_eligible ? 'Eligible for Admission' : 'Not Eligible for Admission' }}
                        </h5>
                        <p class="mb-0">Course: <strong>{{ $validation->course->name }}</strong> ({{ $validation->course->faculty->code }})</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card {{ $validation->jamb_valid ? 'border-success' : 'border-danger' }}">
                                <div class="card-body">
                                    <h6>JAMB Validation</h6>
                                    <span class="badge bg-{{ $validation->jamb_valid ? 'success' : 'danger' }}">
                                        {{ $validation->jamb_valid ? 'PASSED' : 'FAILED' }}
                                    </span>
                                    @if($validation->jamb_validation_details)
                                        <p class="mt-2 small">{{ $validation->jamb_validation_details['summary'] ?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $validation->olevel_valid ? 'border-success' : 'border-danger' }}">
                                <div class="card-body">
                                    <h6>O-Level Validation</h6>
                                    <span class="badge bg-{{ $validation->olevel_valid ? 'success' : 'danger' }}">
                                        {{ $validation->olevel_valid ? 'PASSED' : 'FAILED' }}
                                    </span>
                                    @if($validation->olevel_validation_details)
                                        <p class="mt-2 small">{{ $validation->olevel_validation_details['summary'] ?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $validation->post_utme_valid === true ? 'border-success' : ($validation->post_utme_valid === false ? 'border-danger' : 'border-secondary') }}">
                                <div class="card-body">
                                    <h6>Post-UTME Validation</h6>
                                    @if($validation->post_utme_valid === null)
                                        <span class="badge bg-secondary">NOT PROVIDED</span>
                                    @else
                                        <span class="badge bg-{{ $validation->post_utme_valid ? 'success' : 'danger' }}">
                                            {{ $validation->post_utme_valid ? 'PASSED' : 'FAILED' }}
                                        </span>
                                        @if($validation->post_utme_validation_details)
                                            <p class="mt-2 small">{{ $validation->post_utme_validation_details['summary'] ?? '' }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($validation->rejection_reasons)
                        <div class="alert alert-danger">
                            <h6>Rejection Reasons:</h6>
                            <ul>
                                @foreach($validation->rejection_reasons as $reason)
                                    <li><strong>{{ $reason['category'] }}:</strong> {{ $reason['reason'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-muted small">
                        <i class="fas fa-clock"></i> Validated at: {{ $validation->validated_at->format('F d, Y h:i A') }}
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
    .badge {
        border: 1px solid #000;
        padding: 2px 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    function downloadAsPDF() {
        window.print();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const cardBody = document.querySelector('.card-body');
        if (cardBody) {
            cardBody.closest('.card').classList.add('printable-area');
        }
    });
</script>
@endpush
@endsection

