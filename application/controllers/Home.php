<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	private $err = array();
	
	function __construct() {
	    parent::__construct();
	    $this->lang->load('home');
	    $this->load->model('home_model');
	}
	
	public function index() {

		$data['text_title'] = $this->lang->line('text_title');
		$data['text_city_list'] = $this->lang->line('text_city_list');
		$data['text_filter'] = $this->lang->line('text_filter');
		$data['text_reset'] = $this->lang->line('text_reset');
		$data['text_pagination'] = $this->lang->line('text_pagination');
		$data['text_dashboard'] = $this->lang->line('text_dashboard');
		
		$data['column_city_name'] = $this->lang->line('column_city_name');
		$data['column_country_name'] = $this->lang->line('column_country_name');
		$data['column_continent'] = $this->lang->line('column_continent');
		$data['column_city_pop'] = $this->lang->line('column_city_pop');
		$data['column_country_area'] = $this->lang->line('column_country_area');
		$data['column_indep_year'] = $this->lang->line('column_indep_year');
				
		$data['text_no_result'] = $this->lang->line('text_no_result');
		
		// build url for pagination
		$url = '';
		
		if (!is_null($this->input->get('filter_city_name'))) {
			$url .= '&filter_city_name=' . rawurlencode(remove_invisible_characters($this->input->get('filter_city_name')));
		}
		
		if (!is_null($this->input->get('filter_country_name'))) {
			$url .= '&filter_country_name=' . rawurlencode(remove_invisible_characters($this->input->get('filter_country_name')));
		}
		
		if (!is_null($this->input->get('filter_continent'))) {
			$url .= '&filter_continent=' .rawurlencode(remove_invisible_characters($this->input->get('filter_continent')));
		}
		
		if (!is_null($this->input->get('filter_city_pop'))) {
			$url .= '&filter_city_pop=' . (int)$this->input->get('filter_city_pop');
		}
	
		if (!is_null($this->input->get('per_page'))) {
			    $url .= '&per_page=' . (int)$this->input->get('per_page');
		}
		
		if (!is_null($this->input->get('sort'))) {
			    $url .= '&sort=' . rawurlencode(remove_invisible_characters($this->input->get('sort')));
		}
		
		if (!is_null($this->input->get('order'))) {
			    $url .= '&order=' . rawurlencode(remove_invisible_characters($this->input->get('order')));
		}
		
		if (!is_null($this->input->get('filter_city_name'))) {
			$data['filter_city_name'] = $this->input->get('filter_city_name');
		} else {
			$data['filter_city_name'] = null;
		}
		
		if (!is_null($this->input->get('filter_country_name'))) {
			$data['filter_country_name'] = $this->input->get('filter_country_name');
		} else {
			$data['filter_country_name'] = null;
		}
		
		if (!is_null($this->input->get('filter_continent'))) {
			$data['filter_continent'] = $this->input->get('filter_continent');
		} else {
			$data['filter_continent'] = null;
		}
		
		if (!is_null($this->input->get('filter_city_pop'))) {
			$data['filter_city_pop'] = (int)$this->input->get('filter_city_pop');
		} else {
			$data['filter_city_pop'] = null;
		}
		
		if (!is_null($this->input->get('per_page'))) {
			$data['per_page'] = (int)$this->input->get('per_page');
		} else {
			$data['per_page'] = null;
		}
		
		if (!is_null($this->input->get('sort'))) {
			$data['sort'] = $this->input->get('sort');
		} else {
			$data['sort'] = 'name';
		}
		
		if (!is_null($this->input->get('order'))) {
			$data['order'] = $this->input->get('order');
		} else {
			$data['order'] = 'ASC';
		}
		
		$data['action']['action'] = site_url('c=home&m=index' . $url);
		
		// here we got array  with data and count
		$cities = $this->home_model->getCities($data);
		$data['cities'] = $cities['cities'];
		$count = $cities['count'];
		
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('c=home&m=index' . $url);
		$config['total_rows'] = $count;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['results'] = sprintf($this->lang->line('text_pagination'), ($count ? $count : 0), ($count ? ceil($count / $config['per_page']) : 0));
		
		// build url for sort & order
		$url = '';
		
		if (!is_null($this->input->get('filter_city_name'))) {
			$url .= '&filter_city_name=' . rawurlencode(remove_invisible_characters($this->input->get('filter_city_name')));
		}

		if (!is_null($this->input->get('filter_country_name'))) {
			$url .= '&filter_country_name=' . rawurlencode(remove_invisible_characters($this->input->get('filter_country_name')));
		}
		
		if (!is_null($this->input->get('filter_continent'))) {
			$url .= '&filter_continent=' .rawurlencode(remove_invisible_characters($this->input->get('filter_continent')));
		}
		
		if (!is_null($this->input->get('filter_city_pop'))) {
			$url .= '&filter_city_pop=' . (int)$this->input->get('filter_city_pop');
		}
	
		if (!is_null($this->input->get('per_page'))) {
			    $url .= '&per_page=' . (int)$this->input->get('per_page');
		}
		
		if ($data['order'] == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}		
		
		$data['sort_city_name'] = site_url('c=home&m=index' . '&sort=city_name' . $url);
		$data['sort_country_name'] = site_url('c=home&m=index' . '&sort=country_name' . $url);
		$data['sort_continent'] = site_url('c=home&m=index' . '&sort=continent' . $url);
		$data['sort_city_pop'] = site_url('c=home&m=index' . '&sort=city_pop' . $url);
		$data['sort_country_area'] = site_url('c=home&m=index' . '&sort=country_area' . $url);
		$data['sort_indep_year'] = site_url('c=home&m=index' . '&sort=indep_year' . $url);
		
		$this->output->set_output($this->load_header($data))
			->append_output($this->twig_lib->render('home_list', $data))
			->append_output($this->load_footer());
	}
}
