<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\BaseModel;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	public $validation;

	public $table;

	public $encrypter;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();
		//Servicio para la encriptacion, se usará por ahora en los reportes para que no den errores de 403
		$this->encrypter  = \Config\Services::encrypter();
		$this->encrypter->key = 'u]GVGNEEwdekkp~~[G3A';
		$this->encrypter->driver = 'OpenSSL';
		//Registro del acceso
		if (strlen(base64_decode($this->request->getPost('data'))) < 1) {

			$this->watson($this->request->getIPAddress(), $this->request->uri->getPath(), NULL, $this->request->getUserAgent(), date('Y-m-d h:i:s'), $this->session->get('usuemail'));
		} else {
			$this->watson($this->request->getIPAddress(), $this->request->uri->getPath(), utf8_encode(base64_decode($this->request->getPost('data'))), $this->request->getUserAgent(), date('Y-m-d h:i:s'), $this->session->get('usuemail'));
		}
	}
	/* Metodo que permite la carga del template para los index */
	/*Metodo para llamar la vista de un modulo*/
	public function loadTemplate($module)
	{
		echo view('template/header');
		if ($module != '/login') {
			echo view('template/nav_bar');
		}
		echo view($module . '/content');
		echo view('template/footer');
		echo view($module . '/footer');
	}
	/**
	 * Metodo que permite registrar los movimientos de la app
	 * por parte del usuario, esto permite un control mas exhaustivo
	 * de la app
	 *
	 * @var access_ip : String => La IP de acceso del usuario
	 * @var url_request : String => El recurso (Controlador) que intenta acceder
	 * @var data_request : String => Datos Via JSON (Envio de formularios) en caso de darse, puede ser NULL
	 * @var user_agent : String => El navegador que utiliza el usuario
	 * @var access_date: TIMESTAMP => Fecha y hora de acceso
	 * @var user_access: String => Usuario que solicita el recurso
	 */
	public function watson(String $access_ip, String $url_request, String $data_request = NULL, String $user_agent, $access_date, String $user_access = NULL)
	{
		$model = new BaseModel();
		$query = $model->recordLog(array(
			'access_ip' => $access_ip,
			'url_request' => $url_request,
			'data_request' => $data_request,
			'user_agent' => $user_agent,
			'access_date' => $access_date,
			'user_access' => $user_access
		));
		if ($query) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*Funcion que formatea fechas*/
	public function formatearFecha($fecha)
	{
		$date1 = explode('-', $fecha);
		$date2 = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
		return $date2;
	}

	/**
	 * Metodo que permite generar tablas debidamente formateadas
	 * usando Bootstrap4
	 * 
	 *
	 * @var heading : Array  => Arreglo con las cabeceras del usuario
	 * @var data    : Data   => Los datos de la tabla puestos en un arreglo de arreglos
	 * 
	 */
	public function generarTabla(array $heading, array $data)
	{
		$this->table = new \CodeIgniter\View\Table();

		$template = [
			'table_open'        => '<table class="table tabla table-light table-striped text-center tabla">',

			'thead_open'        => '<thead>',
			'thead_close'       => '</thead>',

			'heading_row_start' => '<tr>',
			'heading_row_end'   => '</tr>',
			'heading_cell_start' => '<th>',
			'heading_cell_end'      => '</th>',

			'tfoot_open'             => '<tfoot>',
			'tfoot_close'            => '</tfoot>',

			'footing_row_start'      => '<tr>',
			'footing_row_end'        => '</tr>',
			'footing_cell_start'     => '<td>',
			'footing_cell_end'       => '</td>',

			'tbody_open'            => '<tbody>',
			'tbody_close'           => '</tbody>',

			'row_start'             => '<tr>',
			'row_end'               => '</tr>',
			'cell_start'            => '<td>',
			'cell_end'              => '</td>',

			'row_alt_start'         => '<tr>',
			'row_alt_end'           => '</tr>',
			'cell_alt_start'        => '<td>',
			'cell_alt_end'          => '</td>',

			'table_close'           => '</table>'
		];
		$this->table->setTemplate($template);
		$this->table->setHeading($heading);
		return $this->table->generate($data);
	}
	public function generarTablaReporte(array $heading, array $data)
	{
		$this->table = new \CodeIgniter\View\Table();

		$template = [
			'table_open'        => '<table class="table table-light table-striped text-center">',

			'thead_open'        => '<thead>',
			'thead_close'       => '</thead>',

			'heading_row_start' => '<tr>',
			'heading_row_end'   => '</tr>',
			'heading_cell_start' => '<th>',
			'heading_cell_end'      => '</th>',

			'tfoot_open'             => '<tfoot>',
			'tfoot_close'            => '</tfoot>',

			'footing_row_start'      => '<tr>',
			'footing_row_end'        => '</tr>',
			'footing_cell_start'     => '<td>',
			'footing_cell_end'       => '</td>',

			'tbody_open'            => '<tbody>',
			'tbody_close'           => '</tbody>',

			'row_start'             => '<tr>',
			'row_end'               => '</tr>',
			'cell_start'            => '<td>',
			'cell_end'              => '</td>',

			'row_alt_start'         => '<tr>',
			'row_alt_end'           => '</tr>',
			'cell_alt_start'        => '<td>',
			'cell_alt_end'          => '</td>',

			'table_close'           => '</table>'
		];
		$this->table->setTemplate($template);
		$this->table->setHeading($heading);
		return $this->table->generate($data);
	}
}
