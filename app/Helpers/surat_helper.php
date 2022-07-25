<?php
function surat($id = null)
{
    $data = [
        ["1", "Surat Keterangan Catatan Kepolisian"],
        ["2", "Surat Kuasa"],
        ["3", "Surat Keterangan Domisili"],
        ["4", "Surat Pindah Tempat"],
        ["5", "Surat Keterangan Hubungan Keluarga"],
        ["6", "Surat Keterangan Tidak Mampu"],
        ["7", "Surat Pengantar Nikah"],
        ["8", "Surat Pengantar Cerai"],
        ["9", "Surat Kehilangan"],
        ["10", "Surat Keterangan Kredit"],
        ["11", "Surat Boro Kerja"],
        ["12", "Surat Keterangan Kayu Desa"],
        ["13", "Kartu Keluarga"],
        ["14", "Permohonan Kartu Tanda Penduduk (KTP)"],
        ["15", "Surat Keterangan Usaha (SKU)"],
        ["16", "Surat Kelahiran"],
        ["17", "Surat Kematian"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function statusSurat($id = null)
{
    $data = [
        [1, "Diajukan"],
        [2, "Ditolak"],
        [3, "Diterima"],
        [4, "Selesai"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function keyObstractor($id = null)
{
    $data = [
        "type" => "Permohonan KTP",
        "nama_lengkap" => "Nama Lengkap",
        "jenis_kelamin" => "Jenis Kelamin",
        "tempat_lahir" => "Tempat Lahir",
        "tanggal_lahir" => "Tanggal Lahir",
        "pekerjaan" => "Pekerjaan",
        "nomor_ktp" => "Nomor NIK",
        "provinsi" => "Provinsi",
        "kabupaten" => "Kabupaten/Kab",
        "kecamatan" => "Kecamatan",
        "kelurahan" => "Kelurahan/Desa",
        "id_dusun" => "Dusun",
        "rt" => "RT",
        "rw" => "RW",
        "foto_user" => "Foto User",
        "tanda_tangan" => "Tanda Tangan",
        "foto_ktp_rusak" => "Foto KTP Rusak",
        "suket_hilang" => "Suket Hilang",
        "suket_pindah" => "Suket Pindah",
        "phone" => "Nomor HP",
        "agama" => "Agama",
        "status_perkawinan" => "Status Perkawinan",
        "kebangsaan" => "Kebangsaan",
        "alamat" => "Alamat",
        "alamat_asal" => "Alamat Asal",
        "alamat_domisili" => "Alamat Domisili",
        "is_kebangsaan" => "Kebangsaan Istri/Suami",
        "is_nama" => "Nama Istri/Suami",
        "is_umur" => "Umur Istri/Suami",
        "is_agama" => "Agama Istri/Suami",
        "is_pekerjaan" => "Pekerjaan Istri/Suami",
        "bp_nama" => "Nama Ayah",
        "bp_umur" => "Umur Ayah",
        "bp_agama" => "Agama Ayah",
        "bp_kebangsaan" => "Kebangsaan Ayah",
        "bp_pekerjaan" => "Pekerjaan Ayah",
        "bp_alamat" => "Alamat Ayah",
        "ib_nama" => "Nama Ibu",
        "ib_umur" => "Umur Ibu",
        "ib_agama" => "Agama Ibu",
        "ib_kebangsaan" => "Kebangsaan Ibu",
        "ib_pekerjaan" => "Pekerjaan Ibu",
        "ib_alamat" => "Alamat Ibu",
        "ska_nama" => "Nama Saudara Kandung/Tiri A",
        "ska_umur" => "Umur Saudara Kandung/Tiri A",
        "ska_pekerjaan" => "Pekerjaan Saudara Kandung/Tiri A",
        "ska_alamat" => "Alamat Saudara Kandung/Tiri A",
        "skb_nama" => "Nama Saudara Kandung/Tiri B",
        "skb_umur" => "Umur Saudara Kandung/Tiri B",
        "skb_pekerjaan" => "Pekerjaan Saudara Kandung/Tiri B",
        "skb_alamat" => "Alamat Saudara Kandung/Tiri B",
        "skc_nama" => "Nama Saudara Kandung/Tiri C",
        "skc_umur" => "Umur Saudara Kandung/Tiri C",
        "skc_pekerjaan" => "Pekerjaan Saudara Kandung/Tiri C",
        "skc_alamat" => "Alamat Saudara Kandung/Tiri C",

    ];
    if ($id) {
        foreach ($data as $key => $value) {
            if ($key == $id) {
                return $value;
            }
        }
        return $id;
    } else {
        return $data;
    }
}

function pengajuanKtp($id = null)
{
    $data = [
        ["1", "Baru"],
        ["2", "Perpanjangan"],
        ["3", "Pergantian"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function dusunId($id = null)
{
    $data = [
        ["1", "Dusun Krisik"],
        ["2", "Dusun Warurejo"],
        ["3", "Dusun Barurejo"],
        ["4", "Dusun Tirtomoyo"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function kebangsaanId($id = null)
{
    $data = [
        ["1", "WNI"],
        ["2", "WNA"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function perkawinanId($id = null)
{
    $data = [
        ["1", "Kawin"],
        ["2", "Belum Kawin"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
function agamaId($id = null)
{
    $data = [
        ["1", "Islam"],
        ["2", "Kristen"],
        ["3", "Hindu"],
        ["4", "Budha"],
        ["5", "Konghucu"],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
