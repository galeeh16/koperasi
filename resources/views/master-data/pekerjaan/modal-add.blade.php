<x-modal id="modal-add-pekerjaan">
    <x-slot:header>Form Tambah Pekerjaan</x-slot:header>

    <form method="post" id="form-add-pekerjaan" spellcheck="false">
        <div class="mb-3">
            <x-label for="pekerjaan">Pekerjaan</x-label>
            <x-input-text id="pekerjaan" name="pekerjaan"></x-input-text>
        </div>

        <div class="mt-3 d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetAddForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function resetAddForm() {
        $('#form-add-pekerjaan')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function addPekerjaan(modalAdd) {
        $.ajax({
            url: "{{ url('master-data/pekerjaan') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                pekerjaan: $('#pekerjaan').val()
            },
            success: function(response) {
                showAlertSuccess(response.message);
                resetAddForm();
                modalAdd.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError();
            }
        });
    }

    $(document).ready(function() {
        let modalAdd = new bootstrap.Modal('#modal-add-pekerjaan', {
            backdrop: 'static'
        });

        $('#form-add-pekerjaan').validate({
            submitHandler: function(form) {
                addPekerjaan(modalAdd);
            },
            rules: {
                pekerjaan: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
