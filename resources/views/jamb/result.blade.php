@extends('layouts.app')

@section('title', 'JAMB Result')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap"></i> JAMB Result
                    </h4>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="downloadAsPDF()">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                        <a href="{{ route('jamb.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">JAMB Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Registration Number:</th>
                                    <td>{{ $jambResult->jamb_reg_number }}</td>
                                </tr>
                                <tr>
                                    <th>JAMB Score:</th>
                                    <td><span class="badge bg-primary fs-6">{{ $jambResult->jamb_score }}</span></td>
                                </tr>
                                <tr>
                                    <th>Exam Year:</th>
                                    <td>{{ $jambResult->exam_year }}</td>
                                </tr>
                                <tr>
                                    <th>Submitted:</th>
                                    <td>{{ $jambResult->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Course Choices</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">First Choice:</th>
                                    <td>{{ $jambResult->firstChoiceCourse->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Second Choice:</th>
                                    <td>{{ $jambResult->secondChoiceCourse->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Third Choice:</th>
                                    <td>{{ $jambResult->thirdChoiceCourse->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-book"></i> JAMB Subjects</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jambResult->subjects as $index => $subject)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $subject['subject'] }}</td>
                                            <td><span class="badge bg-info">{{ $subject['score'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

