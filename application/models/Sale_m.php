<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_m extends CI_Model {

    public function get_item_by_barcode($barcode)
    {
        $this->db->from('p_item');
        $this->db->where('barcode', $barcode);
        return $this->db->get();
    }


    public function invoice_no()
    {
      $sql = "SELECT MAX(MID(invoice,9,4)) AS invoice_no
      FROM t_sale WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(), '%y%m%d')";
      $query = $this->db->query($sql);
      if($query->num_rows() > 0) {
      	$row = $query->row();
      	$n = ((int)$row->invoice_no) + 1;
      	$no = sprintf("%',04d", $n);
      } else {
      	$no = "0001";
      }
      $invoice = "MP".date('ymd').$no;
      return $invoice;
    }
    public function add_sale($data)
    {
        $this->db->insert('t_sale', $data);
        return $this->db->insert_id();
    }

    public function add_sale_detail($data)
    {
        $this->db->insert_batch('t_sale_detail', $data);
    }

    public function get_sale($id)
    {
        $this->db->select('t_sale.*, customer.name as customer_name, user.name as user_name');
        $this->db->from('t_sale');
        $this->db->join('customer', 'customer.customer_id = t_sale.customer_id', 'left');
        $this->db->join('user', 'user.user_id = t_sale.user_id');
        $this->db->where('t_sale.sale_id', $id);
        return $this->db->get();
    }

    public function get_sale_details($id)
    {
        $this->db->select('t_sale_detail.*, p_item.barcode, p_item.name as item_name');
        $this->db->from('t_sale_detail');
        $this->db->join('p_item', 'p_item.item_id = t_sale_detail.item_id');
        $this->db->where('t_sale_detail.sale_id', $id);
        return $this->db->get();
    }

    public function get_sales_by_period($start, $end)
    {
        $this->db->select('t_sale.sale_id, t_sale.invoice, t_sale.date, customer.name as customer_name, t_sale.final_price, user.name as user_name');
        $this->db->from('t_sale');
        $this->db->join('customer', 'customer.customer_id = t_sale.customer_id', 'left');
        $this->db->join('user', 'user.user_id = t_sale.user_id');
        $this->db->where('t_sale.date >=', $start);
        $this->db->where('t_sale.date <=', $end);
        $this->db->order_by('t_sale.date', 'desc');
        return $this->db->get();
    }

    public function get_sales_older_than($date)
    {
        $this->db->select('sale_id, invoice, date');
        $this->db->from('t_sale');
        $this->db->where('date <', $date);
        return $this->db->get();
    }

    public function sum_final_by_date($date)
    {
        $this->db->select_sum('final_price', 'total');
        $this->db->from('t_sale');
        $this->db->where('date', $date);
        $q = $this->db->get();
        $row = $q->row();
        return (int)($row ? $row->total : 0);
    }

    public function sum_final_by_period($start, $end)
    {
        $this->db->select_sum('final_price', 'total');
        $this->db->from('t_sale');
        $this->db->where('date >=', $start);
        $this->db->where('date <=', $end);
        $q = $this->db->get();
        $row = $q->row();
        return (int)($row ? $row->total : 0);
    }

    public function sum_final_total()
    {
        $this->db->select_sum('final_price', 'total');
        $this->db->from('t_sale');
        $q = $this->db->get();
        $row = $q->row();
        return (int)($row ? $row->total : 0);
    }

    public function get_daily_totals_last_days($days = 30)
    {
        $start = date('Y-m-d', strtotime("-{$days} days"));
        $this->db->select('date, SUM(final_price) as total');
        $this->db->from('t_sale');
        $this->db->where('date >=', $start);
        $this->db->group_by('date');
        $this->db->order_by('date', 'asc');
        return $this->db->get();
    }

}

