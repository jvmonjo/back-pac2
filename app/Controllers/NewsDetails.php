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
		$data['baseurl'] = getenv('app.baseURL');
		$data['date'] = date("d-m-Y", strtotime($data['date']));

		return view('news-details', $data);
			 
	}

	//--------------------------------------------------------------------

}
