<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('is_Logged') == TRUE) {
			redirect('dashboard', 'refresh');
		} else {
			$this->load->view('login_page');
		}
	}

	public function proses_login()
	{
		$username = $this->input->post('uname');
		$password = $this->input->post('pwd');
		$data = ['username' => $username];
		$query = $this->Main_model->where_data($data, 'tbl_pengguna');
		$result = $query->row_array();
		if (!empty($result) && password_verify($password, $result['password'])) {
			$data = [
				'is_Logged' 	=> TRUE,
				'username'		=> $result['username'],
			];
			$this->session->set_userdata($data);
			$dt['status'] = true;
			$dt['pesan_sukses'] = 'Selamat Datang ' . ucfirst($result['username']) . '!';
		} else {
			$dt['status'] = false;
			$dt['pesan_gagal'] = 'Akun tidak ditemukan!';
		}
		echo json_encode($dt);
	}

	//fungsi logout
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('app', 'refresh');
	}

	public function dashboard()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}
		$this->load->view('dashboard');
	}

	public function basis()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}

		$query = $this->Main_model->where_data(['id' => 1], 'tbl_konfigurasi');
		if ($query->num_rows()) {
			$data['status'] = true;
			$dt = $query->row_array();
			$data['nama_tempat'] = $dt['nama_tempat'];
			$data['kapasitas_motor'] = $dt['kapasitas_motor'];
			$data['kapasitas_mobil'] = $dt['kapasitas_mobil'];
			$data['dtID'] = $dt['id'];
			$data['method'] = 'update';
		} else {
			$data['dtID'] = 1;
			$data['status'] = false;
			$data['method'] = 'insert';
		}

		echo json_encode($data);
	}

	public function hitung_jml()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}

		$jenis_kendaraan = $this->input->post('jenis_kendaraan');
		$tgl = $this->input->post('tgl');
		$query = $this->Main_model->hitung_jml($tgl, $jenis_kendaraan);
		$queryKonfig = $this->Main_model->where_data(['id' => 1], 'tbl_konfigurasi');
		if ($query->num_rows()) {
			$dt = $query->row_array();
			$dtCF = $queryKonfig->row_array();
			$kapasitas = ($dt['kapasitas'] != null ? $dt['kapasitas'] : (($jenis_kendaraan == 'mobil') ? $dtCF['kapasitas_mobil'] : $dtCF['kapasitas_motor']));
			$jml_masuk = ($dt['jml_masuk'] != null ? $dt['jml_masuk'] : 0);
			$jml_keluar = ($dt['jml_keluar'] != null ? $dt['jml_keluar'] : 0);
			$sisa = $kapasitas - ($jml_masuk - $jml_keluar);
			$data = [
				'kapasitas' => $kapasitas,
				'jml_masuk' => $jml_masuk,
				'jml_keluar' => $jml_keluar,
				'sisa' => $sisa
			];
		} else {
			$data['kapasitas'] = 0;
			$data['jml_masuk'] = 0;
			$data['jml_keluar'] = 0;
			$data['sisa'] = 0;
		}
		echo json_encode($data);
	}

	public function tambah_data()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}

		$jenis_kendaraan = $this->input->post('jenis_kendaraan');
		$status_in_out = $this->input->post('status_in_out');
		$data = [
			'jenis_kendaraan' => $jenis_kendaraan,
			'status_in_out' => $status_in_out
		];
		if ($this->Main_model->insert_data($data, 'tbl_record')) {
			$data['status'] = true;
			$data['pesan_sukses'] = 'Data berhasil di proses!';
		} else {
			$data['status'] = false;
			$data['pesan_gagal'] = 'Data gagal di proses!';
		}
		echo json_encode($data);
	}

	public function simpan_modal()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}

		$id = $this->input->post('dtID');
		$method = $this->input->post('method');
		$dataKonfigurasi = [
			'nama_tempat' => $this->input->post('inputTempat'),
			'kapasitas_motor' => $this->input->post('inputKapasitasMotor'),
			'kapasitas_mobil' => $this->input->post('inputKapasitasMobil')
		];

		if ($method == 'update' && $id == 1) {
			if ($this->Main_model->update_data(['id' => 1], $dataKonfigurasi, 'tbl_konfigurasi')) {
				$data['pesan_konfigurasi'] = 'Ubah Data Pengaturan Sukses!';
			} else {
				$data['pesan_konfigurasi'] = 'Ubah Data Pengaturan Gagal!';
			}
		}

		if ($method == 'insert' && $id == 1) {
			$dataKonfigurasi['id'] = $id;
			if ($this->Main_model->insert_data($dataKonfigurasi, 'tbl_konfigurasi')) {
				$data['pesan_konfigurasi'] = 'Tambah Data Pengaturan Sukses!';
			} else {
				$data['pesan_konfigurasi'] = 'Tambah Data Pengaturan Gagal!';
			}
		}

		$options = [
			'cost' => 12,
		];
		$username = $this->input->post('inputUsernameBaru');
		$password = $this->input->post('inputPasswordBaru');
		$dt_password = password_hash($password, PASSWORD_DEFAULT, $options);
		$dataPengguna = [
			'username' => $username,
			'password' => $dt_password
		];
		if ($username && $password) {
			if ($this->Main_model->insert_data($dataPengguna, 'tbl_pengguna')) {
				$data['pesan_pengguna'] = 'Tambah Data Pengguna Sukses!';
			} else {
				$data['pesan_pengguna'] = 'Tambah Data Pengguna Gagal!';
			}
		}

		echo json_encode($data);
	}

	public function laporan()
	{
		# code...
		if ($this->session->userdata('is_Logged') == FALSE) {
			redirect('/', 'refresh');
		}

		$this->load->view('laporan');
	}

	public function tampil_laporan()
	{
		# code...
		$jenis_laporan = $this->input->post('jenisLaporan');
		if($jenis_laporan == 'harian'){
			$tgl = $this->input->post('date');
			$queryHarian = $this->Main_model->hitung_jmlHarian($tgl);
			$resultHarian = $queryHarian->result_array();
			$data = [
				'periode' => date('d F Y', strtotime($tgl)),
				'jenis_laporan' => 'Harian',
				'data' => $resultHarian
			];
			echo json_encode($data);
		} 
		
		if($jenis_laporan == 'bulanan'){
			$bulan_tahun = $this->input->post('date');
			$queryBulanan = $this->Main_model->hitung_jmlBulanan($bulan_tahun);
			$resultBulanan = $queryBulanan->result_array();
			$data = [
				'periode' => date('F Y', strtotime($bulan_tahun)),
				'jenis_laporan' => 'Bulanan',
				'data' => $resultBulanan
			];
			echo json_encode($data);
		}

		if($jenis_laporan == 'tahunan'){
			$tahun = $this->input->post('date');
			$queryTahunan = $this->Main_model->hitung_jmlTahunan($tahun);
			$resultTahunan = $queryTahunan->result_array();
			$data = [
				'periode' => date('Y', strtotime($tahun)),
				'jenis_laporan' => 'Tahunan',
				'data' => $resultTahunan
			];
			echo json_encode($data);
		}
	}
}
