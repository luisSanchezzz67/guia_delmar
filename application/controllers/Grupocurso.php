<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GrupoCurso extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Only Administrators are authorized to access this page, <a href="' . base_url('dashboard') . '">Back to main menu</a>', 403, 'Forbidden Access');
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
			'titulo'	=> 'Grupo - Curso',
			'subtitulo' => 'Un Grupo con un Curso'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relacion/grupocurso/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getGrupoCurso(), false);
	}

	public function getGrupoId($id)
	{
		$this->output_json($this->master->getAllGrupo($id));
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'titulo'		=> 'Agregar Curso a Grupo',
			'subtitulo'	=> 'Agregar Datos de Curso a Grupo',
			'curso'	=> $this->master->getCurso()
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relacion/grupocurso/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 			=> $this->ion_auth->user()->row(),
			'titulo'			=> 'Editar Curso de Grupo',
			'subtitulo'		=> 'Editar Datos de Curso de Grupo.',
			'curso'		=> $this->master->getCursoById($id, true),
			'id_curso'		=> $id,
			'all_grupo'	=> $this->master->getAllGrupo(),
			'grupo'		=> $this->master->getGrupoByIdCurso($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('relacion/grupocurso/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function save()
	{
		$method = $this->input->post('method', true);
		$this->form_validation->set_rules('curso_id', 'Course', 'required');
		$this->form_validation->set_rules('grupo_id[]', 'Grupo', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'curso_id' => form_error('curso_id'),
					'grupo_id[]' => form_error('grupo_id[]'),
				]
			];
			$this->output_json($data);
		} else {
			$curso_id 	= $this->input->post('curso_id', true);
			$grupo_id = $this->input->post('grupo_id', true);
			$input = [];
			foreach ($grupo_id as $key => $val) {
				$input[] = [
					'curso_id' 	=> $curso_id,
					'grupo_id'  	=> $val
				];
			}
			if ($method === 'add') {
				$action = $this->master->create('grupo_curso', $input, true);
			} else if ($method === 'edit') {
				$id = $this->input->post('curso_id', true);
				$this->master->delete('grupo_curso', $id, 'curso_id');
				$action = $this->master->create('grupo_curso', $input, true);
			}
			$data['status'] = $action ? TRUE : FALSE;
		}
		$this->output_json($data);
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('grupo_curso', $chk, 'curso_id')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}
}
