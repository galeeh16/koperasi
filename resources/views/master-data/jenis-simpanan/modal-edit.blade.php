<x-modal id="modal-edit-jenis-simpanan">
    <x-slot:header>Form Ubah Jenis Simpanan</x-slot:header>

    <form method="post" id="form-edit-jenis-simpanan" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">
        <div class="mb-3">
            <x-label for="jenis_simpanan_edit">Jenis Simpanan</x-label>
            <x-input-text name="jenis_simpanan_edit" id="jenis_simpanan_edit" />
        </div>
        <div class="mb-3">
            <x-label for="jumlah_edit">Jumlah</x-label>
            <x-input-text name="jumlah_edit" id="jumlah_edit"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="tampil_edit">Tampil</x-label>
            <x-input-select id="tampil_edit" name="tampil_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button class="btn-light" data-bs-dismiss="modal">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function clearEditForm() {
        $('#form-edit-jenis-simpanan')[0].reset();
    }

    function editJenisSimpanan(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('master-data/jenis-simpanan') }}" + "/" + id,
            type: 'put',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: {
                jenis_simpanan: $('#jenis_simpanan_edit').val(),
                jumlah: $('#jumlah_edit').val(),
                tampil: $('#tampil_edit').val(),
            },
            success: function(response) {
                modalEdit.hide();
                showAlertSuccess(response.message);
                getData();
                clearEditForm();
            },
            error: function(xhr) {
                console.log(xhr)
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {
        let modalEdit = new bootstrap.Modal('#modal-edit-jenis-simpanan', {
            backdrop: 'static'
        });

        $('#tampil_edit').select2({
            minimumResultsForSearch: -1,
            dropdownParent: $('#modal-edit-jenis-simpanan')
        });

        // btn edit handler
        $(document).on('click', '.btn-edit', function() {
            $('#id_edit').val($(this).data('id'));
            $('#jenis_simpanan_edit').val($(this).data('jenis-simpanan'));
            $('#jumlah_edit').val($(this).data('jumlah'));
            $('#tampil_edit').val($(this).data('tampil'));

            modalEdit.show();
        });

        $('#form-edit-jenis-simpanan').validate({
            submitHandler: function(form) {
                Swal.fire({
                    title: "",
                    text: "Apakah anda yakin?",
                    icon: "warning",
                    showCancelButton: true,
                    // confirmButtonColor: "#3085d6",
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Batal'
                }).then(res => {
                    if (res.isConfirmed) {
                        editJenisSimpanan(modalEdit);
                    }
                }).catch(swal.noop);
            },
            rules: {
                jenis_simpanan_edit: {
                    required: true
                },
                jumlah_edit: {
                    required: true
                },
                tampil_edit: {
                    required: true
                },
            }
        });

    });
</script>
@endpush
