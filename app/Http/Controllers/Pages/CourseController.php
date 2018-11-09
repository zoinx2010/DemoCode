<?php

namespace App\Http\Controllers\Pages;

use App\Http\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseService $courseSerivce)
    {
        return view('course.index', [
           'courses' => $courseSerivce->all()
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CourseService $courseSerivce, $id)
    {
        $course = $courseSerivce->find($id);

        return view('course.show', [
            'course' => $course,
            'category' => $courseSerivce->getCategory($id),
            'similars' => $courseSerivce->getManyByName($course->name),
            'rules' => config('rules'),
            'konf' => config('konf'),
        ]);

    }

    /**
     * Returns categories of courses
     *
     * @return Array(Category)
     */
    public function getCategories(CourseService $courseSerivce) {

        return view('course.categories', [
            'categories' => $courseSerivce->getCategories()
        ]);

    }



}
