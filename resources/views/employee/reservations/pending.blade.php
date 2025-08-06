@extends('layouts')

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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Change Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reservations as $reservation)
            <tr>
              <td class="text-sm">{{ $reservation->id }}</td>
              <td class="text-sm">{{ $reservation->property->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->user->name ?? '-' }}</td>
              <td class="text-sm">{{ $reservation->date }} {{ $reservation->time }}</td>
              <td>
                @if($reservation->status == 'pending')
                  <span class="badge bg-warning text-dark text-sm">Pending</span>
                @elseif($reservation->status == 'confirmed')
                  <span class="badge bg-success text-sm">Confirmed</span>
                @elseif($reservation->status == 'cancelled')
                  <span class="badge bg-danger text-sm">Cancelled</span>
                @else
                  <span class="badge bg-secondary text-sm">{{ ucfirst($reservation->status) }}</span>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('employee.reservations.updateStatus', $reservation->id) }}">
                  @csrf
                  @method('PATCH')
                  <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted">No pending reservations found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
