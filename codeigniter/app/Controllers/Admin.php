<?php namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Admin extends BaseController
{
	public function news()
	{
        $crud = new GroceryCrud();
        $crud->setTable('news');
        $crud->displayAs('category_id','Category');
        $crud->setRelation('category_id','categories','{title}');
	    $output = $crud->render();

		return $this->_exampleOutput($output);
	}

	public function categories() {
        $crud = new GroceryCrud();
        $crud->setTable('categories');
        $crud->setSubject('Category');

        $output = $crud->render();

        return $this->_exampleOutput($output);
    }

   
    private function _exampleOutput($output = null) {
        return view('admin', (array)$output);
    }


}
