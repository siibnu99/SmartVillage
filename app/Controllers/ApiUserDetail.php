<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Exception;

class ApiUserDetail extends BaseController
{
    use ResponseTrait;
    public function getOnce()
    {
        $id = $this->request->auth->user_id;
        $phone = $this->request->auth->phone_number;
        $dataUser = $this->UserDetailModel
            ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
            ->where('user_details.id_user', $id)
            ->join("users", "users.id_user = user_details.id_user")
            ->first();
        if ($dataUser) {
            if ($dataUser->picture) {
                $dataUser->picture = base_url('assets/images/user/' . $dataUser->picture);
            }
            return $this->respond($dataUser, 200);
        } else {
            if ($this->UserModel->where('id_user', $id)->first() || $this->UserModel->where('phone', $phone)->first()) {
                try {
                    $this->UserDetailModel->save([
                        'id_user' => $id,
                    ]);
                    $dataUser = $this->UserDetailModel
                        ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
                        ->where('user_details.id_user', $id)
                        ->join("users", "users.id_user = user_details.id_user")
                        ->first();
                    if ($dataUser->picture) {
                        $dataUser->picture = base_url('assets/images/user/' . $dataUser->picture);
                    }
                    return $this->respond($dataUser, 200);
                } catch (Exception $th) {
                    $this->UserDetailModel->delete($id);
                    return $this->respond([
                        'status' => 400,
                        'message' => 'Gagal mendaftar!',
                        'error' => $th->getMessage(),
                    ], 400);
                }
            } else {
                return $this->respond([
                    'status' => 400,
                    'message' => 'Nomor telepon sudah terdaftar!',
                ], 400);
            }
        }
        return $this->respond([
            'status' => 400,
            'message' => 'Request invalid',
        ], 400);
    }
    public function update()
    {
        $id = $this->request->auth->user_id;
        $dataUser = $this->UserDetailModel
            ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
            ->where('user_details.id_user', $id)
            ->join("users", "users.id_user = user_details.id_user")
            ->first();
        $dataRequest = $this->request->getVar();
        if (!$dataRequest) {
            return $this->respond([
                'status' => 400,
                'message' => 'Request invalid',
            ], 400);
        }
        if ($dataUser) {
            if (!$this->validate([
                'nama_lengkap' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'tempat_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'tanggal_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'pekerjaan' => [
                    'label' => 'Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'nomor_ktp' => [
                    'label' => 'Nomor KTP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'rt' => [
                    'label' => 'RT',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                'rw' => [
                    'label' => 'RW',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
            ])) return $this->respond([
                'status' => 400,
                'message' => 'Request invalid',
                'error' => $this->validator->getErrors(),
            ], 400);
            try {
                $this->UserDetailModel->update($id, [
                    "nama_lengkap" => $dataRequest->nama_lengkap,
                    "tempat_lahir" => $dataRequest->tempat_lahir,
                    "tanggal_lahir" => $dataRequest->tanggal_lahir,
                    "jenis_kelamin" => $dataRequest->jenis_kelamin,
                    "pekerjaan" => $dataRequest->pekerjaan,
                    "nomor_ktp" => $dataRequest->nomor_ktp,
                    "id_dusun" => $dataRequest->id_dusun,
                    "rt" => $dataRequest->rt,
                    "rw" => $dataRequest->rw,
                ]);
                $dataUser = $this->UserDetailModel
                    ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
                    ->where('user_details.id_user', $id)
                    ->join("users", "users.id_user = user_details.id_user")
                    ->first();
                if ($dataUser->picture) {
                    $dataUser->picture = base_url('assets/images/user/' . $dataUser->picture);
                }
                return $this->respond([
                    'status' => 200,
                    'data' => $dataUser,
                    'message' => 'Berhasil mengubah data!',
                ], 200);
            } catch (Exception $e) {
                return $this->respond([
                    'status' => 400,
                    'message' => 'Gagal mengubah data!',
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
    public function updateWithImage()
    {
        $id = $this->request->auth->user_id;
        $dataUser = $this->UserDetailModel
            ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
            ->where('user_details.id_user', $id)
            ->join("users", "users.id_user = user_details.id_user")
            ->first();
        $dataRequest = $this->request->getVar();
        // dd($dataRequest);
        if (!$dataRequest) {
            return $this->respond([
                'status' => 400,
                'message' => 'Request invalid',
            ], 400);
        }

        if ($dataUser) {
            if (!$this->validate([
                'nama_lengkap' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi!',
                    ],
                ],
                // 'picture' => [
                //     'label' => 'Foto profile',
                //     'rules' => 'uploaded[picture]|max_size[picture,1024]|mime_in[picture,image/png,image/jpeg]',
                //     'errors' => [
                //         'uploaded' => '{field} wajib diisi!',
                //         'max_size' => '{field} maksimal 1MB!',
                //         'mime_in' => '{field} harus berupa gambar!',
                //     ],
                // ],
            ])) return $this->respond([
                'status' => 400,
                'message' => 'Request invalid',
                'error' => $this->validator->getErrors(),
            ], 400);
            $uploadimage = $this->request->getFile('picture');
            try {
                if ($uploadimage != null) {
                    if ($uploadimage->getError() == 4) {
                        $nameimage = $dataUser->picture;
                    } else {
                        try {
                            unlink('assets/images/user/' . $dataUser->picture);
                        } catch (\Throwable $th) {
                        }
                        $nameimage = $uploadimage->getRandomName();
                        $uploadimage->move('assets/images/user/', $nameimage);
                    }
                } else {
                    $nameimage = $dataUser->picture;
                }

                $this->UserDetailModel->update($id, [
                    "nama_lengkap" => $dataRequest['nama_lengkap'],
                    'picture' => $nameimage,
                ]);
                $dataUser = $this->UserDetailModel
                    ->select("users.phone,user_details.nama_lengkap,user_details.picture,user_details.tempat_lahir,user_details.tanggal_lahir,user_details.jenis_kelamin, user_details.pekerjaan, user_details.nomor_ktp, user_details.id_dusun, user_details.rt, user_details.rw")
                    ->where('user_details.id_user', $id)
                    ->join("users", "users.id_user = user_details.id_user")
                    ->first();
                if ($dataUser->picture) {
                    $dataUser->picture = base_url('assets/images/user/' . $dataUser->picture);
                }
                return $this->respond([
                    'status' => 200,
                    'data' => $dataUser,
                    'message' => 'Berhasil mengubah data!',
                ], 200);
            } catch (Exception $e) {
                return $this->respond([
                    'status' => 400,
                    'message' => 'Gagal mengubah data!',
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
}
