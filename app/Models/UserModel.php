<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['id_user', 'number_user', 'email', 'password', 'is_active', 'role_access', 'token_active', 'token_active_expired', 'token_forgot', 'token_forgot_expired', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $column_order = array("users.created_at", 'users.email', 'users.role_access', 'users.is_active', "users.created_at");
    protected $column_search = array('users.email', 'users.is_active');
    protected $order = array('users.created_at' => 'asc');
    protected $request;
    protected $db;
    protected $dt;


    function __construct(RequestInterface $request = NULL)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->where('users.deleted_at', NULL);
    }
    private function _get_datatables_query($id = null)
    {
        $this->dt = $this->db->table($this->table)->where('users.deleted_at', NULL);
        if ($id) {
            $this->dt =  $this->dt->where('role_access', $id);
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
    function get_datatables($id = null)
    {
        $this->_get_datatables_query($id);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($id = null)
    {

        $this->_get_datatables_query($id);
        return $this->dt->countAllResults();
    }
    public function count_all($id = null)
    {
        $tbl_storage = $this->db->table($this->table)->where('users.deleted_at', NULL);
        if ($id) {
            $tbl_storage =  $tbl_storage->where('role_access', $id);
        }
        return $tbl_storage->countAllResults();
    }
}
