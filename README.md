# PageViewCounter
This counter is to store the visitor of the website per page. 

It can display
Visitor today, this week, this month and this whole year.

How it works?
Currently the counter run manualy when the visitor visit the website and save cookies in their browser.
If the cookies is available, the counter will not run, the cookies expired every 24 hours, so the next day it will count again if your visitor visit again the next day. 

Is the counter automatically change the count for the new visitor?
No, the count will change only every 6 hours, on page reload.


To use this class add the following code in your page footer.
$counter = new Viewcounter();
$counter->run_counter('visit');


for cron job
$cron = new Viewcounter();
$cron->run_cronjob();
