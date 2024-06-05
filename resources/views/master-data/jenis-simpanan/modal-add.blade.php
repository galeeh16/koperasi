<x-modal id="modal-add-jenis-simpanan">
    <x-slot:header>Form Tambah Jenis Simpanan</x-slot:header>

    <form method="post" id="form-add-jenis-simpanan" spellcheck="false">
        @csrf
        <div class="mb-3">
            <x-label for="jenis_simpanan">Jenis Simpanan</x-label>
            <x-input-text name="jenis_simpanan" id="jenis_simpanan" />
        </div>
        <div class="mb-3">
            <x-label for="jumlah">Jumlah</x-label>
            <x-input-text name="jumlah" id="jumlah"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="tampil">Tampil</x-label>
            <x-input-select id="tampil" name="tampil">
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
        function clearAddForm() {
            $('#form-add-jenis-simpanan')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.error.text-danger').remove();
        }

        function addJenisSimpanan(modalAdd) {
            $.ajax({
                url: "{{ url('master-data/jenis-simpanan') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                data: {
                    jenis_simpanan: $('#jenis_simpanan').val(),
                    jumlah: $('#jumlah').val(),
                    tampil: $('#tampil').val(),
                },
                success: function(response) {
                    modalAdd.hide();
                    showAlertSuccess(response.message);
                    getData();
                    clearAddForm();
                },
                error: function(xhr) {
                    showAlertError(xhr.responseJSON?.message);
                }
            });
        }

        $(document).ready(function() {

            $('#tampil').select2({
                minimumResultsForSearch: -1,
                dropdownParent: $('#modal-add-jenis-simpanan')
            });

            let modalAdd = new bootstrap.Modal('#modal-add-jenis-simpanan', {
                backdrop: 'static'
            });

            $('#form-add-jenis-simpanan').validate({
                submitHandler: function(form) {
                    addJenisSimpanan(modalAdd);
                },
                rules: {
                    jenis_simpanan: {
                        required: true
                    },
                    jumlah: {
                        required: true
                    },
                    tampil: {
                        required: true
                    },
                }
            });

        });
    </script>
@endpush
