<?php

namespace App\Http\Controllers\Pages;

use App\Http\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Метод возвращает view главной страницы
     *
     * @return view(pages.home)
     */
    public function index(CourseService $courseSerivce) {
        return view('pages.home', [
            'categories' => $courseSerivce->getCategories()
        ]);
    }
}

