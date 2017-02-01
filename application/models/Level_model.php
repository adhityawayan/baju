<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/09/2016
 * Time: 20:25
 */
class Level_model extends Base_model
{
    protected $table = 'm_level';
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $query = $this->get($this->table)->result();
        if($query)
        {
            return $query;
        }
        return [];
    }
}