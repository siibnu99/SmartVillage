<?php

namespace App\Controllers;

use App\Libraries\Uuid;
use Exception;


class Surat extends BaseController
{
    protected $Uuid;
    public function __construct()
    {
        $this->Uuid = new Uuid;
    }
    public function index($id = null)
    {
        $dataRequest = $this->request->getVar();
        if (!isset($dataRequest['from_date'])) {
            $dataRequest['from_date'] = date('Y-m-d');
        }
        if (!isset($dataRequest['end_date'])) {
            $dataRequest['end_date'] = date('Y-m-d', strtotime('+1 day'));
        }
        if (!isset($dataRequest['type'])) {
            $dataRequest['type'] = 0;
        };
        // $dataRequest['from_date'] = $dataRequest['from_date'] . ' 00:00:00';
        // $dataRequest['end_date'] = date('Y-m-d H:i:s', strtotime($dataRequest['end_date']));
        // d($this->SuratModel
        //     ->where('created_at >=', $dataRequest['from_date'] . ' 00:00:00')->findAll());
        // dd($dataRequest);
        $data = [
            'title' => "Surat",
            'id' => $id,
            'from_date' => $dataRequest['from_date'],
            'end_date' => $dataRequest['end_date'],
            'type' => $dataRequest['type'],
        ];
        return view('surat/index', $data);
    }
    public function detail($id = null)
    {
        if ($id == null) {
            return redirect()->to(admin_url('surat'));
        }
        $data = [
            'title' => "Surat",
            'validation' => \Config\Services::validation(),
            'data' => $this->SuratModel->join('user_details', "user_details.id_user = surats.id_user")->find($id),
            "id" => $id
        ];
        return view('surat/detail', $data);
    }
    public function change()
    {
        $data = $this->request->getVar();
        $data['id_surat'] = $data['id'];
        $surat = $this->SuratModel->find($data['id']);
        $surat->status = $data['status'] - 1;
        $surat->notif_in = 1;
        $feedback =  [
            [
                'status' => $data['status'] - 1,
                'message' => $data['message'],
                'updated_at' => date('Y-m-d H:i:s'),
                'update_by_user' => 0,
            ],
        ];
        $dataIn = json_decode($surat->data, true);
        if (!isset($dataIn['feedback'])) {
            $dataIn['feedback'] = $feedback;
        } else {
            $dataIn['feedback'] = array_merge($dataIn['feedback'], $feedback);
        }
        $surat->data = json_encode($dataIn);
        $this->SuratModel->save($surat);
        $this->session->setFlashdata('message', 'Surat  berhasil diubah');
        return redirect()->to(admin_url('surat'));
    }
    public function listdata()
    {
        $dataRequest = $this->request->getVar('data');
        $m_icd = $this->SuratModel;
        if ($this->request->getPost()) {
            $lists = $m_icd->get_datatables($dataRequest);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                if ($list->status == 0) {
                    $status = '<span class="badge badge-sm bg-gradient-secondary">' . statusSurat($list->status + 1)[1] . '</span> ';
                } else if ($list->status == 1) {
                    $status = '<span class="badge badge-sm bg-gradient-danger">' . statusSurat($list->status + 1)[1] . '</span>';
                } else if ($list->status == 2) {
                    $status = '<span class="badge badge-sm bg-gradient-info">' . statusSurat($list->status + 1)[1] . '</span>';
                } else {
                    $status = '<span class="badge badge-sm bg-gradient-success">' . statusSurat($list->status + 1)[1] . '</span>';
                }
                $dataSurat = json_decode($list->data);
                $row = [];
                $row[] = $no;
                $row[] = $dataSurat->nama_lengkap ? $dataSurat->nama_lengkap : $list->nama_lengkap;
                $row[] = surat($list->type)[1];
                $row[] = $list->created_at;
                $row[] = $status;
                $row[] = '<div class="d-flex align-items-center justify-content-center"> <a href="' . admin_url('surat/detail/' . $list->id_surat) . '" role="button" class="btn bg-gradient-info btn-sm px-2 m-0" style="margin-left: 8px !important;">' . icon_detail('white') . '</a> </div>';
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $m_icd->count_all($dataRequest),
                "recordsFiltered" => $m_icd->count_filtered($dataRequest),
                "data" => $data,
                csrf_token() => csrf_hash()
            ];
            echo json_encode($output);
        }
    }
}
