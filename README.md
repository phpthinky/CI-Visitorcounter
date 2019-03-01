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

```
