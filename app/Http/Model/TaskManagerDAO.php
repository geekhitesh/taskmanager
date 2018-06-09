<?php

namespace App\Http\Model;

use DB;
use \Cache;


class TaskManagerDAO{


	public function createTask($task)
	{
		$task_id=0;
		$status = DB::insert('INSERT INTO task_manager(task_summary,
			                                 task_description,
			                                 task_expiration_date,
			                                 task_assigned_to_email,
			                                 task_assigned_by_email,
			                                 task_status) values(?,?,?,?,?,?)',
			                                 [$task['task_summary'],
			                                  $task['task_description'],
			                                  $task['task_due_date'],
			                                  $task['task_assigned_to_email'],
			                                  $task['task_assigned_by_email'],
			                                  $task['task_status']
			                                 ]);


		if($status)
		{
			$task_id = DB::getPdo()->lastInsertId();		
		}

		return $task_id;

	}


	public function getBuniyadCareRequesters()
    {
    	if(Cache::has('buniyadCareEmployeeData'))
    	{
    		//echo "Cache Hit<br/>";
    		$employeeList = Cache::get('buniyadCareEmployeeData');
    	}
    	else
    	{
    		echo "Cache Miss<br/>";
    		$data = array(
                  "OPERATION_NAME" => "GET_ALL",
				  "TECHNICIAN_KEY" => "7C49939D-0C32-40BB-A9B3-8B0F41A49BB6",
				  "INPUT_DATA"     => "<Operation>
											<Details>
												<parameter>
													<name>noofrows</name>
													<value>200</value>
												</parameter>
												<parameter>
													<name>emailid</name>
													<value>*@buniyad.com</value>
												</parameter>
												<parameter>
													<name>loginname</name>
													<value>*@buniyad.com</value>
												</parameter>												
											</Details>
										</Operation>"				   
              );
			$postData = http_build_query($data);
			$rest_url = "http://14.102.16.188:8989/sdpapi/requester";
			$cSession = curl_init(); 
			curl_setopt($cSession,CURLOPT_URL,$rest_url);
			curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($cSession,CURLOPT_POST,true);
			curl_setopt($cSession,CURLOPT_POSTFIELDS,$postData);
			curl_setopt($cSession,CURLOPT_HEADER, false); 
			$result=curl_exec($cSession);
			curl_close($cSession);
			$xml=simplexml_load_string($result) or die("Error: Cannot create object");
			$record_count = count($xml->response->operation->Details->record);
			$employeeList = array();
			for($i=0;$i <$record_count; $i++)
			{

				$user_name =(String) $xml->response->operation->Details->record[$i]->parameter[1]->value;
				$email_id =(String) $xml->response->operation->Details->record[$i]->parameter[2]->value;
				$employeeData = array();
				$employeeData['email'] =$email_id;
				$employeeData['name'] = $user_name;
				//echo "$user_name and email id is: $email_id<br/>"; 
				//var_dump($user_name[0]);
				array_push($employeeList,$employeeData);
			}
			Cache::put('buniyadCareEmployeeData',$employeeList,365*24*60);
    	}

    	return $employeeList;
	}


	public function getAllAssignedToTasks($email_id)
	{
		$taskListByEmailId = DB::select('select * from task_manager where task_assigned_to_email = ? order by task_creation_date desc',[$email_id]);
		return $taskListByEmailId;
	}


	public function getAllAssignedToTasksOpen($email_id)
	{
		$taskListByEmailId = DB::select("select * from task_manager where task_assigned_to_email = ? and task_status='Open' order by task_creation_date desc",[$email_id]);
		return $taskListByEmailId;
	}

	public function getAllAssignedByTasks($email_id)
	{
		$taskListByEmailId = DB::select('select * from task_manager where task_assigned_by_email = ? order by task_creation_date desc',[$email_id]);
		return $taskListByEmailId;
	}

	public function getAllTasks()
	{
		$taskList= DB::select('select * from task_manager');
		return $taskList;

	}

	public function getTaskById($task_id)
	{
		$task = DB::select('select * from task_manager where task_id = ?',[$task_id]);
		return $task;
	}

	public function updateTask($task)
	{
		//var_dump($task);
		$date = date('Y-m-d H:i:s');

		$status = DB::update('update task_manager 
			                  set task_status=?, task_closure_comments=?, task_closure_date=? 
			                  where task_id=?',
			                  [	$task['task_status'],
			                  	$task['task_closure_comments'],
			                  	$date,
			                  	$task['task_id'],
			                  ]);

		return $status;
	}


}


?>