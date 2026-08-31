<x-laporan.layout :title="'Laporan Daftar Aset'">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>SN?</th>
                <th>Stok</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->code }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->category }}</td>
                <td>{{ $row->has_serial_number ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ $row->unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-laporan.layout>