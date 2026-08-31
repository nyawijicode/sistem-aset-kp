<x-laporan.layout :title="'Laporan Aset Keluar'">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Qty</th>
                <th>Penerima</th>
                <th>Diinput Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->date->format('d/m/Y') }}</td>
                <td>{{ $row->asset->code }}</td>
                <td>{{ $row->asset->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ $row->recipient }}</td>
                <td>{{ $row->creator->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-laporan.layout>