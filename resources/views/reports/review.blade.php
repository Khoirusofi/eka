<x-print-layout>
    @section('title', 'Laporan Data Kritik dan Saran - ' . config('app.name'))
    <p>{{ __('Laporan Data Kritik dan Saran') . ' ' . config('app.name') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Kritik Saran') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Testimoni') }}</th>
                <th>{{ __('Jawaban') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $review->created_at->format('d F Y') }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->body }}</td>
                    <td>{{ $review->status }}</td>
                    <td>{{ $review->action }}</td>
                    <td>{{ $review->respond }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
