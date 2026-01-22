<?php defined('BASEPATH') OR exit('No direct script access allowed');

class item_m extends CI_Model {

   
    public function get($id = null)

    {
        $this->db->from('p_item');
        if($id != null) {
            $this->db->where('item_id', $id);
        }
        $this->db->order_by('barcode', 'asc');
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'barcode' => isset($post['barcode']) && !empty($post['barcode']) ? $post['barcode'] : $this->generate_barcode($post['product_name']), 
            'name' => $post['product_name'], 
            'price' => $post['price'],     
        ];
        $this->db->insert('p_item', $params);
    }

    public function generate_barcode($name) {
        $initials = '';
        $words = explode(' ', $name);
        foreach($words as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        // Filter initials to only alphanumeric to be safe
        $initials = preg_replace('/[^A-Z0-9]/', '', $initials);
        
        $ym = date('ym'); 
        $prefix = $ym . $initials;
        
        // Find last sequence for this exact prefix pattern
        $sql = "SELECT barcode FROM p_item WHERE barcode REGEXP '^" . $prefix . "[0-9]{4}$' ORDER BY barcode DESC LIMIT 1";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) {
            $last_barcode = $query->row()->barcode;
            $last_seq = substr($last_barcode, strlen($prefix));
            $new_seq = str_pad((int)$last_seq + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new_seq = '0001';
        }
        
        return $prefix . $new_seq;
    }

    public function edit($post)
    {
        $params = [
            'name' => $post['product_name'], 
            'price' => $post['price'],
            'updated' => date('Y-m-d H:i:s')
        ];
        $this->db->where('item_id', $post['id']);
        $this->db->update('p_item', $params);
    }

    function check_barcode($code, $id = null) {
        $this->db->from('p_item');
        $this->db->where('barcode', $code);
        if($id != null) {
            $this->db->where('item_id !=', $id);
        }
        $query = $this->db->get();
        return $query;
       }

    public function del($id)
	{
        $this->db->where('item_id', $id);
        $this->db->delete('p_item');
    }
}