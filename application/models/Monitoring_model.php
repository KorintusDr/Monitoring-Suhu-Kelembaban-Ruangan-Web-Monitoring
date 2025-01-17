<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_model extends CI_Model {

    public function getDataSensor(){
        $this->db->select('*');
        $this->db->from('tb_sensor');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    public function UpdateData($DataUpdate){
        $this->db->update('tb_sensor', $DataUpdate);
    }

}

?>