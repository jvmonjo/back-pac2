<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NewsModel;
use App\Models\CategoryModel;

class ApiNews extends ResourceController
{
    protected $modelName = 'App\Models\NewsModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->genericResponse($this->model->findAll(), null, 200);
    }


    public function show($id = null)
    {
        if ($id == null) {
            return $this->genericResponse(null, "An error ocurred", 500);
        }

        $news = $this->model->find($id);

        if (!$news) {
            return $this->genericResponse(null, "That news doesn't exist", 404);
        }


        return $this->genericResponse($news, null, 200);
    }

    public function category($id = null)
    {
        if ($id == null) {
            return $this->genericResponse(null, "An error ocurred", 500);
        }

        $news = $this->model->find($id);

        if (!$news) {
            return $this->genericResponse(null, "That news doesn't exist", 404);
        }


        return $this->genericResponse('category' . $id, null, 200);
    }


    public function create()
    {
 
        $news = new NewsModel();
        $category = new CategoryModel();
 
        if ($this->validate('news')) {
 
            if (!$this->request->getPost('category_id'))
                return $this->genericResponse(null, array("category_id" => "Category doesn't exist"), 500);
 
            if (!$category->get($this->request->getPost('category_id'))) {
                return $this->genericResponse(null, array("category_id" => "Category doesn't exist"), 500);
            }

            $data = null;

            if ($this->request->getPost('date')) {
                $data = [
                    'title' => $this->request->getPost('title'),
                    'author' => $this->request->getPost('author'),
                    'date' => $this->request->getPost('date'),
                    'content' => $this->request->getPost('content'),
                    'category_id' => $this->request->getPost('category_id'),
                    'image' => $this->request->getPost('image'),
                ];
            } else {
                $data = [
                    'title' => $this->request->getPost('title'),
                    'author' => $this->request->getPost('author'),
                    'content' => $this->request->getPost('content'),
                    'category_id' => $this->request->getPost('category_id'),
                    'image' => $this->request->getPost('image'),
                ];
            }
            

 
            $id = $news->insert($data);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }


    public function update($id = null)
    {
 
        $news = new NewsModel();
        $category = new CategoryModel();

        $exists = $this->model->find($id);

        if (!$exists) {
            return $this->genericResponse(null, "That news doesn't exist", 404);
        }

        $formData = $this->request->getRawInput();


        if ($formData['category_id'] && !$category->get($formData['category_id'])) {
            return $this->genericResponse(null, array("category_id" => "Category doesn't exist"), 500);
        }
 
        if ($this->validate('news')) {

            $data = [
                'title' => $formData['title'],
                'author' => $formData['author'],
                'date' => $formData['date'],
                'content' => $formData['content'],
                'category_id' => $formData['category_id'],
                'image' => $formData['image'],
            ];
            

 
            $news->update($id, $data);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }


    public function delete($id = null)
    {
        if ($id != null) {
            $this->model->delete($id);
            return $this->genericResponse("News $id successfully deleted", null, 200);
        }
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