<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Visitors_model extends CI_Model
{
	private $table = 'tbl_visits';
	public function save($data='')
	{
		# code...
		$date = strtotime($data['date_of_visit']);
		$date =date('Y-m-d',$date);
		$query = $this->db->select('*')
				->from($this->table)
				->where('date_of_visit',$date)
		 		->where('country',$data['country'])
		 		->get();
		if($result = $query->result()){
			$this->db->set('counter',$data['counter'])
			->where('date_of_visit',$date)
		 	->where('country',$data['country'])
		 	->update($this->table);
		 	return true;
		}else{

		$this->db->insert($this->table,$data);
			return true;
		}

	}
	public function getgroupbycountry($month=0,$year=0)
	{
		# code...
		if ($month > 0 && $year	> 0) {
			# code...

			$query = $this->db->select('country,SUM(counter) as counter')
					->from($this->table)
					->where('MONTH(date_of_visit)',$month)
					->where('YEAR(date_of_visit)',$year)
					->group_by('country')
					->get();
					return $query->result();
		}else{

			$query = $this->db->select('country,SUM(counter) as counter')
					->from($this->table)
					->where('MONTH(date_of_visit)',date('m'))
					->where('YEAR(date_of_visit)',date('Y'))
					->group_by('country')
					->get();
					return $query->result();
		}
	}
}
