<x-modal id="modal-edit-pekerjaan">
    <x-slot:header>Form Ubah Pekerjaan</x-slot:header>

    <form method="post" id="form-edit-pekerjaan" spellcheck="false">
        @csrf
        <input type="hidden" name="id_edit" id="id_edit">
        <div class="mb-3">
            <x-label for="pekerjaan_edit">Pekerjaan</x-label>
            <x-input-text id="pekerjaan_edit" name="pekerjaan_edit"></x-input-text>
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
        $('#form-edit-pekerjaan')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function editPekerjaan(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('master-data/pekerjaan') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                pekerjaan: $('#pekerjaan_edit').val()
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
        let modalEdit = new bootstrap.Modal('#modal-edit-pekerjaan', {
            backdrop: 'static'
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let pekerjaan = $(this).data('pekerjaan');

            $('#id_edit').val(id);
            $('#pekerjaan_edit').val(pekerjaan);

            modalEdit.show();
        });

        $('#form-edit-pekerjaan').validate({
            submitHandler: function(form) {
                editPekerjaan(modalEdit);
            },
            rules: {
                pekerjaan_edit: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
