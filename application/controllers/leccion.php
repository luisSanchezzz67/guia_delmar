<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

class leccion extends CI_Controller
{
	private $id  = null;
	private $rol = null;
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
		$this->load->library('pagination');

		// $this->id  = get_user('id');
		// $this->rol = get_user_role();
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
			'titulo'	=> 'Lecciones',
			'subtitulo' => 'Datos de las lecciones',
			//'lecciones' => 	$this->master->all_paginated()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/leccion/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataLecciones(), false);
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'titulo'	=> 'Nueva Lección',
			'subtitulo' => 'Agregar nueva lección',
			'curso'	=> $this->master->getAllCurso()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('direccion/leccion/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	// public function edit()
	// {
	// 	$chk = $this->input->post('checked', true);
	// 	if (!$chk) {
	// 		redirect('admin/clase');
	// 	} else {
	// 		$clase = $this->master->getClaseById($chk);
	// 		$data = [
	// 			'user' 		=> $this->ion_auth->user()->row(),
	// 			'titulo'		=> 'Editar Clase',
	// 			'subtitulo'	=> 'Editar Datos de Clase',
	// 			'grupo'	=> $this->master->getAllGrupo(),
	// 			'clase'		=> $clase
	// 		];
	// 		$this->load->view('_templates/dashboard/_header.php', $data);
	// 		$this->load->view('direccion/clase/edit');
	// 		$this->load->view('_templates/dashboard/_footer.php');
	// 	}
	// }

	public function save()
	{
		$method 	= $this->input->post('method', true);
		$id_leccion	= $this->input->post('id_leccion', true);
		$curso 	= $this->input->post('curso', true);
		$titulo_leccion 		= $this->input->post('titulo_leccion', true);
		$video_leccion = $this->input->post('video_leccion', true);
		$contenido_leccion 		= $this->input->post('contenido_leccion', true);
		$estado_leccion 		= $this->input->post('estado_leccion', true);
		$fecha_inicio 		= $this->input->post('fecha_inicio', true);
		$fecha_terminacion 		= $this->input->post('fecha_terminacion', true);
		if ($method == 'add') {
			$l_fecha_inicio = '|is_unique[lecciones.fecha_inicio]';
			$l_fecha_terminacion = '|is_unique[lecciones.fecha_terminacion]';

		} else {
			$dbdata 	= $this->master->getLeccionById($id_leccion);
			// $u_nip		= $dbdata->nip === $nip ? "" : "|is_unique[profesor.nip]";
			// $u_email	= $dbdata->email === $email ? "" : "|is_unique[profesor.email]";
		}
		$this->form_validation->set_rules('curso', 'Curso', 'required');
		$this->form_validation->set_rules('titulo_leccion', 'Titulo', 'required|trim|min_length[8]|max_length[12]');
		$this->form_validation->set_rules('video_leccion', 'Video', 'required|trim|min_length[3]|max_length[80]');
		$this->form_validation->set_rules('contenido_leccion', 'Contenido', 'required|trim|min_length[3]|max_length[150]');
		$this->form_validation->set_rules('estado_leccion', 'Estado', 'required|trim|min_length[3]|max_length[50]');
		//$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $u_email . $u_emailEstudiante);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'curso' => form_error('curso'),
					'titulo' => form_error('titulo_leccion'),
					'video' => form_error('video_leccion'),
					'contenido' => form_error('contenido_leccion'),
					'status' => form_error('estado_leccion'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'id_curso' 	=> $curso,
				'titulo'			=> $titulo_leccion,
				'video' 	=> $video_leccion,
				'contenido' 	=> $contenido_leccion,
				'status' 		=> $estado_leccion,
			];
			if ($method === 'add') {
				$action = $this->master->create('lecciones', $input);
			} else if ($method === 'edit') {
				$action = $this->master->update('lecciones', $input, 'id', $id_leccion);
			}

			if ($action) {
				$this->output_json(['status' => true]);
			} else {
				$this->output_json(['status' => false]);
			}
		}
	}

	// public function delete()
	// {
	// 	$chk = $this->input->post('checked', true);
	// 	if (!$chk) {
	// 		$this->output_json(['status' => false]);
	// 	} else {
	// 		if ($this->master->delete('clase', $chk, 'id_clase')) {
	// 			$this->output_json(['status' => true, 'total' => count($chk)]);
	// 		}
	// 	}
	// }

	// public function clase_by_grupo($id)
	// {
	// 	$data = $this->master->getClaseByGrupo($id);
	// 	$this->output_json($data);
	// }

	// public function import($import_data = null)
	// {
	// 	$data = [
	// 		'user' => $this->ion_auth->user()->row(),
	// 		'judul'	=> 'Clase',
	// 		'subjudul' => 'Importar Clase',
	// 		'jurusan' => $this->master->getAllJurusan()
	// 	];
	// 	if ($import_data != null) $data['import'] = $import_data;

	// 	$this->load->view('_templates/dashboard/_header', $data);
	// 	$this->load->view('master/kelas/import');
	// 	$this->load->view('_templates/dashboard/_footer');
	// }

	// public function preview()
	// {
	// 	$config['upload_path']		= './uploads/import/';
	// 	$config['allowed_types']	= 'xls|xlsx|csv';
	// 	$config['max_size']			= 2048;
	// 	$config['encrypt_name']		= true;

	// 	$this->load->library('upload', $config);

	// 	if (!$this->upload->do_upload('upload_file')) {
	// 		$error = $this->upload->display_errors();
	// 		echo $error;
	// 		die;
	// 	} else {
	// 		$file = $this->upload->data('full_path');
	// 		$ext = $this->upload->data('file_ext');

	// 		switch ($ext) {
	// 			case '.xlsx':
	// 				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	// 				break;
	// 			case '.xls':
	// 				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
	// 				break;
	// 			case '.csv':
	// 				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
	// 				break;
	// 			default:
	// 				echo "Archivo de extensión desconocida";
	// 				die;
	// 		}

	// 		$spreadsheet = $reader->load($file);
	// 		$sheetData = $spreadsheet->getActiveSheet()->toArray();
	// 		$data = [];
	// 		for ($i = 1; $i < count($sheetData); $i++) {
	// 			$data[] = [
	// 				'clase' => $sheetData[$i][0],
	// 				'grupo' => $sheetData[$i][1]
	// 			];
	// 		}

	// 		unlink($file);

	// 		$this->import($data);
	// 	}
	// }
	// public function do_import()
	// {
	// 	$input = json_decode($this->input->post('data', true));
	// 	$data = [];
	// 	foreach ($input as $d) {
	// 		$data[] = ['nama_kelas' => $d->kelas, 'jurusan_id' => $d->jurusan];
	// 	}

	// 	$save = $this->master->create('kelas', $data, true);
	// 	if ($save) {
	// 		redirect('kelas');
	// 	} else {
	// 		redirect('kelas/import');
	// 	}
	// }
}
