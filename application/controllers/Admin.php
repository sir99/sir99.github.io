<?php

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data   = array(
            "page_title"    => "Dashboard",
            "user"          => $this->db->get_where("user", array(
                "email"     => $this->session->userdata("email"),
            ))->row_array()
        );

        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar", $data);
        $this->load->view("templates/topbar", $data);
        $this->load->view("admin/index", $data);
        $this->load->view("templates/footer");
    }

    public function role()
    {
        $data   = array(
            "page_title"    => "Role",
            "user"          => $this->db->get_where("user", array(
                "email"     => $this->session->userdata("email"),
            ))->row_array(),
            "role"          => $this->db->get("user_role")->result_array()
        );

        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar", $data);
        $this->load->view("templates/topbar", $data);
        $this->load->view("admin/role", $data);
        $this->load->view("templates/footer");
    }

    public function roleAccess($role_id)
    {
        $data   = array(
            "page_title"    => "Role Access",
            "user"          => $this->db->get_where("user", array(
                "email"     => $this->session->userdata("email"),
            ))->row_array(),
            "role"          => $this->db->get_where("user_role", [
                "id"   => $role_id
            ])->row_array(),
            "menu"          => $this->db->get_where("user_menu", [
                "id <>"      => 1
            ])->result_array()
        );

        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar", $data);
        $this->load->view("templates/topbar", $data);
        $this->load->view("admin/role-access", $data);
        $this->load->view("templates/footer");
    }

    public function changeAccess()
    {
        $role_id    = $this->input->post("roleId");
        $menu_id    = $this->input->post("menuId");

        $data   = array(
            "role_id"   => $role_id,
            "menu_id"   => $menu_id,
        );

        $result     = $this->db->get_where("user_access_menu", $data);

        if ($result->num_rows() < 1) {
            $this->db->insert("user_access_menu", $data);
        } else {
            $this->db->delete("user_access_menu", $data);
        }

        $this->session->set_flashdata("message", "<div class='alert alert-success'
        role='alert'>Access changed!</div>");
    }
}
