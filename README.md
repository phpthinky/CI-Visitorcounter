# Visitorcounter
Visitorcounter is a class y for codeigniter
to use this class you must install first the geoip2 via composer

add this into your composer.json file
```
{
"require":
    {    
        "geoip2/geoip2": "~2.0"        
    }
}
```
or install via composer

composer require geoip2/geoip2:~2.0<br/>

To use this class add this line to your controller

```
$this->library->load('visitorcounter');
$this->visitor->counter->run();
```

How to get the vist data


```
$this->library->load('visitorcounter');
//replace the date,year,month you want to display
$this->visitor->counter->read($date,$year,$month);

//For current date
$this->visitor->counter->read();
//Sample output
::1~2019-03-04 02:00 pm~Invalid IP address: ::1~JP~Invalid IP address: ::1 
::2~2019-03-04 02:00 pm~Invalid IP address: ::1~PH~Invalid IP address: ::1 
::3~2019-03-04 02:01 pm~Invalid IP address: ::1~US~Invalid IP address: ::1 
::2~2019-03-04 02:02 pm~Invalid IP address: ::1~PH~Invalid IP address: ::1 
::1~2019-03-04 02:60 pm~Invalid IP address: ::1~JP~Invalid IP address: ::1 
//Getcurrentdata by array
// getcurrentdata($date,$y,$m)
            if($data = $this->webvisitors->getcurrentdata()){
               var_dump($data);
            }
            //output
              array(3) {
                  [0]=>
                  array(2) {
                    ["country"]=>
                    string(2) "JP"
                    ["counter"]=>
                    int(2)
                  }
                  [1]=>
                  array(2) {
                    ["country"]=>
                    string(2) "PH"
                    ["counter"]=>
                    int(2)
                  }
                  [2]=>
                  array(2) {
                    ["country"]=>
                    string(2) "US"
                    ["counter"]=>
                    int(1)
                  }
                }

```
