@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </h4>
                </div>
                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="mb-4">
                        <i class="fas fa-check-circle text-success"></i> You are logged in!
                    </h5>
                    
                    <p class="lead mb-4">Welcome to O-Level Result Verification System</p>
                    
                    <div class="d-grid gap-2 col-md-6 mx-auto">
                        <a href="{{ route('verification.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i> Verify Result
                        </a>
                        <a href="{{ route('verification.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history"></i> View Verification History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
