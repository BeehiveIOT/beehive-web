<?php

namespace Beehive\Repo;

/**
 * These is the main interface that shows
 * all methods a repository should have
 */
interface Repository {
    /**
     * Get a collection of all model's elements
     * @return array
     */
    public function all($with_key_value=false, $key='', $value='');

    /**
     * Get an specific item based on an $id paramenter
     * @param  integer $id
     * @return model instance
     */
    public function get($id);

    /**
     * Get a collection of database records by page
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function getByPage($page=1, $limit=10);

    /**
     * Create a new model record in database
     * @param  array  $data
     * @param  array  $extra
     * @return model instance
     */
    public function create(array $data, array $extra=[]);

    /**
     * Update a model record in database
     * @param  integer $id
     * @param  array  $data
     * @param  array  $extra
     * @return null | model instance
     */
    public function update($id, array $data, array $extra=[]);

    /**
     * Detele a model record in database
     * @param  integer $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Create a new model instance
     * @param  array  $data
     * @return model instance
     */
    public function newModelInstance(array $data=[]);
}
