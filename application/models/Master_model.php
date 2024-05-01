<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function __construct()
    {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    public function create($table, $data, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->insert($table, $data);
        } else {
            $insert = $this->db->insert_batch($table, $data);
        }
        return $insert;
    }

    public function update($table, $data, $pk, $id = null, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->update($table, $data, array($pk => $id));
        } else {
            $insert = $this->db->update_batch($table, $data, $pk);
        }
        return $insert;
    }

    public function delete($table, $data, $pk)
    {
        $this->db->where_in($pk, $data);
        return $this->db->delete($table);
    }

    /**
     * Data Clases
     */

    public function getDataClase()
    {
        $this->datatables->select('id_clase, nombre_clase, id_grupo, nombre_grupo');
        $this->datatables->from('clase');
        $this->datatables->join('grupo', 'id_grupo=grupo_id', '');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_clase, nombre_clase, id_grupo, nombre_grupo');
        return $this->datatables->generate();
    }

    public function getClaseById($id)
    {
        $this->db->where_in('id_clase', $id);
        $this->db->order_by('nombre_clase');
        $query = $this->db->get('clase')->result();
        return $query;
    }

    /**
     * Data grupo
     */

    public function getDataGrupo()
    {
        $this->datatables->select('id_grupo, nombre_grupo, curso_id');
        $this->datatables->from('grupo');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_grupo, nombre_grupo, curso_id');
        return $this->datatables->generate();
    }

    public function getgrupoById($id)
    {
        $this->db->select('id_grupo, nombre_grupo, curso_id');  // Especifica los campos que deseas recuperar
        $this->datatables->from('grupo');
        $this->db->where_in('id_grupo', $id);
        $this->db->order_by('nombre_grupo');
        $query = $this->db->get('grupo')->result();
        return $query;
    }


    /**
     * Data Estudiante
     */

    public function getDataEstudiante()
    {
        $this->datatables->select('a.id_estudiante, a.nombre, a.nim, a.email, b.nombre_clase, c.nombre_grupo');
        $this->datatables->select('(SELECT COUNT(id) FROM users WHERE username = a.nim OR email = a.email) AS ada');
        $this->datatables->from('estudiante a');
        $this->datatables->join('clase b', 'a.clase_id=b.id_clase');
        $this->datatables->join('grupo c', 'b.grupo_id=c.id_grupo');
        return $this->datatables->generate();
    }

    public function getEstudianteById($id)
    {
        $this->db->select('*');
        $this->db->from('estudiante');
        $this->db->join('clase', 'clase_id=id_clase');
        $this->db->join('grupo', 'grupo_id=id_grupo');
        $this->db->where(['id_estudiante' => $id]);
        return $this->db->get()->row();
    }

    public function getGrupo()
    {
        $this->db->select('id_grupo, nombre_grupo');
        $this->db->from('clase');
        $this->db->join('grupo', 'grupo_id=id_grupo');
        $this->db->order_by('nombre_grupo', 'ASC');
        $this->db->group_by('id_grupo');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllGrupo($id = null)
    {
        if ($id === null) {
            $this->db->order_by('nombre_grupo', 'ASC');
            return $this->db->get('grupo')->result();
        } else {
            $this->db->select('grupo_id');
            $this->db->from('grupo_curso');
            $this->db->where('curso_id', $id);
            $grupo = $this->db->get()->result();
            $id_grupo = [];
            foreach ($grupo as $j) {
                $id_grupo[] = $j->grupo_id;
            }
            if ($id_grupo === []) {
                $id_grupo = null;
            }

            $this->db->select('*');
            $this->db->from('grupo');
            $this->db->where_not_in('id_grupo', $id_grupo);
            $curso = $this->db->get()->result();
            return $curso;
        }
    }

    public function getClaseByGrupo($id)
    {
        $query = $this->db->get_where('clase', array('grupo_id' => $id));
        return $query->result();
    }

    /**
     * Data Profesor
     */

    public function getDataProfesor()
    {
        $this->datatables->select('a.id_profesor,a.nip, a.nombre_profesor, a.email, a.curso_id, b.nombre_curso, (SELECT COUNT(id) FROM users WHERE username = a.nip OR email = a.email) AS ada');
        $this->datatables->from('profesor a');
        $this->datatables->join('curso b', 'a.curso_id=b.id_curso');
        return $this->datatables->generate();
    }

    public function getProfesorById($id)
    {
        $query = $this->db->get_where('profesor', array('id_profesor' => $id));
        return $query->row();
    }

    /**
     * Data Cursos
     */

    public function getDataCurso()
    {
        $this->datatables->select('id_curso, nombre_curso');
        $this->datatables->from('curso');
        return $this->datatables->generate();
    }

    public function getAllCurso()
    {
        return $this->db->get('curso')->result();
    }

    public function getCursoById($id, $single = false)
    {
        if ($single === false) {
            $this->db->where_in('id_curso', $id);
            $this->db->order_by('nombre_curso');
            $query = $this->db->get('curso')->result();
        } else {
            $query = $this->db->get_where('curso', array('id_curso' => $id))->row();
        }
        return $query;
    }

    /**
     * Data Clase Profesor
     */

    public function getClaseProfesor()
    {
        $this->datatables->select('clase_profesor.id, profesor.id_profesor, profesor.nip, profesor.nombre_profesor, GROUP_CONCAT(clase.nombre_clase) as clase');
        $this->datatables->from('clase_profesor');
        $this->datatables->join('clase', 'clase_id=id_clase');
        $this->datatables->join('profesor', 'profesor_id=id_profesor');
        $this->datatables->group_by('profesor.nombre_profesor');
        return $this->datatables->generate();
    }

    public function getAllProfesor($id = null)
    {
        $this->db->select('profesor_id');
        $this->db->from('clase_profesor');
        if ($id !== null) {
            $this->db->where_not_in('profesor_id', [$id]);
        }
        $profesor = $this->db->get()->result();
        $id_profesor = [];
        foreach ($profesor as $d) {
            $id_profesor[] = $d->profesor_id;
        }
        if ($id_profesor === []) {
            $id_profesor = null;
        }

        $this->db->select('id_profesor, nip, nombre_profesor');
        $this->db->from('profesor');
        $this->db->where_not_in('id_profesor', $id_profesor);
        return $this->db->get()->result();
    }


    public function getAllClase()
    {
        $this->db->select('id_clase, nombre_clase, nombre_grupo');
        $this->db->from('clase');
        $this->db->join('grupo', 'grupo_id=id_grupo');
        $this->db->order_by('nombre_clase');
        return $this->db->get()->result();
    }

    public function getClaseByProfesor($id)
    {
        $this->db->select('clase.id_clase');
        $this->db->from('clase_profesor');
        $this->db->join('clase', 'clase_profesor.clase_id=clase.id_clase');
        $this->db->where('profesor_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }
    /**
     * Data Grupo Curso
     */

    public function getGrupoCurso()
    {
        $this->datatables->select('grupo_curso.id, curso.id_curso, curso.nombre_curso, grupo.id_grupo, GROUP_CONCAT(grupo.nombre_grupo) as nombre_grupo');
        $this->datatables->from('grupo_curso');
        $this->datatables->join('curso', 'curso_id=id_curso');
        $this->datatables->join('grupo', 'grupo_id=id_grupo');
        $this->datatables->group_by('curso.nombre_curso');
        return $this->datatables->generate();
    }

    public function getCurso($id = null)
    {
        $this->db->select('curso_id');
        $this->db->from('grupo_curso');
        if ($id !== null) {
            $this->db->where_not_in('curso_id', [$id]);
        }
        $curso = $this->db->get()->result();
        $id_curso = [];
        foreach ($curso as $d) {
            $id_curso[] = $d->curso_id;
        }
        if ($id_curso === []) {
            $id_curso = null;
        }

        $this->db->select('id_curso, nombre_curso');
        $this->db->from('curso');
        $this->db->where_not_in('id_curso', $id_curso);
        return $this->db->get()->result();
    }

    public function getGrupoByIdCurso($id)
    {
        $this->db->select('grupo.id_grupo');
        $this->db->from('grupo_curso');
        $this->db->join('grupo', 'grupo_curso.grupo_id=grupo.id_grupo');
        $this->db->where('curso_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    // Lecciones

    public function getDataLecciones()
    {
        // $sql = 
        // 'SELECT 
        // l.*, 
        // p.nombre_profesor AS nombre_profesor, 
        // c.nombre_curso AS curso 
        // FROM lecciones l
        // LEFT JOIN profesor p ON p.id_profesor = l.id_profesor
        // LEFT JOIN curso c ON c.id_curso = l.id_curso
        // ORDER BY l.id DESC';
    $this->datatables->select('l.id, p.nombre_profesor, c.nombre_curso, l.titulo, l.video, l.status, l.fecha_disponible');
    $this->datatables->from('lecciones l');
    $this->datatables->join('profesor p', 'p.id_profesor = l.id_profesor', 'left');
    $this->datatables->join('curso c', 'c.id_curso = l.id_curso', 'left');
    $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id, nombre_profesor, nombre_curso, titulo, l.video, l.status,l.fecha_disponible');

    //$this->datatables->order_by('l.id', 'DESC');
    return $this->datatables->generate();
    }
    public function getLeccionById($id)
    {
        $query = $this->db->get_where('leccion', array('id_leccion' => $id));
        return $query->row();
    }
}
