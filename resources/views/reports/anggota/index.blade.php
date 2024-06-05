<x-app-layout>
    <x-card>
        <x-slot:header>Laporan Anggota</x-slot:header>

        <div class="mb-5 d-flex gap-2 align-items-center">
            <x-button class="btn-success" id="btn-export-excel">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M12 15.575q-.2 0-.375-.062T11.3 15.3l-3.6-3.6q-.3-.3-.288-.7t.288-.7q.3-.3.713-.312t.712.287L11 12.15V5q0-.425.288-.712T12 4t.713.288T13 5v7.15l1.875-1.875q.3-.3.713-.288t.712.313q.275.3.288.7t-.288.7l-3.6 3.6q-.15.15-.325.213t-.375.062M6 20q-.825 0-1.412-.587T4 18v-2q0-.425.288-.712T5 15t.713.288T6 16v2h12v-2q0-.425.288-.712T19 15t.713.288T20 16v2q0 .825-.587 1.413T18 20z"/></svg>
                Export Excel
            </x-button>
            <x-button class="btn-danger" id="btn-export-pdf">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M12 15.575q-.2 0-.375-.062T11.3 15.3l-3.6-3.6q-.3-.3-.288-.7t.288-.7q.3-.3.713-.312t.712.287L11 12.15V5q0-.425.288-.712T12 4t.713.288T13 5v7.15l1.875-1.875q.3-.3.713-.288t.712.313q.275.3.288.7t-.288.7l-3.6 3.6q-.15.15-.325.213t-.375.062M6 20q-.825 0-1.412-.587T4 18v-2q0-.425.288-.712T5 15t.713.288T6 16v2h12v-2q0-.425.288-.712T19 15t.713.288T20 16v2q0 .825-.587 1.413T18 20z"/></svg>
                Export PDF
            </x-button>
        </div>

        <table id="table" class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center text-nowrap">No</th>
                    <th class="text-center text-nowrap">Username</th>
                    <th class="text-center text-nowrap">No Anggota</th>
                    <th class="text-center text-nowrap">Nama Lengkap</th>
                    <th class="text-center text-nowrap">Jenis Kelamin</th>
                    <th class="text-center text-nowrap">Tempat Lahir</th>
                    <th class="text-center text-nowrap">Tanggal Lahir</th>
                    <th class="text-center text-nowrap">Status Menikah</th>
                    <th class="text-center text-nowrap">Departemen</th>
                    <th class="text-center text-nowrap">Pekerjaan</th>
                    <th class="text-center text-nowrap">Agama</th>
                    <th class="text-center text-nowrap">Alamat</th>
                    <th class="text-center text-nowrap">Kota</th>
                    <th class="text-center text-nowrap">No Handphone</th>
                    <th class="text-center text-nowrap">Aktif Keanggotaan</th>
                    <th class="text-center text-nowrap">Status Peminjaman</th>
                    <th class="text-center text-nowrap">Created At</th>
                    <th class="text-center text-nowrap">Updated At</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </x-card>

    @push('script')
    <script>
        function getData() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ordering: false,
                deferRender: true,
                scrollX: true,
                scrollY: '500px',
                scrollCollapse: true,
                searchDelay: 300,
                ajax: {
                    url : "{{ url('/master-data/anggota/list') }}",
                    type: 'post',
                    data : function(d) {
                        return {
                            ...d,
                            page: parseInt( $('#table').DataTable().page.info().page + 1),
                            // search: $('input[name=search]').val()
                        }
                    }
                },
                columns: [
                    {data: 'no', orderable: false, class: 'text-center', render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                    { data: 'username', class: 'text-nowrap' },
                    { data: 'no_anggota', class: 'text-nowrap' },
                    { data: 'nama_lengkap', class: 'text-nowrap' },
                    { data: 'jenis_kelamin', class: 'text-nowrap', render: function(data, type, row) {
                        return row.jenis_kelamin === 'l' ? 'Laki - Laki' : 'Perempuan';
                    }},
                    { data: 'tempat_lahir', class: 'text-nowrap' },
                    { data: 'tanggal_lahir', class: 'text-nowrap', render: function(data, type, row) {
                        return row.tanggal_lahir ? dateFormat(row.tanggal_lahir) : '';
                    }},
                    { data: 'status_menikah', class: 'text-nowrap', render: function(data, type, row) {
                        return row.status_menikah ? row.status_menikah?.nama_status : '';
                    }},
                    { data: 'departemen', class: 'text-nowrap', render: function(data, type, row) {
                        return row.departemen ? row.departemen?.nama_departemen : '';
                    }},
                    { data: 'pekerjaan', class: 'text-nowrap', render: function(data, type, row) {
                        return row.pekerjaan ? row.pekerjaan?.nama_pekerjaan : '';
                    }},
                    { data: 'agama', class: 'text-nowrap', render: function(data, type, row) {
                        return row.agama ? row.agama?.nama_agama : '';
                    }},
                    { data: 'alamat', class: 'text-nowrap' },
                    { data: 'kota', class: 'text-nowrap' },
                    { data: 'no_hp', class: 'text-nowrap' },
                    { data: 'aktif_keanggotaan', class: 'text-nowrap' },
                    { data: 'status_peminjaman', class: 'text-nowrap' },
                    { data: 'created_at', class: 'text-nowrap', render: function(data, type, row) {
                        return dateFormatTime(row.created_at);
                    }},
                    { data: 'updated_at', class: 'text-nowrap', render: function(data, type, row) {
                        return dateFormatTime(row.updated_at);
                    }},
                ],
                order: [[1, 'asc']],
                // lengthMenu: [[1, 3, 10, 15, 30, 50], [1, 3, 10, 15, 30, 50]],
                // sDom: '<"pull-left"><"pull-right"f>rt<"row"<"col-md-2 mt-2"l><"col-md-6"i><"col-md-4"p>>',
            }).columns.adjust();
            // end datatable
        }


        $(document).ready(function() {
            getData();

            $('#btn-export-excel').on('click', function() {
                downloadFile("{{ url('reports/anggota/export-excel') }}", null);
            });

            $('#btn-export-pdf').on('click', function() {
                downloadFile("{{ url('reports/anggota/export-pdf') }}", null);
            });
        });
    </script>
@endpush

</x-app-layout>
