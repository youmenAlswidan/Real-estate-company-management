@extends('layouts')

@section('content')
    <h2>الملاحظات والتقييمات</h2>

    <table>
        <thead>
            <tr>
                <th>المستخدم</th>
                <th>العقار</th>
                <th>التقييم</th>
                <th>الملاحظة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->property->name }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
