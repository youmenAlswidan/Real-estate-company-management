@extends('layouts')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table table-hover align-items-center mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">user</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">properity</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">rating</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td class="text-sm">{{ $review->user->name ?? '-' }}</td>
                                <td class="text-sm">{{ $review->property->name ?? '-' }}</td>
                                <td class="text-sm">
                                    <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                </td>
                                <td class="text-sm">{{ $review->comment }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">no rating gound now</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
