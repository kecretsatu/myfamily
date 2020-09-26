<?php
class Dashboard_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	/* Data Current */
	
	public function get_data_curr($tahun, $id_galeri = FALSE, $is_monthly = TRUE, $bulan = FALSE) {
		$select = 'r.tahun, sum(r.rekening_efek) as rekening_efek, sum(r.nilai_transaksi) as nilai_transaksi, 
					sum(r.frekuensi_transaksi) as frekuensi_transaksi, sum(r.pengambilan_data) as pengambilan_data,
					(r.kunjungan_mahasiswa) + (r.kunjungan_umum) as kunjungan_perorangan, 
					ifnull((select sum(jumlah) from gbei_kunjungan_grup where id_galeri = r.id_galeri and bulan = r.bulan and r.tahun = tahun), 0) as kunjungan_grup, 
					ifnull((select sum(jumlah) from gbei_studi_banding where id_galeri = r.id_galeri and bulan = r.bulan and r.tahun = tahun), 0) as studi_banding,
					ifnull((select sum(jumlah) from gbei_penyelenggaraan where id_galeri = r.id_galeri and bulan = r.bulan and r.tahun = tahun), 0) as penyelenggaraan, 
					ifnull((select count(*) from gbei_keikutsertaan where id_galeri = r.id_galeri and bulan = r.bulan and r.tahun = tahun), 0) as keikutsertaan, 
					ifnull((select count(*) from gbei_kegiatan_lain where id_galeri = r.id_galeri and bulan = r.bulan and r.tahun = tahun), 0) as kegiatan_lain ';

		if($is_monthly){
			$select .= ', (select name from month_name_id where id = r.bulan) as month_name';
		}
		
		$condition = "r.tahun =" . "'" . $tahun . "'";
		if($id_galeri != FALSE){
			$condition .= " AND r.id_galeri = '".$id_galeri."'";
		}
		if($bulan != FALSE){
			$condition .= " AND r.bulan = '".$bulan."'";
		}
		
		$group_by = "";
		if($is_monthly){
			$group_by = "r.tahun, r.bulan";
		}
		
		$this->db->select($select);
		$this->db->from('gbei_report r ');
		$this->db->where($condition);
		$this->db->group_by($group_by); 
		$this->db->order_by("r.bulan asc");
		//$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Rekening Efek */
	
	public function get_rekening_efek($id_galeri, $tahun) {
		$condition = "id_galeri =" . "'" . $id_galeri . "' AND " . "tahun =" . "'" . $tahun . "'";
		$this->db->select('(select short from month_name_id where id = bulan) as x, rekening_efek as y');
		$this->db->from('gbei_report');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Nilai Transaksi */
	
	public function get_nilai_transaksi($id_galeri, $tahun) {
		$condition = "id_galeri =" . "'" . $id_galeri . "' AND " . "tahun =" . "'" . $tahun . "'";
		$this->db->select('(select short from month_name_id where id = bulan) as x, nilai_transaksi as y');
		$this->db->from('gbei_report');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Frekuensi Transaksi */
	
	public function get_frekuensi_transaksi($id_galeri, $tahun) {
		$condition = "id_galeri =" . "'" . $id_galeri . "' AND " . "tahun =" . "'" . $tahun . "'";
		$this->db->select('(select short from month_name_id where id = bulan) as x, frekuensi_transaksi as y');
		$this->db->from('gbei_report');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Pengambilan Data */
	
	public function get_pengambilan_data($id_galeri, $tahun) {
		$condition = "id_galeri =" . "'" . $id_galeri . "' AND " . "tahun =" . "'" . $tahun . "'";
		$this->db->select('(select short from month_name_id where id = bulan) as x, pengambilan_data as y');
		$this->db->from('gbei_report');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Kunjungan */
	
	public function get_kunjungan_sum($id_galeri, $tahun) {
		$select		= "r.bulan, (select short from month_name_id where id = r.bulan) as x, (r.kunjungan_mahasiswa) + (r.kunjungan_umum) as a, 
						ifnull((select sum(jumlah) from gbei_kunjungan_grup where bulan = r.bulan and r.tahun = tahun), 0) as b, 
						ifnull((select sum(jumlah) from gbei_studi_banding where bulan = r.bulan and r.tahun = tahun), 0) as c";
		$condition = "r.id_galeri =" . "'" . $id_galeri . "' AND " . "r.tahun =" . "'" . $tahun . "'";
		
		$this->db->select($select);
		$this->db->from('gbei_report r');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
	/* Sosialisasi */
	
	public function get_sosialisasi_sum($id_galeri, $tahun) {
		$select		= "r.bulan, (select short from month_name_id where id = r.bulan) as x, 
						ifnull((select count(*) from gbei_penyelenggaraan where bulan = r.bulan and r.tahun = tahun), 0) as a, 
						ifnull((select count(*) from gbei_keikutsertaan where bulan = r.bulan and r.tahun = tahun), 0) as b, 
						ifnull((select count(*) from gbei_kegiatan_lain where bulan = r.bulan and r.tahun = tahun), 0) as c";
		$condition = "r.id_galeri =" . "'" . $id_galeri . "' AND " . "r.tahun =" . "'" . $tahun . "'";
		
		$this->db->select($select);
		$this->db->from('gbei_report r');
		$this->db->where($condition);
		$this->db->order_by("bulan", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row;
		} else {
			return array();
		}
	}
	
}
?>