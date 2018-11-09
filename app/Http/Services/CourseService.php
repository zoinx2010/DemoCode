<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 01.11.2018
 * Time: 12:12
 */

namespace App\Http\Services;



use App\Models\Category;
use App\Models\Contract;
use App\Models\Course;
use Carbon\Carbon;

class CourseService extends BaseService {

    public function __construct(Course $course) {

        $this->model = $course;

    }

    /**
     * Get all categories of courses
     */
    public function getCategories() {

        return Category::all();

    }

    /**
     * Get courses by category
     */
    public function getByCategory($id) {

        $uniqCourses = [];
        $courses = Course::where('category_id', $id)->where('start_date', '>', Carbon::now())->orderBy('start_date', 'asc')->get();

        foreach ($courses as $course) {

            if(!array_key_exists($course->name, $uniqCourses)) {
                $uniqCourses[$course->name] = $course;
            }

        }

        ksort($uniqCourses);

        return $uniqCourses;


    }

    /**
     * Retruns category of single course
     */
    public function getCategory($id) {
        return Course::find($id)->category();
    }

    /**
     * Returns array courses by name and not expired
     *
     * @return array(Course)
     */
    public function getManyByName($name) {

        return Course::where('start_date', '>', Carbon::now())->where('name',$name)->get();
    }

    /**
     * Return next lever course
     *
     * @return Course
     */
    public function getNextLevel($name) {

        $course = Course::where('name',$name)->first();

        $found = false;
        $levels = ['A 1.1','A 1.2','A 2.1','A 2.2','B 1.1','B 1.2','B 2.1','B 2.2','Testduf'];

        foreach ($levels as $level) {

            if($found) {
                return Course::where('name', $level)->first();
            }

            if(in_array($course->name, $levels)) {
                $found = true;
            }

        }

        return null;

    }

}