<x-app-layout>
    <x-card>
        <x-slot:header>Jenis Simpanan</x-slot:header>

        <div class="mb-5">
            <x-button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-jenis-simpanan">Tambah Data</x-button>
        </div>

        <table class="table table-bordered responsive-datatable" style="width: 100%;" id="myTable">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Jenis Simpanan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Tampil</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center">Updated At</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

@push('script')
<script>
    function getData() {
        var table = $('#myTable').DataTable({
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
                url : "{{ url('/master-data/jenis-simpanan/list') }}",
                type: 'post',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data : function(d) {
                    return {
                        ...d,
                        page: parseInt( $('#myTable').DataTable().page.info().page + 1),
                        // search: $('input[name=search]').val()
                    }
                }
            },
            columns: [
                {data: 'no', orderable: false, class: 'text-center', render: function (data, type, row, meta) {
	                return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'nama_jenis_simpanan', class: 'text-nowrap'},
                {data: 'jumlah', class: 'text-nowrap', render: function(data, type, row) {
                    return rupiah(row.jumlah);
                }},
                {data: 'tampil', class: 'text-nowrap'},
                {data: 'created_at', class: 'text-nowrap', render: function(data, type, row) {
                    return dateFormatTime(row.created_at)
                }},
                {data: 'updated_at', class: 'text-nowrap', render: function(data, type, row) {
                    return dateFormatTime(row.updated_at)
                }},
                {data: 'aksi', render: function(data, type, row) {
                    return `<div class="d-flex justify-content-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}" data-jenis-simpanan="${row.nama_jenis_simpanan}" data-jumlah="${row.jumlah}" data-tampil="${row.tampil}">Ubah</button>
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

    function deleteJenisSimpanan(id) {
        $.ajax({
            url: "{{ url('master-data/jenis-simpanan') }}" + "/" + id,
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
                    deleteJenisSimpanan(id);
                }
            }).catch(swal.noop);
        });

    });
</script>
@endpush


@push('modal')
@include('master-data.jenis-simpanan.modal-add')
@include('master-data.jenis-simpanan.modal-edit')
@endpush
</x-app-layout>
