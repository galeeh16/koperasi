<table>
    <thead>
        <tr>
        <th>No</th>
        <th>Username</th>
        <th>No Anggota</th>
        <th>Nama Lengkap</th>
        <th>Tanggal Registrasi</th>
        <th>Jenis Kelamin</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Status Menikah</th>
        <th>Departemen</th>
        <th>Pekerjaan</th>
        <th>Agama</th>
        <th>Alamat</th>
        <th>Kota</th>
        <th>No Handphone</th>
        <th>Aktif Keanggotaan</th>
        <th>Status Peminjaman</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->username }}</td>
                <td>{{ $row->no_anggota }}&nbsp;</td>
                <td>{{ $row->nama_lengkap }}</td>
                <td>{{ date('d-m-Y H:i', strtotime($row->created_at)) }}</td>
                <td>{{ $row->jenis_kelamin }}</td>
                <td>{{ $row->tempat_lahir }}</td>
                <td>{{ $row->tanggal_lahir }}</td>
                <td>{{ $row->status_menikah }}</td>
                <td>{{ $row->departemen }}</td>
                <td>{{ $row->pekerjaan }}</td>
                <td>{{ $row->agama }}</td>
                <td>{{ $row->alamat }}</td>
                <td>{{ $row->kota }}</td>
                <td>{{ $row->no_hp }}</td>
                <td>{{ $row->aktif_keanggotaan }}</td>
                <td>{{ $row->status_peminjaman }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
