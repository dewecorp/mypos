<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		check_not_login();
		$this->load->model('sale_m');
		$today = date('Y-m-d');
		$month_start = date('Y-m-01');
		$today_income = $this->sale_m->sum_final_by_date($today);
		$month_income = $this->sale_m->sum_final_by_period($month_start, $today);
		$total_income = $this->sale_m->sum_final_total();
		$series = $this->sale_m->get_daily_totals_last_days(30)->result();
		$labels = [];
		$values = [];
		foreach($series as $row) {
			$labels[] = $row->date;
			$values[] = (int)$row->total;
		}
		$this->fungsi->purge_old_activities(24);
		$activities = $this->fungsi->get_recent_activities(24);
		$data = [
			'today_income' => $today_income,
			'month_income' => $month_income,
			'total_income' => $total_income,
			'chart_labels' => $labels,
			'chart_values' => $values,
			'activities' => $activities
		];
		$this->template->load('template', 'dashboard', $data);
	}
}
