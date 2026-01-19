	function get_ajax() {
        $list = $this->item_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $item->barcode.'<br><a href="'.site_url('item/barcode_qrcode/'.$item->item_id).'" class="btn btn-default btn-xs">Generate <i class="fa fa-barcode"></i></a>';
            $row[] = $item->name;
            $row[] = $item->category_name;
            $row[] = $item->unit_name;
            $row[] = indo_currency($item->price);
            $row[] = $item->stock;
            $row[] = $item->image != null ? '<img src="'.base_url('uploads/product/'.$item->image).'" class="img" style="width:100px">' : null;
            // add html for action
            $row[] = '<a href="'.site_url('item/edit/'.$item->item_id).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                    <a href="'.site_url('item/del/'.$item->item_id).'" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->item_m->count_all(),
                    "recordsFiltered" => $this->item_m->count_filtered(),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }