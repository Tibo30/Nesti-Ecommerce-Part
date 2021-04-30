<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url', 'assets', 'form'];
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session = \Config\Services::session();
		$this->twig = new \Kenjis\CI4Twig\Twig([
			'debug' => true,
			'functions' => ['urlJS'],
		]);
		$this->twig->addGlobal("session", $this->session);
	}

	// public function renderTemplate(string $page,array $data = [])
	// {
	//     if ( ! is_file(APPPATH.'/Views/'.$page.'.php'))
	// {
	//     // Whoops, we don't have a page for that!
	//     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
	// }

	// $i = strrpos($page,"/");
	// $title = str_replace('-',' ', substr($page, $i +1));
	// $data['title'] = ucwords($title);

	// // echo view('templates/header', $data);
	// $this->twig->display('templates/header', $data);
	// // echo view(''.$page, $data);
	// // $data2['test']='<h1>Balise Test</h1>';
	// // $this->twig->display('test',$data2);
	// $this->twig->display(''.$page,$data);
	// // echo view('templates/footer', $data);
	// $this->twig->display('templates/footer', $data);
	// }



}
