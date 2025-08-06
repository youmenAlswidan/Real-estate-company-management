@extends('layouts')

@section('content')
<div class="container-fluid py-4">

  
  <div class="card">
    <div class="card-header pb-0">
      <h6>Cancelled Reservations</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Property</th>
              <th>Customer</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reservations as $reservation)
            <tr>
              <td class="text-sm">{{ $reservation->id }}</td>
              <td class="text-sm">{{ $reservation->property->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->user->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->date }} {{ $reservation->time }}</td>
              <td><span class="badge bg-danger text-sm">Cancelled</span></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted">No cancelled reservations found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
