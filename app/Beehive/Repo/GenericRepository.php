<?php

namespace Beehive\Repo;

abstract class GenericRepository implements Repository {
    protected $model;

    protected function createPaginator($page, $limit) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        return $result;
    }

    protected function totalItems() {
        return $this->model->count();
    }

    public function all($with_key_value=false, $key='', $value='') {
        if ($with_key_value) {
            return $this->model->orderBy('id')->get()->lists($value, $key);
        }
        return $this->model->orderBy('id')->get()->all();
    }

    public function get($id) {
        return $this->model->find($id);
    }

    public function getByPage($page=1, $limit=10) {
        $limit = $limit < 10 ?: 10;
        $result = $this->createPaginator($page, $limit);
        $items = $this->model
            ->orderBy('id')
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->items = $items->all();
        $result->totalItems = $this->totalItems();

        return $result;
    }

    public function create(array $data) {
        $item = $this->model->create($data);
        return $item;
    }

    public function update($id, array $data) {
        if (!$item = $this->get($id)) {
            return null;
        }

        $item = $item->fill($data);
        $item->save();

        return $item;
    }

    public function delete($id) {
        if ($item = $this->get($id)) {
            $item->delete($id);

            return true;
        }
        return false;
    }

    public function newModelInstance(array $data=[]){
        return $this->model->newInstance($data);
    }
}
