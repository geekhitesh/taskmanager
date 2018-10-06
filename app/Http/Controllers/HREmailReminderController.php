<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

class HREmailReminderController extends Controller
{
    //
	
	public function regularisationLockReminder()
	{
		$today = date("Y-m-d");	
		echo $day = date("d");			
		$total_days = date("t");
		
		$regularization = array("07", "14", "21",$total_days);
		$locked = array("02","09","16","23");
		//$day= "07";


		
		if(in_array($day,$regularization))
		{
			echo "<br/>In Regularisation Process";
			
			//$today =mktime(10, 10, 10,10, 9, 2017);
			//echo $today = date("Y-m-d",strtotime($today1."-12 days"));
			
			$from_day = date("d",strtotime($today."-6 days"));
			$to_day = date("d");
			
			$lock_day = date("d",strtotime($today."+2 days"));
			
			$regularise['from'] = $from_day;
			$regularise['to'] = $to_day;
			$regularise['lock'] = $lock_day;
			echo "<br/>";
			var_dump($regularise);

			
			Mail::send('hr/attendance/regularisation', ['regularise' => $regularise], function($message){
         		$message->to('circular@buniyad.com')->subject('Attendance Regularisation Reminder');
         		$message->from('hr@buniyad.com');
      		});
			
		}
		else if(in_array($day,$locked))
		{
			echo "<br/>In Locked Process";
			//$today =mktime(10, 10, 10,10, 9, 2017);
			//echo $today = date("Y-m-d",strtotime($today1."-12 days"));
			
			$from_day = date("d",strtotime($today."-8 days"));
			$to_day = date("d",strtotime($today."-2 days"));
			
			//$lock_day = date("d",strtotime($today."+2 days"));
			
			$regularise['from'] = $from_day;
			$regularise['to'] = $to_day;
			//$regularise['lock'] = $lock_day;
			echo "<br/>";
			var_dump($regularise);
			
			
			Mail::send('hr/attendance/locked', ['regularise' => $regularise], function($message){
         		$message->to('circular@buniyad.com')->subject('Attendance Regularisation Locked');
         		$message->from('hr@buniyad.com');
      		}); 
			
		}
		
		echo "Reminder process finished.";
		
		
	}
}
