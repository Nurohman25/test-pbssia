<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mkaryawan extends Model
{
    function viewData()
    {
        $query = DB::table('tb_karyawan')
        ->select("nik As kode_karyawan", "nama As nama_karyawan", "alamat As alamat_karyawan", 
        "telepon As telepon_karyawan", "jabatan As jabatan_karyawan")
        ->orderBy("nik")
        ->get();

        return $query;
    }

    function detailData($parameter)
    {
        $query = DB::table('tb_karyawan')
        ->select("nik As kode_karyawan", "nama As nama_karyawan", "alamat As alamat_karyawan", 
        "telepon As telepon_karyawan", "jabatan As jabatan_karyawan")
        //->where("MD5(nik)","=",$parameter)

        // gunakan MD5(nik)
        //->whereRaw("MD5(nik) = '$parameter'")

        //->where(DB::raw("MD5(nik)"),"=",$parameter)

        //gunakan base64(nik)
        ->where(DB::raw("TO_BASE64(nik)"),"=",$parameter)

        ->orderBy("nik")
        ->get();

        return $query;
    }

    //fungsi untuk delete data
    function deleteData($parameter)
    {
        DB::table("tb_karyawan")
        ->where(DB::raw("TO_BASE64(nik)"),"=",$parameter)
        ->delete();
    }

    //buat fungsi untuk simpan data
    function saveData($nik, $nama, $alamat, $telepon, $jabatan)
    {
        DB::table("tb_karyawan")
        ->insert([
            "nik" => $nik,
            "nama" => $nama,
            "alamat" => $alamat,
            "telepon" => $telepon,
            "jabatan" => $jabatan,
        ]);
    }

    //buat fungsi untuk cek ubah data
    function checkUpdate($nik_lama, $nik_baru)
    {
        $query = DB::table("tb_karyawan")
        ->select("nik")
        ->where("nik", "=", $nik_baru)
        ->where(DB::raw("TO_BASE64(nik)"), "!=", $nik_lama)
        ->get();

        return $query;
    }
    //buat fungsi untuk ubah data
    function updateData($nik, $nama, $alamat, $telepon, $jabatan, $nik_lama)
    {
        DB::table("tb_karyawan")
        ->where(DB::raw("TO_BASE64(nik)"),"=",$nik_lama)
        ->update([
            "nik" => $nik,
            "nama" => $nama,
            "alamat" => $alamat,
            "telepon" => $telepon,
            "jabatan" => $jabatan,
        ]);
    }
}
