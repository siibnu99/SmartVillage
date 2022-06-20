<?php
function surat($id = null)
{
    $data = [
        ["Surat Keterangan Kuasa"],
        ["Surat Keterangan Domisili"],
        ["Surat Keterangan Usaha dan Domisili Usaha"],
        ["Surat Keterangan Pindah Tempat"],
        ["Surat Kelahiran"],
        ["Surat Kematian"],
        ["Surat Keterangan Miskin"],
        ["Surat Keterangan Kredit"],
        ["Surat Keterangan Kehilangan"],
        ["Surat Persetujuan Mempelai"],
        ["Surat Permohonan KTP"],
        ["Surat Permohonan KK"],
        ["Surat Keterangan Baru Kerja"],
        ["Surat Keterangan Kayu Desa"]
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
