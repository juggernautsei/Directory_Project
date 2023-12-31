<?php

namespace App\Models;
use App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = ['category_icon','category_name', 'category_slug'];


	public $timestamps = false;



	public static function getCategoryInfo($id)
    {
        file_put_contents('/var/www/laravelapp/id.txt', $id);
		return Categories::find($id);
	}

	public static function countCategoryListings($id)
    {
		return Listings::where(['cat_id' => $id,'status' => '1'])->count();
	}
}
