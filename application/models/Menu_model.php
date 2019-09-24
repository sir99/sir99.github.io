<?php

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query  = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                     FROM `user_sub_menu` JOIN `user_menu`
                       ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ";
        $data   = $this->db->query($query)->result_array();
        return $data;
    }
}
