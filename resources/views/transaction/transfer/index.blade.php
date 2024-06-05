<x-app-layout>
    <x-card>
        <x-slot:header>Data Transfer</x-slot:header>

        <div class="mb-5">
            <x-button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-transfer">Tambah Data</x-button>
        </div>

        <table id="table" class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center text-nowrap">No</th>
                    <th class="text-center text-nowrap">Kode Transaksi</th>
                    <th class="text-center text-nowrap">Tanggal Transaksi</th>
                    <th class="text-center text-nowrap">Jumlah</th>
                    <th class="text-center text-nowrap">Keterangan</th>
                    <th class="text-center text-nowrap">Dari Kas</th>
                    <th class="text-center text-nowrap">Untuk Kas</th>
                    <th class="text-center text-nowrap">User</th>
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
            language: {
                searchPlaceholder: 'Cari kode transaksi...'
            },
            ajax: {
                url : "{{ url('transactions/transfer/list') }}",
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
                { data: 'no', orderable: false, class: 'text-center', render: function (data, type, row, meta) {
	                return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'kode_transaksi', class: 'text-nowrap' },
                { data: 'tanggal_transaksi', class: 'text-nowrap' },
                { data: 'jumlah', class: 'text-nowrap', render: function(data, type, row) {
                    return rupiah(row.jumlah)
                }},
                { data: 'keterangan', class: 'text-nowrap' },
                { data: 'data_kas_id', class: 'text-nowrap', render: function(dat, type, row) {
                    return row.dari_kas?.nama_kas;
                }},
                { data: 'untuk_kas_id', class: 'text-nowrap', render: function(dat, type, row) {
                    return row.untuk_kas?.nama_kas;
                }},
                { data: 'user_id', class: 'text-nowrap', render: function(dat, type, row) {
                    return row.user?.name;
                }},
                { data: 'aksi', render: function(data, type, row) {
                    return `<div class="d-flex justify-content-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}">Ubah</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                    </div>`;
                }}
            ],
            order: [[1, 'asc']],
        }).columns.adjust();
        // end datatable
    }

    function deleteTransfer(id) {
        $.ajax({
            url: "{{ url('transactions/transfer') }}" + "/" + id,
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

        // btn delete onclick handler
        $(document).on('click', '.btn-delete', function() {
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
                    deleteTransfer(id);
                }
            }).catch(swal.noop);
        });

    });
</script>
@endpush

@push('modal')
@include('transaction.transfer.modal-add')
@include('transaction.transfer.modal-edit')
@endpush
</x-app-layout>
