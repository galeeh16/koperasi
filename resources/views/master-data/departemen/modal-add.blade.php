<x-modal id="modal-add-departemen">
    <x-slot:header>Form Tambah Departemen</x-slot:header>

    <form method="post" id="form-add-departemen" spellcheck="false">
        @csrf
        <div class="mb-3">
            <x-label for="nama_departemen">Nama Departemen</x-label>
            <x-input-text id="nama_departemen" name="nama_departemen"></x-input-text>
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
        $('#form-add-departemen')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function addDepartemen(modalAdd) {
        $.ajax({
            url: "{{ url('master-data/departemen') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                nama_departemen: $('#nama_departemen').val()
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
        let modalAdd = new bootstrap.Modal('#modal-add-departemen', {
            backdrop: 'static'
        });

        $('#form-add-departemen').validate({
            submitHandler: function(form) {
                addDepartemen(modalAdd);
            },
            rules: {
                nama_departemen: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
