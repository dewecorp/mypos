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
                enable_discount TINYINT(1) DEFAULT 0,
                auto_discount_percent DECIMAL(5,2) DEFAULT 0,
                logo VARCHAR(255) DEFAULT NULL,
                updated DATETIME DEFAULT NULL
            )");
            $this->db->insert('p_setting', [
                'shop_name' => 'MyPOS Store',
                'address' => 'Jl. Raya No. 123, Kota',
                'phone' => '0812-3456-7890',
                'updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->ensure_column('enable_discount', "ADD COLUMN enable_discount TINYINT(1) DEFAULT 0");
            $this->ensure_column('auto_discount_percent', "ADD COLUMN auto_discount_percent DECIMAL(5,2) DEFAULT 0");
            $this->ensure_column('logo', "ADD COLUMN logo VARCHAR(255) DEFAULT NULL");
        }
    }

    private function ensure_column($col, $sql)
    {
        $fields = $this->db->query("SHOW COLUMNS FROM p_setting")->result();
        $exists = false;
        foreach($fields as $f) { if($f->Field == $col) { $exists = true; break; } }
        if(!$exists) {
            $this->db->query("ALTER TABLE p_setting $sql");
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
            'enable_discount' => isset($post['enable_discount']) ? (int)$post['enable_discount'] : 0,
            'auto_discount_percent' => isset($post['auto_discount_percent']) && $post['auto_discount_percent'] !== '' ? (float)$post['auto_discount_percent'] : 0,
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