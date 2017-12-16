<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	function __construct() {
	    parent::__construct();
	    $this->load->library('twig_lib');
	    $this->twig_lib->addGlobal('tw_site_url', site_url('c=home&m=index'));
	}
	
	protected function load_header(array $data) {
	    $this->lang->load('home');
	    
	    $data += array('text_search' => $this->lang->line('text_search'));
	    $data += array('text_quick_search' => $this->lang->line('text_quick_search'));
	    $data += array('tw_form_open' => form_open(site_url('c=home&m=index'), array("class" => "form-inline mt-2 mt-md-0","method" => "get","novalidate" => NULL,"autocomplete" => "off","id" => "form-search")));
	
	    return $this->twig_lib->render('common/header', $data);
	}
	
	protected function load_footer() {
	
	    return $this->twig_lib->render('common/footer');
	}
}