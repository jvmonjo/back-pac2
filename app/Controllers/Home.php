<?php namespace App\Controllers;

use App\Models\NewsModel;


class Home extends BaseController
{

	public function index()
	{

		$newsModel = new NewsModel();
		$newsArray = $newsModel->findAll();
		$data['news'] = $newsArray;

		$parser = \Config\Services::parser();


		return $parser->setData($data)
             ->render('home');

	}

	//--------------------------------------------------------------------

}
