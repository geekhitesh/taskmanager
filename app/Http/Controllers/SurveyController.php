<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model;

use Mail;
use URL;

set_time_limit(20000);

class SurveyController extends Controller
{
    //
	
	private $easyPayDAO;
	private $conn;
	private $emp_list;
	private $survey_id;
	private $test_envrionment = false;
	
	public function __construct()
	{
		$this->easyPayDAO = new Model\EasyPayDAO();
		
		if($this->test_envrionment == true)
		{
			$this->emp_list = $this->easyPayDAO->getTestEmployeeList();
			//var_dump($this->emp_list);
		}
		else
		{
			$this->conn = $this->easyPayDAO->connectEasyPay();
			$this->emp_list = $this->easyPayDAO->getEmployeeList($this->conn);	
		}			
	}
	
	public function createSurvey()
	{
		// Get a unique survey Id
		$this->survey_id = $this->easyPayDAO->getGuid();
		
		// create a survey
		$this->easyPayDAO->createSurvey($this->survey_id);
		echo "<h1>Survey is created successfully and has been sent successfully to all employees.</h1>";
		
		/********* register this survey for all the employees  **********
		********** by creating a unique link for every employee *********/
		
		$this->easyPayDAO->createSurveyUserLink($this->survey_id,$this->emp_list);
		
		
		/** Send the unique link of survey to every employee **/
		
		foreach ($this->emp_list as $emp_email => $emp_link)
		{
			$emp['survey_user_link'] = url('/') . "/survey/fill/".$emp_link;
			$emp['email'] = $emp_email;
			
			echo "Survey sent to: $emp_email<br/>";
			Mail::send('email_survey_create', ['emp' => $emp], function($message) use ($emp) {
				$message->to($emp['email'])->subject('Employee Engagement Survey');
				$message->from('hr@buniyad.com');
			});
		}
	}

	
	public function fillSurvey($user_survey_link)
	{
		//$link_status = "";
		$link_status = $this->easyPayDAO->getUserSurveyStatusByLink($user_survey_link);
		if($link_status == "completed")
		{
			echo "<h1>You have already filled the survey!!</h1>";
		}
		else
		{
			return view('survey_fill')->with(compact('user_survey_link'));
		}
	}
	
	public function submitSurvey(Request $request)
	{
		$employee['user_survey_id'] = $request->input('user_survey_link');
		$employee['survey_question1_result'] = $request->input('survey_question1_result');
		$employee['survey_question2_result'] = $request->input('survey_question2_result');
		
		//var_dump($employee);
		$this->easyPayDAO->submitSurvey($employee);
		
		echo "<h1>Thanks for filling the survey. Your feedback will be considered </h1>";
		
	}
	
	public function getSurveyList()
	{
		$survey_count = 15;
		$survey_list = $this->easyPayDAO->getSurveyListByLimit($survey_count);
		return $survey_list;
	}
	
	public function getSurveyResults($survey_id)
	{
		$survey_results = $this->easyPayDAO->getSurveyResults($survey_id);
		return $survey_results;
	}
	
	public function surveyDashboard()
	{
		$user['name'] = auth()->user()->name;
		$user['email_id'] = auth()->user()->email;
		$user['role'] = auth()->user()->role;	
		
		if($user['role'] == "admin")
		{
			return view('survey_dashboard')->with(compact('user'));
		}
		else
		{
			echo "<h1>You are not authorized to access this page.</h1>";
		}
	}
	
	
	public function getEmpList()
	{
		
		var_dump($this->emp_list);
	}
	
	public function respondToUser($user_survey_id,$email_reply_text)
	{
		$user_survey_details = array();
		$user_survey_result = $this->easyPayDAO->getUserSurveyResultById($user_survey_id);
		$user_survey_details['email_reply_text'] = $email_reply_text;
		$user_survey_details['user_email'] = $user_survey_result->user_email;
		$user_survey_details['survey_question1_result'] = $user_survey_result->survey_question1_result;
		$user_survey_details['survey_question2_result'] = $user_survey_result->survey_question2_result;
		
		Mail::send('user_survey_details_email', ['user_survey_details' => $user_survey_details], function($message) use ($user_survey_details) {
         		$message->to($user_survey_details['user_email'])->subject('Management Reply To Your Suggestions');
         		$message->from('helpdesk@buniyad.com');
      		});
			
		return "success";	
	}
}
