<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function tampil_media($file,$width="",$height="") {
	$ret = '';

	$pc_file = explode(".", $file);
	$eks = end($pc_file);

	$eks_video = array("mp4","flv","mpeg");
	$eks_audio = array("mp3","acc");
	$eks_image = array("jpeg","jpg","gif","bmp","png");


	if (!in_array($eks, $eks_video) && !in_array($eks, $eks_audio) && !in_array($eks, $eks_image)) {
		$ret .= '';
	} else {
		if (in_array($eks, $eks_video)) {
			if (is_file("./".$file)) {
				$ret .= '<p><video width="'.$width.'" height="'.$height.'" controls>
                <source src="'.base_url().$file.'" type="video/mp4">
                <source src="'.base_url().$file.'" type="application/octet-stream">Browser tidak support</video></p>';
			} else {
				$ret .= '';
			}
		} 

		if (in_array($eks, $eks_audio)) {
			if (is_file("./".$file)) {
				$ret .= '<p><audio width="'.$width.'" height="'.$height.'" controls>
				<source src="'.base_url().$file.'" type="audio/mpeg">
				<source src="'.base_url().$file.'" type="audio/wav">Browser tidak support</audio></p>';
			} else {
				$ret .= '';
			}
		}

		if (in_array($eks, $eks_image)) {
			if (is_file("./".$file)) {
				$ret .= '<img class="thumbnail w-100" src="'.base_url().$file.'" style="width: '.$width.'; height: '.$height.';">';
			} else {
				$ret .= '';
			}
		}
	}
	

	return $ret;
}

/*Bee functions*/
function get_user($key = null) {
	if (!isset($_SESSION['user_session'])) return false;

	$session = $_SESSION['user_session']; // información de la sesión del usuario actual, regresará siempre falso si no hay dicha sesión

	if (!isset($session['user']) || empty($session['user'])) return false;

	$user = $session['user']; // información de la base de datos o directamente insertada del usuario

	if ($key === null) return $user;

	if (!isset($user[$key])) return false; // regresará falso en caso de no encontrar el key buscado

	// Regresa la información del usuario
	return $user[$key];
}

function get_user_role() {
	return $rol = get_user('rol');
  }
