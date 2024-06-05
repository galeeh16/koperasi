<x-modal id="modal-edit-anggota" size="xl">
    <x-slot:header>Form Ubah Anggota</x-slot:header>

    <form id="form-edit-anggota" method="post" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <x-label for="username_edit">Username</x-label>
                    <x-input-text id="username_edit" name="username_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="nama_lengkap_edit">Nama Lengkap</x-label>
                    <x-input-text id="nama_lengkap_edit" name="nama_lengkap_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="jenis_kelamin_edit">Jenis Kelamin</x-label>
                    <x-input-select id="jenis_kelamin_edit" name="jenis_kelamin_edit" data-minimum-results-for-search="-1">
                        <option value="l">Laki - Laki</option>
                        <option value="p">Perempuan</option>
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="tempat_lahir_edit">Tempat Lahir</x-label>
                    <x-input-text id="tempat_lahir_edit" name="tempat_lahir_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="tanggal_lahir_edit">Tanggal Lahir</x-label>
                    <x-input-text id="tanggal_lahir_edit" name="tanggal_lahir_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="status_menikah_edit">Status Menikah</x-label>
                    <x-input-select id="status_menikah_edit" name="status_menikah_edit">
                        @foreach ($status_menikah as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_status }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="departemen_edit">Departemen</x-label>
                    <x-input-select id="departemen_edit" name="departemen">
                        @foreach ($departemen as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_departemen }}</option>
                        @endforeach
                    </x-input-select>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <x-label for="pekerjaan_edit">Pekerjaan</x-label>
                    <x-input-select id="pekerjaan_edit" name="pekerjaan_edit">
                        @foreach ($pekerjaan as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_pekerjaan }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="agama_edit">Agama</x-label>
                    <x-input-select id="agama_edit" name="agama_edit">
                        @foreach ($agama as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_agama }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="alamat_edit" :required="false">Alamat</x-label>
                    <x-input-text id="alamat_edit" name="alamat_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="kota_edit" :required="false">Kota</x-label>
                    <x-input-text id="kota_edit" name="kota_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="no_hp_edit" :required="false">No Handphone</x-label>
                    <x-input-text id="no_hp_edit" name="no_hp_edit"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="photo_edit" :required="false">Photo <span class="text-muted">(.jpg, .jpeg, .png)</span></x-label>
                    <x-input-text type="file" id="photo_edit" name="photo_edit" accept="image/*"></x-input-text>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetFormEdit()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script src="{{ asset('assets/external/jquery-validation/additional-methods.js') }}"></script>
<script>
    function resetFormEdit() {
        $('#form-edit-anggota')[0].reset();
        $('#jenis_kelamin_edit').val('l').trigger('change');
        $('#status_menikah_edit').val('1').trigger('change');
        $('#departemen_edit').val('1').trigger('change');
        $('#pekerjaan_edit').val('1').trigger('change');
        $('#agama_edit').val('1').trigger('change');
        $('.error').remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    function findAnggotaByID(id, modalEdit) {
        $.ajax({
            url: "{{ url('master-data/anggota') }}" + '/' + id,
            type: 'get',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
                $('#id_edit').val(response.data.id);
                $('#username_edit').val(response.data.username);
                $('#nama_lengkap_edit').val(response.data.nama_lengkap);
                $('#jenis_kelamin_edit').val(response.data.jenis_kelamin).trigger('change');
                $('#tempat_lahir_edit').val(response.data.tempat_lahir);
                $('#tanggal_lahir_edit').val(response.data.tanggal_lahir ? dateFormat(response.data.tanggal_lahir) : '');
                $('#status_menikah_edit').val(response.data.status_menikah).trigger('change');
                $('#departemen_edit').val(response.data.departemen).trigger('change');
                $('#pekerjaan_edit').val(response.data.pekerjaan).trigger('change');
                $('#agama_edit').val(response.data.agama).trigger('change');
                $('#alamat_edit').val(response.data.alamat);
                $('#kota_edit').val(response.data.kota);
                $('#no_hp_edit').val(response.data.no_hp);

                modalEdit.show();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    function editAnggota(modalEdit) {
        let id = $('#id_edit').val();
        let formData = new FormData();

        console.log($('#photo_edit')[0].files.length);

        formData.append('username', $('#username_edit').val());
        formData.append('nama_lengkap', $('#nama_lengkap_edit').val());
        formData.append('jenis_kelamin', $('#jenis_kelamin_edit').val());
        formData.append('tempat_lahir', $('#tempat_lahir_edit').val());
        formData.append('tanggal_lahir', $('#tanggal_lahir_edit').val());
        formData.append('status_menikah', $('#status_menikah_edit').val());
        formData.append('departemen', $('#departemen_edit').val());
        formData.append('pekerjaan', $('#pekerjaan_edit').val());
        formData.append('agama', $('#agama_edit').val());
        formData.append('alamat', $('#alamat_edit').val());
        formData.append('kota', $('#kota_edit').val());
        formData.append('no_hp', $('#no_hp_edit').val());

        formData.append('photo', $('#photo_edit')[0].files.length > 0 ? $('#photo_edit')[0].files[0] : '');

        $.ajax({
            url: "{{ url('master-data/anggota/update') }}" + '/' + id,
            type: 'post',
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            beforeSend: function() { showLoading(); },
            data: formData,
            success: function(response) {
                showAlertSuccess(response.message);
                resetFormEdit();
                modalEdit.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {

        $('#jenis_kelamin_edit, #status_menikah_edit, #departemen_edit, #pekerjaan_edit, #agama_edit').select2({
            dropdownParent: $('#modal-edit-anggota'),
            minimumResultsForSearch: -1
        });

        $('#tanggal_lahir_edit').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '-80:+0',
            onClose: function(dateText, inst) {
                dateObject = $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay, 1));
            }
        });

        let modalEdit = new bootstrap.Modal('#modal-edit-anggota', {
            backdrop: 'static',
        });

        // button edit onclick handler
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            findAnggotaByID(id, modalEdit);
        });

        $('#form-edit-anggota').validate({
            submitHandler: function(form) {
                editAnggota(modalEdit);
            },
            rules: {
                username_edit: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                nama_lengkap_edit: {
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                },
                jenis_kelamin_edit: {
                    required: true,
                },
                tempat_lahir_edit: {
                    required: true,
                },
                tanggal_lahir_edit: {
                    required: true,
                },
                status_menikah_edit: {
                    required: true,
                },
                departemen_edit: {
                    required: true,
                },
                pekerjaan_edit: {
                    required: true,
                },
                agama_edit: {
                    required: true,
                },
                alamat_edit: {
                    required: false,
                },
                kota_edit: {
                    required: false,
                },
                no_hp_edit: {
                    required: false,
                },
                photo_edit: {
                    required: false,
                    extension: 'jpg|jpeg|png'
                },
            }
        });
    });
</script>
@endpush
