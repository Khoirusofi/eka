<x-print-layout>
    @section('title', 'Laporan Data Artikel - ' . config('app.name'))
    <p>{{ __('Laporan Data Artikel') . ' ' . config('app.name') }}
    </p>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="bg-[#3e6553] text-white p-2 text-left">No</th>
                <th class="bg-[#3e6553] text-white p-2 text-left">Tanggal Dibuat</th>
                <th class="bg-[#3e6553] text-white p-2 text-left">Judul</th>
                <th class="bg-[#3e6553] text-white p-2 text-left">Status</th>
                <th class="bg-[#3e6553] text-white p-2 text-left">Dilihat</th>
                <th class="bg-[#3e6553] text-white p-2 text-left">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr class="border-b border-[#eee]">
                    <td>{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $article->created_at->translatedFormat('d F Y') }}</td>
                    <td class="p-2">{{ $article->title }}</td>
                    <td class="p-2">{{ $article->status }}</td>
                    <td class="p-2">{{ $article->views }}</td>
                    <td class="p-2">{{ $article->excerpt }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
