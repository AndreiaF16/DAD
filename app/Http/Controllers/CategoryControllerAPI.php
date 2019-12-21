<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Http\Resources\Category as CategoryResource;
use App\User;
use Illuminate\Support\Facades\Auth;

class CategoryControllerAPI extends Controller
{
    public function CategoriesExpense()
    {
        $categories = Category::where("type","=","e")->get();
        /*foreach ($categories as $key => $val) {
            $categories[$key]["name"] = ucfirst($val->name);
        }*/
        return CategoryResource::collection(Category::where("type","=","e")->get());
    }
}