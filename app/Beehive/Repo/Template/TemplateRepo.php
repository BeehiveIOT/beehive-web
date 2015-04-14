<?php
namespace Beehive\Repo\Template;
use Beehive\Repo\Repository;

interface TemplateRepo extends Repository {
    /**
     * Get templates by user
     * @param  integer $user_id
     * @param  array  $columns
     * @return array
     */
    public function getAllByUser($user_id, array $columns=['templates.*'], array $relations=[]);

    /**
     * Verify if a user is the owner of the template
     * @param  integer  $user_id
     * @param  integer  $template_id
     * @return boolean
     */
    public function isOwner($user_id, $template_id);

    /**
     * Get an specific template
     * @param  integer $id
     * @param  integer $user_id
     * @param  array  $columns
     * @return Object
     */
    public function getByUser($id, $user_id, array $columns=['templates.*']);
}
