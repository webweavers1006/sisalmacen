<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------
	/*Vista del menu principal*/
	public function dashboard()
	{
		//Validacion para poner el sistema en mantenimiento
		/*if($this->session->get('usurol') == 4){
			return redirect()->to('/503');
		}*/
		if ($this->session->get('logged')) {
			echo $this->loadTemplate('/dashboard');
		} else {
			return redirect()->to('/');
		}
	}
	/*Vista para los requerimientos*/
	public function requermientos()
	{
		if ($this->session->get('logged')) {
			echo $this->loadTemplate('/catalog');
		} else {
			return redirect()->to('/');
		}
	}
	/*Vista de Login*/
	public function login()
	{
		if ($this->session->get('logged')) {
			return redirect()->to('/inicio');
		} else {
			echo view('template/header.php');
			echo view('login/content.php');
			echo view('login/footer.php');
		}
	}
	/*Vista de Admin*/
	public function admin()
	{
		if ($this->session->get('logged') && $this->session->get('usurol') == 1 or $this->session->get('usurol') == 2) {


			echo $this->loadTemplate('/admin');
		} else {
			return redirect()->to('/403');
		}
	}
	/*Vista de prohibido*/
	public function forbidden()
	{
		if ($this->session->get('logged')) {
			echo view('errors/html/error_403.php');
		} else {
			return redirect()->to('/');
		}
	}
	/*Registro de nuevo proveedor*/
	public function newProvider()
	{
		echo view('proveedores/new_provider');
	}

	/*Vista de prohibido*/
	public function notFound()
	{
		if ($this->session->get('logged')) {
			echo view('errors/html/error_404.php');
		} else {
			return redirect()->to('/');
		}
	}
	//Vista para el mantenimiento del sistema
	public function mantenimiento()
	{
		return view('errors/html/error_503.php');
	}
	//Vista para la recuperacion de contraseña
	public function recuperarPass()
	{
		echo view('template/header');
		echo view('forget/content');
		echo view('forget/footer');
	}

	//Vista para el reporte de consolidados
	public function consolidados($id = NULL)
	{
		if ($this->session->get('logged') and !is_null($id) and $this->session->get('usurol') == 1 or $this->session->get('usurol') == 2 or $this->session->get('usurol') == 3) {
			return $this->loadTemplate('reportes/consolidados/' . strval($id));
		} else {
			return redirect()->to('/403');
		}
	}
}

// {"usuemail":"freddy.torres@sapi.gob.ve","usupass":"$2y$10$w49Os5A1eUO6uGT69cB4deOjnp9LHe2uIafW9VWeYk6"},