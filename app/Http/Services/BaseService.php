<?php

namespace App\Http\Services;


abstract class BaseService {

    public $model;


    public function all() {

        return $this->model->all();

    }

    public function create(array $input) {

        return $this->model->create($input);

    }

    public function find($id) {

        return $this->model->find($id);

    }

    public function update($id, array $input) {

        return $this->model->update($id,$input);

    }

    public function destroy($id) {

        return $this->model->destroy($id);

    }
}