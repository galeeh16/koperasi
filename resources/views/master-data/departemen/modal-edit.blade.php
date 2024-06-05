<x-modal id="modal-edit-departemen">
    <x-slot:header>Form Ubah Departemen</x-slot:header>

    <form method="post" id="form-edit-departemen" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">
        <div class="mb-3">
            <x-label for="nama_departemen_edit">Nama Departemen</x-label>
            <x-input-text id="nama_departemen_edit" name="nama_departemen_edit"></x-input-text>
        </div>

        <div class="mt-3 d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetEditForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function resetEditForm() {
        $('#form-edit-departemen')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function editDepartemen(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('master-data/departemen') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                nama_departemen: $('#nama_departemen_edit').val()
            },
            success: function(response) {
                showAlertSuccess(response.message);
                resetEditForm();
                modalEdit.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError();
            }
        });
    }

    $(document).ready(function() {
        let modalEdit = new bootstrap.Modal('#modal-edit-departemen', {
            backdrop: 'static'
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let namaDepartemen = $(this).data('nama-departemen');

            $('#id_edit').val(id);
            $('#nama_departemen_edit').val(namaDepartemen);

            modalEdit.show();
        });

        $('#form-edit-departemen').validate({
            submitHandler: function(form) {
                editDepartemen(modalEdit);
            },
            rules: {
                nama_departemen_edit: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
