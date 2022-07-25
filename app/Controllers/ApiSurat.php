<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Uuid;
use CodeIgniter\API\ResponseTrait;
use Exception;

class ApiSurat extends BaseController
{
    use ResponseTrait;
    protected $Uuid;
    public function __construct()
    {
        $this->Uuid = new Uuid;
    }
    public function uploadKTP()
    {
        if (!$this->validate([
            'provinsi' => [
                'label' => 'Provinsi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'kabupaten' => [
                'label' => 'Kabupaten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'kecamatan' => [
                'label' => 'Kecamatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'kelurahan' => [
                'label' => 'Kelurahan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'type' => [
                'label'  => 'Type',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'nama_lengkap' => [
                'label'  => 'Nama lengkap',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'jenis_kelamin' => [
                'label'  => 'Jenis kelamin',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'tempat_lahir' => [
                'label'  => 'Tempat lahir',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'tanggal_lahir' => [
                'label'  => 'Tanggal lahir',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'pekerjaan' => [
                'label'  => 'Pekerjaan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'nomor_ktp' => [
                'label'  => 'Nomor KTP',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'id_dusun' => [
                'label'  => 'Dusun',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'rt' => [
                'label'  => 'RT',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'rw' => [
                'label'  => 'RW',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'foto_user' => [
                'label' => 'Foto 3x4',
                'rules' => 'uploaded[foto_user]|max_size[foto_user,1024]|mime_in[foto_user,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} wajib diisi!',
                    'max_size' => '{field} maksimal 1MB!',
                    'mime_in' => '{field} harus berupa gambar!',
                ],
            ],
            'tanda_tangan' => [
                'label' => 'Tanda Tangan',
                'rules' => 'uploaded[tanda_tangan]|max_size[tanda_tangan,1024]|mime_in[tanda_tangan,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} wajib diisi!',
                    'max_size' => '{field} maksimal 1MB!',
                    'mime_in' => '{field} harus berupa gambar!',
                ],
            ],

        ])) return $this->respond([
            'status' => 400,
            'message' => $this->validator->getErrors(),
        ], 400);
        $id = $this->request->auth->user_id;
        $dataUser = $this->UserDetailModel->find($id);
        $dataRequest = $this->request->getVar();
        if (!$dataRequest) {
            return $this->respond([
                'status' => 400,
                'message' => 'Request invalid',

            ], 400);
        }
        if ($dataUser) {
            $uploadimage = $this->request->getFile('foto_user');
            if ($uploadimage != null) {
                $nameFotoUser = $uploadimage->getRandomName();
                $uploadimage->move('assets/images/surat/', $nameFotoUser);
            }
            $uploadtanda = $this->request->getFile('tanda_tangan');
            if ($uploadtanda != null) {
                $nameTandaTangan = $uploadtanda->getRandomName();
                $uploadtanda->move('assets/images/surat/', $nameTandaTangan);
            }
            $uploadktprusak = $this->request->getFile('foto_ktp_rusak');
            if ($uploadktprusak != null) {
                if ($uploadktprusak->getError() != 4) {
                    $nameKtpRusak = $uploadktprusak->getRandomName();
                    $uploadktprusak->move('assets/images/surat/', $nameKtpRusak);
                }
            }
            $uploadsukethilang = $this->request->getFile('suket_hilang');
            if ($uploadsukethilang != null) {
                if ($uploadsukethilang->getError() != 4) {
                    $nameSuketHilang = $uploadsukethilang->getRandomName();
                    $uploadsukethilang->move('assets/images/surat/', $nameSuketHilang);
                }
            }
            $uploadsuketpindah = $this->request->getFile('suket_pindah');
            if ($uploadsuketpindah != null) {
                if ($uploadsuketpindah->getError() != 4) {
                    $nameSuketPindah = $uploadsuketpindah->getRandomName();
                    $uploadsuketpindah->move('assets/images/surat/', $nameSuketPindah);
                }
            }
            $dataSave = [
                'type' => $dataRequest['type'],
                'nama_lengkap' => $dataRequest['nama_lengkap'],
                'jenis_kelamin' => $dataRequest['jenis_kelamin'],
                'tempat_lahir' => $dataRequest['tempat_lahir'],
                'tanggal_lahir' => $dataRequest['tanggal_lahir'],
                'pekerjaan' => $dataRequest['pekerjaan'],
                'nomor_ktp' => $dataRequest['nomor_ktp'],
                'provinsi' => $dataRequest['provinsi'],
                'kabupaten' => $dataRequest['kabupaten'],
                'kecamatan' => $dataRequest['kecamatan'],
                'kelurahan' => $dataRequest['kelurahan'],
                'id_dusun' => $dataRequest['id_dusun'],
                'rt' => $dataRequest['rt'],
                'rw' => $dataRequest['rw'],
                'foto_user' => $nameFotoUser,
                'tanda_tangan' => $nameTandaTangan,
                'foto_ktp_rusak' => isset($nameKtpRusak) ? $nameKtpRusak : null,
                'suket_hilang' =>  isset($nameSuketHilang) ? $nameSuketHilang : null,
                'suket_pindah' =>  isset($nameSuketPindah) ? $nameSuketPindah : null,
            ];
            try {
                $this->SuratModel->insert([
                    'id_surat' => $this->Uuid->v4(),
                    'id_user' => $id,
                    'type' => 14,
                    'status' => 0,
                    'data' => json_encode($dataSave),
                ]);
                return $this->respond([
                    'status' => 200,
                    'message' => 'Berhasil upload request!',
                ], 200);
            } catch (Exception $e) {
                return $this->respond([
                    'status' => 400,
                    'message' => 'Gagal upload data!',
                    'error' => $e->getMessage(),
                ], 400);
            }
            return $this->respond($dataUser, 200);
        } else {
            return $this->respond([
                'status' => 400,
                'message' => 'User tidak ditemukan!',
            ], 400);
        }
        return $this->respond([
            'status' => 400,
            'message' => 'Request invalid',
        ], 400);
    }
    public function all()
    {
        $dataRequest = $this->request->getVar();
        $id = $this->request->auth->user_id;
        try {
            $type = $dataRequest->type;
            unset($dataRequest->type);
            unset($dataRequest->picture);
            if ($this->SuratModel->insert([
                'id_surat' => $this->Uuid->v4(),
                'id_user' => $id,
                'type' => $type,
                'status' => 0,
                'data' => json_encode($dataRequest),
            ])) {
                return $this->respond([
                    'status' => 200,
                    'message' => 'Berhasil upload request!',
                ], 200);
            }
        } catch (Exception $c) {
            return $this->respond([
                'status' => 400,
                'message' => 'Gagal upload data!',
                'error' => $c->getMessage(),
            ], 400);
        }
        return $this->respond([
            'status' => 400,
            'message' => 'Request invalid',
        ], 400);
    }
    public function getAll()
    {
        $id = $this->request->auth->user_id;
        $dataSurat = $this->SuratModel->where('id_user', $id)->orderBy('updated_at', "DESC")->findAll();
        return $this->respond($dataSurat, 200);
    }
    public function allpicture()
    {
        $id = $this->request->auth->user_id;
        $dataUser = $this->UserDetailModel->find($id);
        $dataRequest = $this->request->getVar();
        $dataFile = $this->request->getFiles();
        $dataupload = [];
        foreach ($dataFile as $key => $value) {
            if ($value != null) {
                $namaFoto = $value->getRandomName();
                $value->move('assets/images/surat/', $namaFoto);
            }
            $dataRequest[$key] = $namaFoto;
        }
        $type = $dataRequest['type'];
        unset($dataRequest['type']);
        try {
            $this->SuratModel->insert([
                'id_surat' => $this->Uuid->v4(),
                'id_user' => $id,
                'type' => $type,
                'status' => 0,
                'data' => json_encode($dataRequest),
            ]);
            return $this->respond([
                'status' => 200,
                'message' => 'Berhasil upload request!',
            ], 200);
        } catch (Exception $e) {
            return $this->respond([
                'status' => 400,
                'message' => 'Gagal upload data!',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function getnotifcount()
    {
        $id = $this->request->auth->user_id;
        $dataSurat = $this->SuratModel->where('id_user', $id)->where('notif_in', 1)->countAllResults();

        return $this->respond(['count' => $dataSurat], 200);
    }
    public function setnotif()
    {
        $id = $this->request->auth->user_id;
        $id_surat = $this->request->getVar('id');
        $surat = $this->SuratModel->find($id_surat);
        // return $this->respond(['status' => 200, 'data' => $surat], 200);
        $dataSurat = $this->SuratModel->where('id_user', $id)->update($id_surat, ['notif_in' => 0]);
        return $this->respond(['status' => 200], 200);
    }
}
