<?php

Class Fungsi {

    protected $ci;

    function __construct() {
        $this->ci =& get_instance() ;

        }

        function user_login() {
            $this->ci->load->model('user_m');
            $user_id = $this->ci->session->userdata('userid');
            $user_data = $this->ci->user_m->get($user_id)->row();
            return $user_data;
        }

        public function count_item() {
            $this->ci->load->model('item_m');
            return $this->ci->item_m->get()->num_rows();
        }
        public function count_supplier() {
            $this->ci->load->model('supplier_m');
            return $this->ci->supplier_m->get()->num_rows();            
        }
        public function count_customer() {
            $this->ci->load->model('customer_m');
            return $this->ci->customer_m->get()->num_rows();
        }
        public function count_user() {
            $this->ci->load->model('user_m');
            return $this->ci->user_m->get()->num_rows();
        }

        public function ensure_activity_table()
        {
            if(!$this->ci->db->table_exists('t_activity')) {
                $this->ci->db->query("CREATE TABLE IF NOT EXISTS t_activity (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    type VARCHAR(20) NOT NULL,
                    entity VARCHAR(50) DEFAULT NULL,
                    entity_id INT DEFAULT NULL,
                    message TEXT,
                    created_at DATETIME NOT NULL
                )");
            }
        }

        public function log_activity($type, $entity = null, $entity_id = null, $message = null)
        {
            $this->ensure_activity_table();
            $user_id = $this->ci->session->userdata('userid');
            $data = [
                'user_id' => $user_id ? $user_id : 0,
                'type' => $type,
                'entity' => $entity,
                'entity_id' => $entity_id,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->ci->db->insert('t_activity', $data);
        }

        public function get_recent_activities($hours = 24)
        {
            $this->ensure_activity_table();
            $cutoff = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));
            $this->ci->db->select('t_activity.*, user.name as user_name');
            $this->ci->db->from('t_activity');
            $this->ci->db->join('user', 'user.user_id = t_activity.user_id', 'left');
            $this->ci->db->where('t_activity.created_at >=', $cutoff);
            $this->ci->db->order_by('t_activity.created_at', 'desc');
            return $this->ci->db->get()->result();
        }

        public function purge_old_activities($hours = 24)
        {
            $this->ensure_activity_table();
            $cutoff = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));
            $this->ci->db->where('created_at <', $cutoff);
            $this->ci->db->delete('t_activity');
        }

        function PdfGenerator($html, $filename, $paper, $orientation) {
            if(class_exists('Dompdf\\Dompdf')) {
                $dompdf = new Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper($paper, $orientation);
                // Render the HTML as PDF
                $dompdf->render();
                // Output the generated PDF to Browser
                $dompdf->stream($filename, array('Attachment' => 0));
            } else {
                show_error('Dompdf library is not installed');
            }
        }
    }
        
