<x-app-layout>
    <x-card>
        <x-slot:header>Data Departemen</x-slot:header>

        <div class="mb-5">
            <x-button class="btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-departemen">Tambah Data</x-button>
        </div>

        <table id="table" class="table table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Departemen</th>
                    <th class="text-center">Aksi</th>
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
                url : "{{ url('master-data/departemen/list') }}",
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
                {data: 'nama_departemen', class: 'text-nowrap'},
                {data: 'aksi', render: function(data, type, row) {
                    return `<div class="d-flex justify-content-center" style="gap: 8px;">
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}" data-nama-departemen="${row.nama_departemen}">Ubah</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                    </div>`;
                }}
            ],
            order: [[1, 'asc']],
        }).columns.adjust();
        // end datatable
    }

    function deleteDepartemen(id) {
        $.ajax({
            url: "{{ url('master-data/departemen') }}" + "/" + id,
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
                    deleteDepartemen(id);
                }
            }).catch(swal.noop);
        });

    });
</script>
@endpush

@push('modal')
@include('master-data.departemen.modal-add')
@include('master-data.departemen.modal-edit')
@endpush
</x-app-layout>
