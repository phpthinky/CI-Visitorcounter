<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Visitors extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('visitors_model','visits');
    }
    public function index($value='')
    {
    	    if($data = $this->webvisitors->read()){

                foreach ($data as $key) {
                    # code...
                    echo "$key <br/>";
                }
            }else{
                echo "No data to display";
            }
    }
    public function updatedb($value='')
    {
        // getcurrentdata($date,$y,$m)
            if($data = $this->webvisitors->getcurrentdata()){
              
              foreach ($data as $arr) {
                  # code...
                $this->visits->save($arr);
              }



            }
    }
    public function getall($value='')
    {
        # code...
        $visits = $this->visits->getgroupbycountry();

        foreach ($visits as $key) {
            # code...
            print_r($key);
            echo "<br/>";
        }
    }

}
