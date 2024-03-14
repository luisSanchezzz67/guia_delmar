<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Curso extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Solo los Administradores están autorizados a acceder a esta página, <a href="' . base_url('dashboard') . '">Volver al menú</a>', 403, 'Forbidden Access');
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
			'titulo'	=> 'Curso',
			'subtitulo' => 'Datos de Curso'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/curso/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataCurso(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'titulo'		=> 'Agregar Curso',
			'subtitulo'	=> 'Agregar Datos de Curso',
			'lote'	=> $this->input->post('lote', true)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/curso/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('curso');
		} else {
			$curso = $this->master->getCursoById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'titulo'		=> 'Editar Curso',
				'subtitulo'	=> 'Editar Datos de Curso',
				'curso'	=> $curso
			];
			$this->load->view('_templates/dashboard/_header.php', $data);
			$this->load->view('direccion/curso/edit');
			$this->load->view('_templates/dashboard/_footer.php');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nombre_curso', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nombre_curso = 'nombre_curso[' . $i . ']';
			$this->form_validation->set_rules($nombre_curso, 'Course', 'required');
			$this->form_validation->set_message('required', '{field} Required');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nombre_curso => form_error($nombre_curso)
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nombre_curso' => $this->input->post($nombre_curso, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_curso'	=> $this->input->post('id_curso[' . $i . ']', true),
						'nombre_curso' 	=> $this->input->post($nombre_curso, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('curso', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('curso', $update, 'id_curso', null, true);
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
			if ($this->master->delete('curso', $chk, 'id_curso')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Curso',
			'subjudul' => 'Importar Curso'
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/matkul/import');
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
			$matkul = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				if ($sheetData[$i][0] != null) {
					$matkul[] = $sheetData[$i][0];
				}
			}

			unlink($file);

			$this->import($matkul);
		}
	}
	public function do_import()
	{
		$data = json_decode($this->input->post('matkul', true));
		$jurusan = [];
		foreach ($data as $j) {
			$jurusan[] = ['nama_matkul' => $j];
		}

		$save = $this->master->create('matkul', $jurusan, true);
		if ($save) {
			redirect('matkul');
		} else {
			redirect('matkul/import');
		}
	}
}
