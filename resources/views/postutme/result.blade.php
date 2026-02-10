@extends('layouts.app')

@section('title', 'Post-UTME Result')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-file-alt"></i> Post-UTME Result</h4>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="downloadAsPDF()">
                            <i class="fas fa-download"></i> Download PDF
                        </button>
                        <a href="{{ route('postutme.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th width="30%">Registration Number:</th><td>{{ $postUtmeResult->post_utme_reg_number }}</td></tr>
                        <tr><th>Post-UTME Score:</th><td><span class="badge bg-primary fs-6">{{ $postUtmeResult->post_utme_score }}</span></td></tr>
                        <tr><th>Course:</th><td>{{ $postUtmeResult->course->name }} ({{ $postUtmeResult->course->faculty->code }})</td></tr>
                        <tr><th>Exam Year:</th><td>{{ $postUtmeResult->exam_year }}</td></tr>
                        <tr><th>JAMB Registration:</th><td>{{ $postUtmeResult->jambResult->jamb_reg_number }}</td></tr>
                        <tr><th>Submitted:</th><td>{{ $postUtmeResult->created_at->format('F d, Y h:i A') }}</td></tr>
                    </table>
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

