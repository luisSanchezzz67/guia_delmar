<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resultado_examen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}

		$this->load->library(['datatables']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('Prueba_model', 'prueba');

		$this->user = $this->ion_auth->user()->row();
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function data()
	{
		$nip_profesor = null;

		if ($this->ion_auth->in_group('Lecturer')) {
			$nip_profesor = $this->user->username;
		}

		$this->output_json($this->prueba->getResultado_examen($nip_profesor), false);
	}

	public function Calificacion($id)
	{
		$this->output_json($this->prueba->Resultado_examenById($id, true), false);
	}

	public function index()
	{
		$data = [
			'user' => $this->user,
			'titulo'	=> 'Examen',
			'subtitulo' => 'Resultados de Examen',
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/resultado');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
	{
		$prueba = $this->prueba->getPruebaById($id);
		$valor = $this->prueba->revisionValor($id);

		$data = [
			'user' => $this->user,
			'titulo'	=> 'Examen',
			'subtitulo' => 'Información de Resultados de Examen',
			'prueba'	=> $prueba,
			'valor'	=> $valor
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('prueba/detail_resultado');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function imprimir($id)
	{
		$this->load->library('Pdf');

		$mhs 	= $this->prueba->getIdEstudiante($this->user->username);
		$resultado 	= $this->prueba->Resultado_examen($id, $mhs->id_estudiante)->row();
		$prueba 	= $this->prueba->getPruebaById($id);

		$data = [
			'prueba' => $prueba,
			'resultado' => $resultado,
			'mhs'	=> $mhs
		];

		$this->load->view('prueba/imprimir', $data);
	}

	public function imprimir_detail($id)
	{
		$this->load->library('Pdf');

		$prueba = $this->prueba->getPruebaById($id);
		$valor = $this->prueba->revisionValor($id);
		$resultado = $this->prueba->Resultado_examenById($id)->result();

		$data = [
			'prueba'	=> $prueba,
			'valor'	=> $valor,
			'resultado'	=> $resultado
		];

		$this->load->view('prueba/imprimir_detail', $data);
	}
}
