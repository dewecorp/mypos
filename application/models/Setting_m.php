<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->ensure_table();
    }

    private function ensure_table()
    {
        if(!$this->db->table_exists('p_setting')) {
            $this->db->query("CREATE TABLE p_setting (
                id INT AUTO_INCREMENT PRIMARY KEY,
                shop_name VARCHAR(100) DEFAULT 'MyPOS Store',
                address TEXT,
                phone VARCHAR(20),
                updated DATETIME DEFAULT NULL
            )");
            $this->db->insert('p_setting', [
                'shop_name' => 'MyPOS Store',
                'address' => 'Jl. Raya No. 123, Kota',
                'phone' => '0812-3456-7890',
                'updated' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function get()
    {
        $this->db->from('p_setting');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function update($post)
    {
        $params = [
            'shop_name' => $post['shop_name'],
            'address' => $post['address'],
            'phone' => $post['phone'],
            'updated' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', 1);
        $this->db->update('p_setting', $params);
        // If no row exists (edge case), insert it
        if ($this->db->affected_rows() == 0) {
            $check = $this->db->get('p_setting')->row();
            if(!$check) {
                $this->db->insert('p_setting', $params);
            }
        }
    }
}