<?php
namespace Beehive\Repo\Template;
use Beehive\Repo\Repository;

interface TemplateRepo extends Repository {
    /**
     * Get templates by user
     * @param  integer $id
     * @param  array  $columns
     * @return array
     */
    public function getByUser($id, array $columns=['templates.*']);

    /**
     * Verify if a user is the owner of the template
     * @param  integer  $user_id
     * @param  integer  $template_id
     * @return boolean
     */
    public function isOwner($user_id, $template_id);
}
