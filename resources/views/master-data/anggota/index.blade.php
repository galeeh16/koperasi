<x-app-layout>
    <x-card>
        <x-slot:header>Data Anggota</x-slot:header>

        <div class="mb-5">
            <x-button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-anggota">Tambah Data</x-button>
        </div>

        <table id="table" class="table table-bordered" style="width: 100%; hidden">
            <thead>
                <tr>
                    <th class="text-center text-nowrap">No</th>
                    <th class="text-center text-nowrap">Username</th>
                    <th class="text-center text-nowrap">No Anggota</th>
                    <th class="text-center text-nowrap">Nama Lengkap</th>
                    <th class="text-center text-nowrap">Tanggal Registrasi</th>
                    <th class="text-center text-nowrap">Jenis Kelamin</th>
                    <th class="text-center text-nowrap">Tempat Lahir</th>
                    <th class="text-center text-nowrap">Tanggal Lahir</th>
                    <th class="text-center text-nowrap">Bersihkan</th>
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
                    <th class="text-center text-nowrap">Aksi</th>
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
                { data: 'tanggal_registrasi', class: 'text-nowrap', render: function(data, type, row) {
                    return row.tanggal_registrasi ? dateFormatTime(row.tanggal_registrasi) : '';
                }},
                { data: 'jenis_kelamin', class: 'text-nowrap', render: function(data, type, row) {
                    return row.jenis_kelamin === 'l' ? 'Laki - Laki' : 'Perempuan';
                }},
                { data: 'tempat_lahir', class: 'text-nowrap' },
                { data: 'tanggal_lahir', class: 'text-nowrap', render: function(data, type, row) {
                    return dateFormat(row.tanggal_lahir);
                }},
                { data: 'bersihkan', class: 'text-nowrap' },
                { data: 'status_menikah', class: 'text-nowrap', render: function(data, type, row) {
                    return row.status_menikah?.nama_status;
                }},
                { data: 'departemen', class: 'text-nowrap', render: function(data, type, row) {
                    return row.departemen?.nama_departemen;
                }},
                { data: 'pekerjaan', class: 'text-nowrap', render: function(data, type, row) {
                    return row.pekerjaan?.nama_pekerjaan;
                }},
                { data: 'agama', class: 'text-nowrap', render: function(data, type, row) {
                    return row.agama?.nama_agama;
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
                {data: 'aksi', render: function(data, type, row) {
                    return `<div class="d-flex justify-content-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}">Ubah</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                    </div>`;
                }}
            ],
            order: [[1, 'asc']],
            // lengthMenu: [[1, 3, 10, 15, 30, 50], [1, 3, 10, 15, 30, 50]],
            // sDom: '<"pull-left"><"pull-right"f>rt<"row"<"col-md-2 mt-2"l><"col-md-6"i><"col-md-4"p>>',
        }).columns.adjust();
        // end datatable
    }

    function deleteAnggota(id) {
        $.ajax({
            url: "{{ url('master-data/anggota') }}" + '/' + id,
            type: 'delete',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
                showAlertSuccess(response.message);
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {
        getData();

        $('#date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '-80:+0',
            onClose: function(dateText, inst) {
                dateObject = $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay, 1));
            }
        })

        // btn delete handler
        $(document).on('click', '.btn-delete', function(e) {
            let id = $(this).data('id');

            Swal.fire({
                title: "",
                text: "Apakah anda yakin?",
                icon: "warning",
                showCancelButton: true,
                // confirmButtonColor: "#3085d6",
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(res => {
                if (res.isConfirmed) {
                    deleteAnggota(id);
                }
            }).catch(swal.noop);
        });

    });
</script>
@endpush

@push('modal')
@include('master-data.anggota.modal-add')
@include('master-data.anggota.modal-edit')
@endpush
</x-app-layout>
