<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NewsModel;
use App\Models\CategoryModel;

class ApiCategory extends ResourceController
{
    protected $modelName = 'App\Models\NewsModel';
    protected $format    = 'json';


    public function show($category = null, $page = null)
    {
        $db      = \Config\Database::connect();

        // obtenim la id de la categoria
        $categories = $db->table('categories');
        $categories->where('title', $category);
        $queryCategory   = $categories->get();
        $catResult = $queryCategory->getResult();

        if (!$catResult) {
            return $this->genericResponse(null, "Category doesn't exist", 404);
        }

        $id = $catResult[0]->id;
   
        // obtenim les notícies amb eixa id de categoria
        $news = $db->table('news');
        $news->where('category_id', $id);

        if ($page) {
            $news->limit(10, ($page - 1) * 10);
        }
        
        $queryNews   = $news->get();
        $newsResult = $queryNews->getResult();

        return $this->genericResponse($newsResult, null, 200);
    }



    private function genericResponse($data, $msg, $code){

        if ($code == 200) {
            return $this->respond(array(
                'data' => $data,
                'code' => $code
            ));
        } else {
            return $this->respond(array(
                'message' => $msg,
                'code' => $code
            ));
        }
    }
}