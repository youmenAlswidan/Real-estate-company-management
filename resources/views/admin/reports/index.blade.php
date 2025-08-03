@extends('layouts')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-center text-primary">📊 Statistics on Properties & Reservations</h3>

    <!-- Properties count -->
    <div class="alert alert-info text-center fw-bold">
        🏠 Total Properties: {{ $totalProperties }}
    </div>

    <!-- Most requested properties -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white fw-semibold">
            🔝 Most Requested Properties for Reservations
        </div>
        <ul class="list-group list-group-flush">
            @foreach($mostRequestedProperties as $property)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $property->name }}
                    <span class="badge bg-primary rounded-pill">{{ $property->reservations_count }} Reservations</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Reservations with customer names -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            🧾 Recent Reservations with Customer Info
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>🏠 Property</th>
                        <th>👤 Customer</th>
                        <th>📅 Reservation Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservationWithUsers as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->property->name ?? 'Unavailable' }}</td>
                            <td>{{ $reservation->user->name ?? 'Undefined' }}</td>
                            <td>{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>  
        </div>
    </div>

    <!-- Reservation period form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            ⏱ Filter Reservations by Period
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="period" class="col-form-label">Select Period:</label>
                </div>
                <div class="col-auto">
                    <select name="period" id="period" class="form-select" onchange="this.form.submit()">
                        <option value="daily" {{ request('period') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>
                <div class="col-auto">
                    <span class="badge bg-info text-dark"> {{ $reservationInPeriod }} Reservations</span>
                </div>
            </form>
        </div>
    </div>

    <!-- Reservation status -->
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-semibold">
            📌 Reservation Status Overview
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">✅ Confirmed Reservations: <strong>{{ $confirmedReservations }}</strong></li>
            <li class="list-group-item">❌ Cancelled Reservations: <strong>{{ $cancelledReservations }}</strong></li>
        </ul>
    </div>

</div>

<a href="{{ route('admin.properties.index') }}" class="btn btn-secondary mt-3">Back</a>

@endsection