<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Grupo extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Solo los Administradores están autorizados a acceder a esta página, <a href="' . base_url('dashboard') . '">Volver al menú</a>', 403, 'Acceso Prohibido');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->form_validation->set_error_delimiters('', '');
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function index()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'titulo'	=> 'Grupos',
			'subtitulo' => 'Datos de los grupos'
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('direccion/grupo/data');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'titulo'		=> 'Agregar grupo',
			'subtitulo'	=> 'Agregar Datos de grupo',
			'lote'	=> $this->input->post('lote', true)
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('direccion/grupo/add');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function data()
	{
		$this->output_json($this->master->getDataGrupo(), false);
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('jurusan');
		} else {
			$jurusan = $this->master->getJurusanById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Editar Departmento',
				'subjudul'	=> 'Editar Datos de Departamento',
				'jurusan'	=> $jurusan
			];
			$this->load->view('_templates/dashboard/_header', $data);
			$this->load->view('direccion/grupo/edit');
			$this->load->view('_templates/dashboard/_footer');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nombre_grupo', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nombre_grupo = 'nombre_grupo[' . $i . ']';
			$this->form_validation->set_rules($nombre_grupo, 'Dept.', 'required');
			$this->form_validation->set_message('required', '{field} Required');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nombre_grupo => form_error($nombre_grupo)
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nombre_grupo' => $this->input->post($nombre_grupo, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_grupo'	=> $this->input->post('id_grupo[' . $i . ']', true),
						'nombre_grupo' 	=> $this->input->post($nombre_grupo, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('grupo', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('grupo', $update, 'id_grupo', null, true);
				$data['update'] = $update;
			}
		} else {
			if (isset($error)) {
				$data['errors'] = $error;
			}
		}
		$data['status'] = $status;
		$this->output_json($data);
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('jurusan', $chk, 'id_jurusan')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function load_jurusan()
	{
		$data = $this->master->getJurusan();
		$this->output_json($data);
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Departmento',
			'subjudul' => 'Importar Departmento'
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('direccion/grupo/import');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function preview()
	{
		$config['upload_path']		= './uploads/import/';
		$config['allowed_types']	= 'xls|xlsx|csv';
		$config['max_size']			= 2048;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload_file')) {
			$error = $this->upload->display_errors();
			echo $error;
			die;
		} else {
			$file = $this->upload->data('full_path');
			$ext = $this->upload->data('file_ext');

			switch ($ext) {
				case '.xlsx':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					break;
				case '.xls':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
					break;
				case '.csv':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					break;
				default:
					echo "unknown file ext";
					die;
			}

			$spreadsheet = $reader->load($file);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$jurusan = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				if ($sheetData[$i][0] != null) {
					$jurusan[] = $sheetData[$i][0];
				}
			}

			unlink($file);

			$this->import($jurusan);
		}
	}
	public function do_import()
	{
		$data = json_decode($this->input->post('jurusan', true));
		$jurusan = [];
		foreach ($data as $j) {
			$jurusan[] = ['nama_jurusan' => $j];
		}

		$save = $this->master->create('jurusan', $jurusan, true);
		if ($save) {
			redirect('jurusan');
		} else {
			redirect('jurusan/import');
		}
	}
}
