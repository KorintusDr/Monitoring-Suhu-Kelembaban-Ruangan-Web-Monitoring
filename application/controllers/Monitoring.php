<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Monitoring_model');
    }

	public function index(){
		$this->load->view('monitoring_sensor');
	}

    public function ceksuhu(){
        $recordSensor = $this->Monitoring_model->getDataSensor();
        $data = array('data_sensor' => $recordSensor);

        $this->load->view('ceksuhu', $data);
    }

    public function cekkelembaban(){
        $recordSensor = $this->Monitoring_model->getDataSensor();
        $data = array('data_sensor' => $recordSensor);

        $this->load->view('cekkelembaban', $data);
    }

    public function kirimdata(){
        $suhu = $this->uri->segment(3);
        $kelembaban= $this->uri->segment(4);

        $DataUpdate = array(
            'suhu' => $suhu,
            'kelembaban' => $kelembaban
        );

        $this->Monitoring_model->UpdateData($DataUpdate);
    }
}
