@extends('admin.layouts')

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header pb-0">
      <h6>Pending Reservations</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Property</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reservations as $reservation)
            <tr>
              <td class="text-sm">{{ $reservation->id }}</td>
              <td class="text-sm">{{ $reservation->property->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->user->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
              <td>
                <span class="badge bg-warning text-dark text-sm">Pending</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted">No pending reservations found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
