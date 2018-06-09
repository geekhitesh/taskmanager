<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model;

use Mail;
use URL;


class TaskManagerController extends Controller
{
    //

    public $taskManagerDAO;
	private $easyPayDAO;
	private $conn;
	

    public function __construct()
    {
    	$this->taskManagerDAO = new Model\TaskManagerDAO();
		$this->easyPayDAO = new Model\EasyPayDAO();
		$this->conn = $this->easyPayDAO->connectEasyPay();
    		
    }

    public function getBuniyadCareRequesters()
    {
    	$employee_data = $this->taskManagerDAO->getBuniyadCareRequesters();

    	$employee_json = json_encode($employee_data);

    	return $employee_json;

	}

	public function createTask(Request $request)
	{
		$task = array();
		$task['task_summary']     		= $request->input('task_summary');
		$task['task_description'] 		= $request->input('task_description');
		$task['task_assigned_to_email'] = $request->input('task_assigned_to_email');
		$task['task_assigned_by_email'] = $request->input('task_assigned_by_email');
		$task['task_due_date'] 			= $request->input('task_due_date');
		$task['task_status']            = 'Open';



		$task_id = $this->taskManagerDAO->createTask($task);
		$task['url'] = URL::to('/')."/taskmanager/edit-task/$task_id";
		$task['task_id'] = $task_id;

		if($task_id > 0)
		{
      		Mail::send('task_alert_mail', ['task' => $task], function($message) use ($task) {
         		$message->to($task['task_assigned_to_email'])->subject('New Task Assignment #'.$task['task_id']);
         		$message->from($task['task_assigned_by_email']);
      		});
		}
		//return "$task_summary - $task_description - $task_assigned_to_email - $task_assigned_by_email - $task_due_date";

		return $task_id;

	}

	public function getAllTasks()
	{
		$taskList = $this->taskManagerDAO->getAllTasks();
		return json_encode($taskList);

	}

	public function getAllAssignedToTasks($email_id)
	{
		$taskList = $this->taskManagerDAO->getAllAssignedToTasks($email_id);
		return json_encode($taskList);

	}

	public function getAllAssignedToTasksOpen($email_id)
	{
		$taskList = $this->taskManagerDAO->getAllAssignedToTasksOpen($email_id);
		return json_encode($taskList);

	}	

	public function getAllAssignedByTasks($email_id)
	{
		$taskList = $this->taskManagerDAO->getAllAssignedByTasks($email_id);
		return json_encode($taskList);

	}

	public function index()
	{
	    $user['name'] = auth()->user()->name;
		$user['email_id'] = auth()->user()->email;
		return view('task_manager_welcome')->with(compact('user'));
	}

	public function OpenRequestEditableMode($task_id)
	{
		
		$task = $this->taskManagerDAO->getTaskById($task_id);

		return view('task_edit_mode')->with(compact('task'));
	}

	public function updateTask(Request $request)
	{
		$task = array();
		$task_id =  $request->input('task_id');
		$task['task_id']     		    = $request->input('task_id');
		$task['task_description'] 		= $request->input('task_description');
		$task['task_assigned_to_email'] = $request->input('task_assigned_to_email');
		$task['task_assigned_by_email'] = $request->input('task_assigned_by_email');
		$task['task_due_date'] 			= $request->input('task_due_date');
		$task['task_status']            = $request->input('task_status');
		$task['task_closure_comments']  = $request->input('task_closure_comments');

		$status = $this->taskManagerDAO->updateTask($task);
		$task = $this->taskManagerDAO->getTaskById($task['task_id']);
		$task[0]->url = URL::to('/')."/taskmanager/edit-task/$task_id";

		if($status ==1)
		{
      		Mail::send('task_alert_update', ['task' => $task], function($message) use ($task) {
         		$message->to($task[0]->task_assigned_by_email)->subject('Task #'.$task[0]->task_id.' Updated');
         		$message->from($task[0]->task_assigned_to_email);
      		});
		}
	
		return view('task_updated_mode')->with(compact('task'));
	}
	
	
	public function getAllEmployees()
	{
		return $this->easyPayDAO->getAllEmployees($this->conn);
	}

}
