<?php
defined('BASEPATH') or exit('No se permite el acceso directo al script');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		}
		$this->load->model('Dashboard_model', 'dashboard');
		$this->user = $this->ion_auth->user()->row();
	}

	public function admin_box()
	{
		$box = [
			[
				'box' 		=> 'yellow',
				'total' 	=> $this->dashboard->total('grupo'),
				'title'		=> 'grupo',
				'text'      => 'Grupos',
				'icon'		=> 'th-large'
			],
			[
				'box' 		=> 'green',
				'total' 	=> $this->dashboard->total('clase'),
				'title'		=> 'clase',
				'text'      => 'Clase',
				'icon'		=> 'building-o'
			],
			[
				'box' 		=> 'blue',
				'total' 	=> $this->dashboard->total('profesor'),
				'title'		=> 'profesor',
				'text'      => 'Profesores',
				'icon'		=> 'users'
			],
			[
				'box' 		=> 'red',
				'total' 	=> $this->dashboard->total('estudiante'),
				'title'		=> 'estudiante',
				'text'      => 'Estudiantes',
				'icon'		=> 'graduation-cap'
			],
			[
				'box' 		=> 'maroon',
				'total' 	=> $this->dashboard->total('curso'),
				'title'		=> 'curso',
				'text'      => 'Cursos',
				'icon'		=> 'th'
			],
			[
				'box' 		=> 'aqua',
				'total' 	=> $this->dashboard->total('tb_banco_preguntas'),
				'title'		=> 'banco_preguntas',
				'text'      => 'Preguntas',
				'icon'		=> 'file-text'
			],
			[
				'box' 		=> 'purple',
				'total' 	=> $this->dashboard->total('h_prueba'),
				'title'		=> 'resultado_examen',
				'text'      => 'Resultados Generados',
				'icon'		=> 'file'
			],
			[
				'box' 		=> 'olive',
				'total' 	=> $this->dashboard->total('users'),
				'title'		=> 'users',
				'text'      => 'Usuarios del Sistema',
				'icon'		=> 'key'
			],
		];
		$info_box = json_decode(json_encode($box), FALSE);
		return $info_box;
	}

	public function index()
	{
		$user = $this->user;
		$data = [
			'user' 		=> $user,
			'titulo'		=> 'Dashboard',
			'subtitulo'	=> 'Datos de Aplicación',
		];

		if ($this->ion_auth->is_admin()) {
			$data['info_box'] = $this->admin_box();
		} elseif ($this->ion_auth->in_group('Lecturer')) {
			$curso = ['curso' => 'profesor.curso_id=curso.id_curso'];
			$data['profesor'] = $this->dashboard->get_where('profesor', 'nip', $user->username, $curso)->row();

			$clase = ['clase' => 'clase_profesor.clase_id=clase.id_clase'];
			$data['clase'] = $this->dashboard->get_where('clase_profesor', 'profesor_id', $data['profesor']->id_profesor, $clase, ['nombre_clase' => 'ASC'])->result();
		} else {
			$join = [
				'clase b' 	=> 'a.clase_id = b.id_clase',
				'grupo c'	=> 'b.grupo_id = c.id_grupo'
			];
			$data['estudiante'] = $this->dashboard->get_where('estudiante a', 'nim', $user->username, $join)->row();
		}

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('dashboard');
		$this->load->view('_templates/dashboard/_footer.php');
	}
}
