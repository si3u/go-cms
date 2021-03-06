<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

    /**
     *  This is a core go-cms file.  Do not edit if you plan to
     *  ever update your go-cms version.  Changes would be lost.
     */

//////////////////////////////// core file ///////////////////////////////
///////////////////////////////// go-cms /////////////////////////////////

class Pages extends GO_Admin_Controller {

	public function __construct(){
		parent::__construct();

		/** Validate the user should be able to access this resource */
		
	        if(empty($_SESSION['admin']) || $this->input->cookie("go-admin-hash") !== $_SESSION['admin']['hash']) {
	            redirect(base_url() . "admin/login");
	        }

		$this->load->model('pages_model','page');

	}

	// PUT (Create)

		public function page_add() {
			$data = array(
				'page' => $this->page->go_get_one(0)
			);
			$this->go_load_page(array('page'=>'admin/pages/add','title'=>'Add Page','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// GET (Read)

		public function pages() {
			if($_POST && (isset($_POST['save']) || isset($_POST['save-and-new']) || isset($_POST['save-and-close']))) {
				$id = 0;
				if(!empty($this->input->get('id'))) $id = $this->input->get('id'); 
				$this->page->post_data($_POST, $id);
			}
			$menu_item_id = 6; // INT is set on SQL of Class creation from LAB
			$this->session->set_userdata('menu_item_id', $menu_item_id);
			$this->page->get_display_status($menu_item_id);
			if(($_POST && isset($_POST['toggleDisplay']))) $this->page->toggle_display($_POST);  // Toggle Active/Inactive
			$data = array(
				'pages' => $this->page->go_get_all()
			);
			$this->go_load_page(array('page'=>'admin/pages/pages','title'=>'Pages','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// PUT (Update)

		public function page_edit() {
			$data = array(
				'page' => $this->page->go_get_one($this->input->get('id'))
			);
			$this->go_load_page(array('page'=>'admin/pages/edit','title'=>'Edit Page','template'=>'admin','activeClass'=>'pages','queries'=>$data));
		}

	// AJAX

		public function update_display_status() {
			echo json_encode($this->page->update_display_status($this->input->post()));
		}

}
