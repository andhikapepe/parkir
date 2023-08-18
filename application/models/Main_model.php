<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Main_model extends CI_Model
{
    function where_data($where, $table)
    {
        return $this->db->get_where($table, $where);
    }

    function insert_data($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    function update_data($where, $data, $table)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    function hitung_jml($tgl,$jenis_kendaraan)
    {
        # code...
        //SELECT date(date_time) tgl, jenis_kendaraan, (CASE WHEN jenis_kendaraan = 'mobil' THEN b.kapasitas_mobil ELSE b.kapasitas_motor END) AS kapasitas, SUM(CASE WHEN status_in_out = 'in' THEN 1 ELSE 0 END) AS 'jml_masuk', SUM(CASE WHEN status_in_out = 'out' THEN 1 ELSE 0 END) AS 'jml_keluar' FROM tbl_record a, tbl_konfigurasi b WHERE date(date_time) = '2023-04-28' AND jenis_kendaraan = 'mobil';
        $this->db->select('date(date_time) tgl, jenis_kendaraan, (CASE WHEN jenis_kendaraan = "mobil" THEN b.kapasitas_mobil ELSE b.kapasitas_motor END) AS kapasitas, SUM(CASE WHEN status_in_out = "in" THEN 1 ELSE 0 END) AS "jml_masuk", SUM(CASE WHEN status_in_out = "out" THEN 1 ELSE 0 END) AS "jml_keluar"');
        $this->db->from('tbl_record a, tbl_konfigurasi b');
        $this->db->where('date(date_time)',$tgl);
        $this->db->where('jenis_kendaraan',$jenis_kendaraan);
        return $this->db->get();
    }
    
    function hitung_jmlHarian($tgl)
    {
        # code...
        //SELECT date(date_time) tgl, jenis_kendaraan, (CASE WHEN jenis_kendaraan = 'mobil' THEN b.kapasitas_mobil ELSE b.kapasitas_motor END) AS kapasitas, SUM(CASE WHEN status_in_out = 'in' THEN 1 ELSE 0 END) AS 'jml_masuk', SUM(CASE WHEN status_in_out = 'out' THEN 1 ELSE 0 END) AS 'jml_keluar' FROM tbl_record a, tbl_konfigurasi b WHERE date(date_time) = '2023-04-30' GROUP BY jenis_kendaraan;
        $this->db->select('date(date_time) tgl, jenis_kendaraan, (CASE WHEN jenis_kendaraan = "mobil" THEN b.kapasitas_mobil ELSE b.kapasitas_motor END) AS kapasitas, SUM(CASE WHEN status_in_out = "in" THEN 1 ELSE 0 END) AS "jml_masuk", SUM(CASE WHEN status_in_out = "out" THEN 1 ELSE 0 END) AS "jml_keluar"');
        $this->db->from('tbl_record a, tbl_konfigurasi b');
        $this->db->where('date(date_time)',$tgl);
        $this->db->group_by('jenis_kendaraan');
        return $this->db->get();
    }

    function hitung_jmlBulanan($bulan_tahun)
    {
        # code...
        //SELECT DATE_FORMAT(date_time, "%Y-%m") bulan_tahun, jenis_kendaraan, SUM(CASE WHEN status_in_out = 'in' THEN 1 ELSE 0 END) AS 'jml_masuk', SUM(CASE WHEN status_in_out = 'out' THEN 1 ELSE 0 END) AS 'jml_keluar' FROM tbl_record a, tbl_konfigurasi b WHERE DATE_FORMAT(date_time, "%Y-%m") = '2023-04' GROUP BY jenis_kendaraan;
        $this->db->select('DATE_FORMAT(date_time, "%Y-%m") bulan_tahun, jenis_kendaraan, SUM(CASE WHEN status_in_out = "in" THEN 1 ELSE 0 END) AS "jml_masuk", SUM(CASE WHEN status_in_out = "out" THEN 1 ELSE 0 END) AS "jml_keluar"');
        $this->db->from('tbl_record');
        $this->db->where('DATE_FORMAT(date_time, "%Y-%m") =',$bulan_tahun);
        $this->db->group_by('jenis_kendaraan');
        return $this->db->get();
    }

    function hitung_jmlTahunan($tahun)
    {
        # code...
        //SELECT DATE_FORMAT(date_time, "%Y") tahun, jenis_kendaraan, SUM(CASE WHEN status_in_out = 'in' THEN 1 ELSE 0 END) AS 'jml_masuk', SUM(CASE WHEN status_in_out = 'out' THEN 1 ELSE 0 END) AS 'jml_keluar' FROM tbl_record a, tbl_konfigurasi b WHERE DATE_FORMAT(date_time, "%Y") = '2023' GROUP BY jenis_kendaraan;
        $this->db->select('DATE_FORMAT(date_time, "%Y") tahun, jenis_kendaraan, SUM(CASE WHEN status_in_out = "in" THEN 1 ELSE 0 END) AS "jml_masuk", SUM(CASE WHEN status_in_out = "out" THEN 1 ELSE 0 END) AS "jml_keluar"');
        $this->db->from('tbl_record');
        $this->db->where('DATE_FORMAT(date_time, "%Y") =',$tahun);
        $this->db->group_by('jenis_kendaraan');
        return $this->db->get();
    }
}