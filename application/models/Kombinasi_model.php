<?php
class Kombinasi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_data_penyakit()
    {
        $query = $this->db->get('koding'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai dalam database Anda
        return $query->result_array();
    }

    public function get_all_koding()
    {
        $query = $this->db->get('koding');
        return $query->result();
    }

    public function insert_koding($data)
    {
        return $this->db->insert('koding', $data);
    }

    public function get_koding_by_id($id)
    {
        $query = $this->db->get_where('koding', array('id' => $id));
        return $query->row();
    }

    public function update_koding($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('koding', $data);
    }

    public function delete_koding($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('koding');
    }

    public function cek_kombinasi($kode_satu, $kode_dua)
    {
        $query = $this->db->get_where('koding', ['kode_satu' => $kode_satu, 'kode_dua' => $kode_dua]);
        return $query->row_array();
    }
}
