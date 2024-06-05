<x-app-layout>
    <x-card>
        <x-slot:header>Data Kas</x-slot:header>

        <div class="mb-5">
            <x-button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-data-kas">Tambah Data</x-button>
        </div>

        <table id="table" class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center text-nowrap">No</th>
                    <th class="text-center text-nowrap">Nama Kas</th>
                    <th class="text-center text-nowrap">Aktif</th>
                    <th class="text-center text-nowrap">Simpanan</th>
                    <th class="text-center text-nowrap">Penarikan</th>
                    <th class="text-center text-nowrap">Pinjaman</th>
                    <th class="text-center text-nowrap">Angsuran</th>
                    <th class="text-center text-nowrap">Pemasukan Kas</th>
                    <th class="text-center text-nowrap">Pengeluaran Kas</th>
                    <th class="text-center text-nowrap">Transfer Kas</th>
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
                url : "{{ url('master-data/data-kas/list') }}",
                type: 'post',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data : function(d) {
                    return {
                        ...d,
                        page: parseInt( $('#table').DataTable().page.info().page + 1)
                    }
                }
            },
            columns: [
                {data: 'no', orderable: false, class: 'text-center', render: function (data, type, row, meta) {
	                return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'nama_kas', class: 'text-nowrap' },
                { data: 'aktif', class: 'text-nowrap' },
                { data: 'simpanan', class: 'text-nowrap' },
                { data: 'penarikan', class: 'text-nowrap' },
                { data: 'pinjaman', class: 'text-nowrap' },
                { data: 'angsuran', class: 'text-nowrap' },
                { data: 'pemasukan_kas', class: 'text-nowrap' },
                { data: 'pengeluaran_kas', class: 'text-nowrap' },
                { data: 'transfer_kas', class: 'text-nowrap' },
                { data: 'created_at', class: 'text-nowrap', render: function(data, type, row) {
                    return dateFormatTime(row.created_at);
                }},
                { data: 'updated_at', class: 'text-nowrap', render: function(data, type, row) {
                    return dateFormatTime(row.updated_at);
                }},
                { data: 'aksi', render: function(data, type, row) {
                    return `<div class="d-flex justify-content-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-info btn-edit"
                            data-id="${ row.id }"
                            data-nama-kas="${ row.nama_kas }"
                            data-aktif="${ row.aktif }"
                            data-simpanan="${ row.simpanan }"
                            data-penarikan="${ row.penarikan }"
                            data-pinjaman="${ row.pinjaman }"
                            data-angsuran="${ row.angsuran }"
                            data-pemasukan-kas="${ row.pemasukan_kas }"
                            data-pengeluaran-kas="${ row.pengeluaran_kas }"
                            data-transfer-kas="${ row.transfer_kas }"
                        >Ubah</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                    </div>`;
                }}
            ],
            order: [[1, 'asc']],
        }).columns.adjust();
        // end datatable
    }

    function deleteDataKas(id) {
        $.ajax({
            url: "{{ url('master-data/data-kas') }}" + '/' + id,
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
                    deleteDataKas(id);
                }
            }).catch(swal.noop);
        });

    });
</script>
@endpush

@push('modal')
@include('master-data.data-kas.modal-add')
@include('master-data.data-kas.modal-edit')
@endpush
</x-app-layout>
