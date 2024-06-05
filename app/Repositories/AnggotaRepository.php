<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Services\AnggotaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\Builder;

final class AnggotaRepository implements AnggotaService
{
    public function findAll(Request $request): array
    {
        $limit = $request->input('length') ? (int) $request->input('length') : 10;

        $anggota = Anggota::query();

        $anggota = $anggota->with(['statusMenikah', 'departemen', 'pekerjaan', 'agama']);

        $anggota = $anggota->when($request->input('search.value'), function(Builder $query, $value) {
            return $query->where(DB::raw('lower(nama_lengkap)'), 'like', '%'. strtolower($value) .'%')
                        ->orWhere(DB::raw('lower(username)'), 'like', '%'. strtolower($value) .'%')
                        ->orWhere(DB::raw('lower(tempat_lahir)'), 'like', '%'. strtolower($value) .'%');
        });

        $anggota = $anggota->paginate($limit);

        $data = $anggota->items();
        $total_items = $anggota->total();
        $total_page = ceil($total_items / intval($limit));

        return [
            'data' => $data,
            'recordsTotal' => $total_items,
            'recordsFiltered' => $total_items,
            'perPage' => intval($limit),
            'totalPage' => $total_page,
        ];
    }

    public function findByID(int|string $id): Anggota
    {
        $anggota = Anggota::where('id', $id)->first();

        if (!$anggota) {
            throw new DataNotFoundException('Anggota tidak ditemukan');
        }

        return $anggota;
    }

    public function createAnggota(array $validated): Anggota
    {
        $last_anggota = Anggota::query()->orderBy('id', 'desc')->first();
        $no_anggota =  $last_anggota ? 'ANG-'. str_pad(strval($last_anggota->id + 1), 7, '0', STR_PAD_LEFT) : 'ANG-0000001';

        $anggota = new Anggota();
        $tgl_lahir = new \DateTime($validated['tanggal_lahir']);

        $anggota->username = $validated['username'];
        $anggota->password = Hash::make('Secret123'); // default password: Secret123
        $anggota->no_anggota = $no_anggota;
        $anggota->nama_lengkap = $validated['nama_lengkap'];
        $anggota->jenis_kelamin = $validated['jenis_kelamin'];
        $anggota->tempat_lahir = $validated['tempat_lahir'];
        $anggota->tanggal_lahir = $tgl_lahir->format('Y-m-d');
        $anggota->status_menikah = $validated['status_menikah'];
        $anggota->departemen = $validated['departemen'];
        $anggota->pekerjaan = $validated['pekerjaan'];
        $anggota->agama = $validated['agama'];
        $anggota->alamat = $validated['pekerjaan'];
        $anggota->kota = $validated['kota'];
        $anggota->no_hp = $validated['no_hp'];
        // $anggota->tanggal_registrasi = date('Y-m-d H:i:s');
        $anggota->aktif_keanggotaan = 'N';
        $anggota->status_peminjaman = 'N';
        $anggota->save();

        if ($validated['photo']) {
            $photo_path = $this->uploadPhoto($validated['photo'], $anggota->id);
            $anggota->photo = $photo_path;
        }

        $anggota->save();

        return $anggota;
    }

    private function uploadPhoto(UploadedFile $photo, string|int $id): string
    {
        $ext = $photo->getClientOriginalExtension();
        $new_name = 'photo_' . rand() . '.' . $ext;

        return Storage::putFileAs('anggota/'.$id, $photo, $new_name);
    }

    public function updateAnggota(array $validated, string|int $id): Anggota
    {
        $anggota = Anggota::where('id', $id)->first();
        $tgl_lahir = new \DateTime($validated['tanggal_lahir']);

        $anggota->nama_lengkap = $validated['nama_lengkap'];
        $anggota->jenis_kelamin = $validated['jenis_kelamin'];
        $anggota->tempat_lahir = $validated['tempat_lahir'];
        $anggota->tanggal_lahir = $tgl_lahir->format('Y-m-d');
        $anggota->status_menikah = $validated['status_menikah'];
        $anggota->departemen = $validated['departemen'];
        $anggota->pekerjaan = $validated['pekerjaan'];
        $anggota->agama = $validated['agama'];
        $anggota->alamat = $validated['pekerjaan'];
        $anggota->kota = $validated['kota'];
        $anggota->no_hp = $validated['no_hp'];
        $anggota->updated_at = date('Y-m-d H:i:s');

        if ($validated['photo']) {
            // cek if anggota photo's before is exists
            if ($anggota->photo && Storage::exists($anggota->photo)) {
                Storage::delete($anggota->photo);
            }
            // upload again anggota photo's
            $photo_path = $this->uploadPhoto($validated['photo'], $id);
            $anggota->photo = $photo_path;
        }

        $anggota->save();

        return $anggota;
    }

    public function deleteAnggotaByID(int|string $id): void
    {
        $anggota = $this->findByID($id);

        if ($anggota->photo && Storage::exists($anggota->photo)) {
            Storage::deleteDirectory('anggota/' . $anggota->id);
        }

        $anggota->delete();
    }
}
