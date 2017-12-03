# PageViewCounter
This counter is to store the visitor of the website per page. 
<br>
It can display
<br>
Visitor today, this week, this month and this whole year.
<br><br>

How it works?<br>
Currently the counter run manualy when the visitor visit the website and save cookies in their browser.
If the cookies is available, the counter will not run, the cookies expired every 24 hours, so the next day it will count again if your visitor visit again the next day. 
<br><br>
Is the counter automatically change the count for the new visitor?<br>
No, the count will change only every 6 hours, on page reload.
<br><br>

To use this class add the following code in your page footer.<br>
$counter = new Viewcounter();
<br>
$counter->run_counter('visit');
<br>
<br><br>

for cron job<br>
$cron = new Viewcounter();
<br>
$cron->run_cronjob();
<br><br>
This pagecounter is officially from my codeigniter library, I convert it to basic php class to help the students to understand how the counter works.
