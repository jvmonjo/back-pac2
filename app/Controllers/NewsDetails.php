<?php namespace App\Controllers;

use App\Models\NewsModel;


class NewsDetails extends BaseController
{

	public function show($id)
	{

		$newsModel = new NewsModel();
		$news = $newsModel->find($id);

		// var_dump($news);

		$data = $news;

		$parser = \Config\Services::parser();


		return $parser->setData($data)
			 ->render('news-details');
			 

	}

	//--------------------------------------------------------------------

}
