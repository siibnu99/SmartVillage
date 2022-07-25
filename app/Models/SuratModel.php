<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use Exception;

class SuratModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'surats';
    protected $primaryKey       = 'id_surat';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ["id_surat", "id_user", "type", "status", "data", "notif_in", "message", "created_at", "updated_at", "deleted_at"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Datatables
    protected $column_order = array("surats.created_at", 'surats.id_user',  'surats.status', "surats.created_at");
    protected $column_search = array('surats.id_user', 'surats.status');
    protected $order = array('surats.created_at' => 'desc');
    protected $request;
    protected $db;
    protected $dt;


    function __construct(RequestInterface $request = NULL)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->select("surats.*,user_details.")->join('user_details', "user_details.id_user = surats.id_user")->where('surats.deleted_at', NULL);
    }
    private function _get_datatables_query($data = null)
    {
        $this->dt = $this->db->table($this->table)->select("surats.*,user_details.nama_lengkap")->join('user_details', "user_details.id_user = surats.id_user")->where('surats.deleted_at', NULL);
        if ($data) {
            if ($data['from_date'] != null) {
                $this->dt->where('surats.created_at >=', date('Y-m-d H:i:s', strtotime($data['from_date'])));
            }
            if ($data['end_date'] != null) {
                $this->dt->where('surats.created_at <=',  date('Y-m-d H:i:s', strtotime($data['end_date'])));
            }
            if ($data['type'] != null && $data['type'] != 0) {
                $this->dt->where('surats.type', $data['type']);
            }
        }
        $i = 0;
        try {
            foreach ($this->column_search as $item) {
                if ($this->request->getPost('search')['value']) {
                    if ($i === 0) {
                        $this->dt->groupStart();
                        $this->dt->like($item, $this->request->getPost('search')['value']);
                    } else {
                        $this->dt->orLike($item, $this->request->getPost('search')['value']);
                    }
                    if (count($this->column_search) - 1 == $i)
                        $this->dt->groupEnd();
                }
                $i++;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }


        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($data = null)
    {
        $this->_get_datatables_query($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($data = null)
    {

        $this->_get_datatables_query($data);
        return $this->dt->countAllResults();
    }
    public function count_all($data = null)
    {
        $tbl_storage = $this->db->table($this->table)->select("surats.*,user_details.nama_lengkap")->join('user_details', "user_details.id_user = surats.id_user")->where('surats.deleted_at', NULL);
        if ($data) {
            if ($data['from_date'] != null) {
                $tbl_storage->where('surats.created_at >=', $data['from_date']);
            }
            if ($data['end_date'] != null) {
                $tbl_storage->where('surats.created_at <=', $data['end_date']);
            }
            if ($data['type'] != null && $data['type'] != 0) {
                $tbl_storage->where('surats.type', $data['type']);
            }
        }
        return $tbl_storage->countAllResults();
    }
}
