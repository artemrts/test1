<?php
class Home_Model extends CI_Model {
	
	public function __construct() {
    	    parent::__construct();
    	    $this->load->database();
	}
	
	public function getCities(array $data = null): array {
		
		//sql for count (for pagination)
		$sql_count = "SELECT COUNT(`ID`) AS `count` FROM `city` AS ci" .
				" LEFT JOIN `country` AS co ON CountryCode=Code  WHERE 0=0";
		
		if (isset($data['filter_city_name'])) {
		    $sql_count .= " AND `ci`.`Name` LIKE '%" .$this->db->escape_like_str($data['filter_city_name']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_country_name'])) {
		    $sql_count .= " AND `co`.`Name` LIKE '%" .$this->db->escape_like_str($data['filter_country_name']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_continent'])) {
		    $sql_count .= " AND `co`.`Continent` LIKE '%" .$this->db->escape_like_str($data['filter_continent']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_city_pop'])) {
		    $sql_count .= " AND `ci`.`Population` <= " .(int)$data['filter_city_pop'];
		}
		
		//sql for data
		$sql = "SELECT ci.ID, ci.Name AS city_name, co.Name AS country_name, ci.Population AS city_pop, co.Continent AS continent, co.SurfaceArea AS country_area, co.IndepYear AS indep_year FROM `city` AS ci" .
				" LEFT JOIN `country` AS co ON ci.CountryCode=co.Code  WHERE 0=0";
		
		if (isset($data['filter_city_name'])) {
		    $sql .= " AND `ci`.`Name` LIKE '%" .$this->db->escape_like_str($data['filter_city_name']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_country_name'])) {
		    $sql .= " AND `co`.`Name` LIKE '%" .$this->db->escape_like_str($data['filter_country_name']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_continent'])) {
		    $sql .= " AND `co`.`Continent` LIKE '%" .$this->db->escape_like_str($data['filter_continent']). "%' ESCAPE '!'";
		}
		
		if (isset($data['filter_city_pop'])) {
		    $sql .= " AND `ci`.`Population` <= " .(int)$data['filter_city_pop'];
		}
		
		$data_sort = array(
			'city_name',
			'country_name',
			'continent',
			'city_pop',
			'country_area',
			'indep_year',
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $data_sort)) {
		    $sql .= " ORDER BY " . $data['sort'];
		} else {
		    $sql .= " ORDER BY `city_name`";
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['per_page'])) {
		    $sql .= " LIMIT " .(int)$data['per_page'] . ",20";
		// for abuse users :-)
		} else {
		    $sql .= " LIMIT 20";
		}
		
		$query_count = $this->db->query($sql_count);
		$query = $this->db->query($sql);
		
		$return = array();
		
		if ($query->num_rows() > 0) {
			$return['cities'] = $query->result_object();
			$return['count'] = $query_count->result_object()[0]->count;
		} else {
			$return['cities'] = array();
			$return['count'] = 0;
		}
		
		return $return;
	}
}