<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->ensure_photo();
    }

    private function ensure_photo()
    {
        if($this->db->table_exists('user')) {
            $fields = $this->db->query("SHOW COLUMNS FROM user")->result();
            $exists = false;
            foreach($fields as $f) { if($f->Field == 'photo') { $exists = true; break; } }
            if(!$exists) {
                $this->db->query("ALTER TABLE user ADD COLUMN photo VARCHAR(255) DEFAULT NULL");
            }
        }
    }

    public function login($post)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $post['username']);
        $this->db->where('password', sha1($post['password']));
        $query = $this->db->get();
        return $query;
    }

    public function get($id = null)
    {
        $this->db->from('user');
        if($id != null) {
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params['name'] = $post['fullname'];
        $params['username'] = $post['username'];
        $params['password'] = sha1($post['password']);
        $params['photo'] = isset($post['photo']) && $post['photo'] ? $post['photo'] : null;
        $params['level'] = $post['level'];
        $this->db->insert('user', $params);
    }

    public function edit($post)
    {
        $params['name'] = $post['fullname'];
        $params['username'] = $post['username'];
        if(!empty($post['password'])) {
            $params['password'] = sha1($post['password']);
        }
        if(isset($post['photo']) && $post['photo']) {
            $params['photo'] = $post['photo'];
        }
        $params['level'] = $post['level'];
        $this->db->where('user_id', $post['user_id']);
        $this->db->update('user', $params);
    }

    public function del($id)
	{
       
        $data['row'] = $this->user_m->get($id);
        $this->db->where('user_id', $id);
        $this->db->delete('user');
    }

}
	