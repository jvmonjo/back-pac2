<?php namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'author', 'date', 'content', 'image', 'category_id'];

    public function getAll() {
        return $this->asArray()
        ->select('news.*, categories.title as category')
        ->join('categories', 'categories.id == news.category_id')
        ->first();
    }

}