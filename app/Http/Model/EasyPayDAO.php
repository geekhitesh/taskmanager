<?php

namespace App\Http\Model;

use DB;
use \Cache;




class EasyPayDAO 
{
   function connectEasyPay()
   {
	   
        $server = "BUNIYADSERVER-P\SQLEXPRESS";
        $options = array(  "UID" => "sa",
                      "PWD" => "rss@123",
					  "Database" => "DBEasyPAY_BUD"
				   );
        $conn = sqlsrv_connect($server, $options);
        if ($conn === false) 
	        die("<pre>".print_r(sqlsrv_errors(), true));
   
       // echo "Successfully connected!";
    return $conn;    
		
   }
   
   
   function closeEasyPay($conn)
   {
	
       sqlsrv_close($conn);	
	   
   }
   
   
   function getEmployeeList($conn)
   {
	   //echo "new joinee <br/>";
	    $params = array(1); 
       // print_r($params);
        $emp_list = array();		
        $tsql = "SELECT [employeecode]
                        ,[title]
                        ,[fname]
                        ,[mname]
                        ,[lname]
                        ,[fathersname]
                        ,[husbandname]
                        ,[gender]
                        ,[dateofbirth]
                        ,[dateofjoining]
                        ,[dateofprobation]
                        ,[dateofconfirmation]
                        ,[scheduleddateofexit]
                        ,[dateofexitintimation]
                        ,[dateofexit]
                        ,[noticeperiod]
                        ,[shortnoticedays]
                        ,[reasonforexit]
                        ,[typeofexit_fid]
                        ,[pfapplicable]
                        ,[pensionapplicable]
                        ,[esiapplicable]
                        ,[ptaxapplicable]
                        ,[lwfapplicable]
                        ,[pfno]
                        ,[ssn]
                        ,[esino]
                        ,[pan]
                        ,[swapcardno]
                        ,[ticketno]
                        ,[exportcode]
                        ,[contractemp]
                        ,[branch_fid]
                        ,[department_fid]
                        ,[grade_fid]
                        ,[designation_fid]
                        ,[unit_fid]
                        ,[division_fid]
                        ,[project_fid]
                        ,[employeecategory_fid]
                        ,[costcategory_fid]
                        ,[currency_fid]
                        ,[ct_fid]
                        ,[attendanceyeardefinition_fid]
                        ,[freeze]
                        ,[freezedate]
                        ,[freezereason]
                        ,[employeenonactive]
                        ,[enableemployeeautoincrement]
                        ,[employeeautoincrementdate]
                        ,[weeklyoffoverride]
                        ,[weeklyoffSun]
                        ,[weeklyoffMon]
                        ,[weeklyoffTue]
                        ,[weeklyoffWed]
                        ,[weeklyoffThu]
                        ,[weeklyoffFri]
                        ,[weeklyoffSat]
                        ,[employeePayrollCalcbaseOverride]
                        ,[employeePayrollCalcbase_fid]
                        ,[EmployeeeGradeOTRateOverride]
                        ,[EmployeeOTRatePerHour]
                        ,[flat]
                        ,[premise]
                        ,[road]
                        ,[area]
                        ,[town]
                        ,[pincode]
                        ,[state]
                        ,[country]
                        ,[pflat]
                        ,[ppremise]
                        ,[proad]
                        ,[parea]
                        ,[ptown]
                        ,[ppincode]
                        ,[pstate]
                        ,[pcountry]
                        ,[phone1]
                        ,[phone2]
                        ,[mobile]
                        ,[email]
                        ,[maritalstatus]
                        ,[dateofmarriage]
                        ,[children]
                        ,[birthplace]
                        ,[religion]
                        ,[bloodgroup]
                        ,[caste]
                        ,[subcaste]
                        ,[languages]
                        ,[height]
                        ,[weight]
                        ,[identificationmark]
                        ,[nationality]
                        ,[InternationalWorker]
                        ,[passportnumber]
                        ,[passportissuedate]
                        ,[passportexpirydate]
                        ,[passportplaceofissue]
                        ,[vehicledetails]
                        ,[drivinglicenceno]
                        ,[drivinglicenceissuedate]
                        ,[drivinglicenceexpirydate]
                        ,[drivinglicencetwowheeler]
                        ,[drivinglicencethreewheeler]
                        ,[drivinglicencefourwheeler]
                        ,[professionalmembershipdetails]
                        ,[Offered]
                        ,[OfferRefNo]
                        ,[OfferDate]
                        ,[OfferValidityDate]
                        ,[OfferHeadHRMEmployee_fid]
                        ,[Recruitmenttype_fid]
                        ,[Appointed]
                        ,[AppointmentRefNo]
                        ,[AppointmentDate]
                        ,[AppointmentDateOfJoining]
                        ,[AppointmentDurationofTraining]
                        ,[AppointmentCancelled]
                        ,[NotOnPayroll]
                        ,[EmployeeDeviceCode]
                        ,[punchstatus]
                        ,[exitclearance]
                        ,[candidate_fid]
                        ,[vacancy_fid]
                        ,[fromRCR]
                        ,[epfdateofjoining]
                        ,[epsdateofjoining]
                        ,[epsdateofexit]
                        ,[personalemail]
                        ,[aadhar_eid]
                        ,[aadhar_name]
                        ,[aadhar_no]
                        ,[aadhar_bankname]
                        ,[aadhar_bankbranch]
                        ,[aadhar_bankaccount]
                        ,[aadhar_ifsc]
                        ,[enableemployeeautoincrementmonth]
                        ,[tdsModuleNotApplicable]
                        ,[EMTRegistrationDate]
                        ,[StopMonthOfCalculatePFI]
                        ,[isStopPFInterestCalculate]
                        ,[dateofjoininggroup]
                        ,[traineeDate]
                        ,[GratuitySchemeApplicable]
                        ,[GratuityScheme_Fid]
                        ,[DateOfEntryInGratuityScheme]
                        ,[GratuityTrust_ID_Employee]
                        ,[SASchemeApplicable]
                        ,[SAScheme_Fid]
                        ,[DateOfEntryInSAScheme]
                        ,[specialisaton_fid]
                        ,[pfuan]
                        ,[educationalstatus]
                        ,[physicallyhandicap]
                        ,[physicallyhandicapCategory]
                        ,[empstatus_fid]
                        ,[PayrollCycleDefinition_fid]
                        ,[minimumwagecategory_fid]
                        ,[overridenoticeperiod]
                        ,[noticeperiod_indays]
                        ,[isrehire]
                        ,[state_fid]
                        ,[EmployeeOtherInformation1]
                        ,[lastreportingday]
                        ,[previous_uan]
                 FROM [DBEasyPAY_BUD].[dbo].[tbl_employee]
				 WHERE 1=? and dateofexit is null";  
        /*Execute the query with a scrollable cursor so  
          we can determine the number of rows returned.*/  
        $cursorType = array("Scrollable" => SQLSRV_CURSOR_KEYSET);  
        $employeeList = sqlsrv_query($conn,$tsql,$params,$cursorType);  
        if ( $employeeList === false)  
            die("<pre>".print_r(sqlsrv_errors(), true)); 
        
        if(sqlsrv_has_rows($employeeList))  
        {  
	       //echo "Row Found";
            $rowCount = sqlsrv_num_rows($employeeList);   
            while( $row = sqlsrv_fetch_array( $employeeList, SQLSRV_FETCH_ASSOC))  
            {  
		        if(filter_var($row['email'], FILTER_VALIDATE_EMAIL))
				{
					$email = $row['email'];
					$name = $row['fname']." ".$row['lname'];
					$emp_list[$email] = $this->getGuid();
                }				   
            }
			
			
			
		}   
	     /* Free the statement and connection resources. */  
        sqlsrv_free_stmt( $employeeList);  
        //sqlsrv_close( $conn );
		return $emp_list;
        		
   }
   
   
	function getGuid()
	{
		$i=20;
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);
		$hex   = bin2hex($bytes);
		//echo "Lengths: Bytes: $i and Hex: " . strlen($hex) . PHP_EOL;
		
		return $hex;	
		
	}	
	
	
	function createSurvey($guid)
	{
		$status = DB::insert('insert into survey_list(survey_id) values(?)',[$guid]);
		
		
	}
	
	function createSurveyUserLink($survey_id,$emp_list)
	{
		$link_status = "active";
		foreach ($emp_list as $emp_email => $emp_link)
		{
			$status = DB::insert('insert into 
			                      survey_user_link(survey_id,
								                   user_survey_id,
												   user_email,
												   link_status)
                 			      values(?,?,?,?)',
								  [$survey_id,
								   $emp_link,
								   $emp_email,
								   $link_status
								   ]
								);
		}
	}
	
	
	function getTestEmployeeList()
	{
		$emp_list = array();
		
		$emp_list['hitesh.ahuja@buniyad.com'] = $this->getGuid();
		$emp_list['geek.hitesh@gmail.com'] = $this->getGuid();
		
		return $emp_list;
		
	}
	
	function submitSurvey($employee)
	{
		$survey_taken_time = date('Y-m-d H:i:s');
		$link_status="completed";
		
		$status = DB::update('UPDATE survey_user_link
							  SET link_status = ?,
							      survey_taken_time = ?,
								  survey_question1_result = ?,
								  survey_question2_result = ?
							  WHERE user_survey_id = ?  ',
							  [$link_status,
							   $survey_taken_time,
							   $employee['survey_question1_result'],
							   $employee['survey_question2_result'],
							   $employee['user_survey_id']
							   ]
							);
	}
	
	function getUserSurveyStatusByLink($user_survey_id)
	{
		$emp = DB::select('select link_status from survey_user_link where user_survey_id = ?',[$user_survey_id]);
		
		return $emp[0]->link_status;
	}
	
	function getSurveyResults($survey_id)
	{
		$link_status = "completed";
		$survey_results = DB::select('SELECT * 
                 		              FROM survey_user_link 
									  WHERE survey_id = ? AND link_status=?',[$survey_id,$link_status]);
		return $survey_results;
	}
	
	function getSurveyListByLimit($total_count)
	{
		 $survey_list = DB::select('SELECT * 
		                           FROM survey_list 
								   ORDER BY survey_date desc
								   LIMIT ?',[$total_count]
								  );
								  
		return 	$survey_list;					  
	}
	
	
	function getAllEmployees($conn)
	{
	   //echo "new joinee <br/>";
	    $params = array(1); 
       // print_r($params);
        $emp_list = array();		
        $tsql = "SELECT [employeecode]
                        ,[title]
                        ,[fname]
                        ,[mname]
                        ,[lname]
                        ,[fathersname]
                        ,[husbandname]
                        ,[gender]
                        ,[dateofbirth]
                        ,[dateofjoining]
                        ,[dateofprobation]
                        ,[dateofconfirmation]
                        ,[scheduleddateofexit]
                        ,[dateofexitintimation]
                        ,[dateofexit]
                        ,[noticeperiod]
                        ,[shortnoticedays]
                        ,[reasonforexit]
                        ,[typeofexit_fid]
                        ,[pfapplicable]
                        ,[pensionapplicable]
                        ,[esiapplicable]
                        ,[ptaxapplicable]
                        ,[lwfapplicable]
                        ,[pfno]
                        ,[ssn]
                        ,[esino]
                        ,[pan]
                        ,[swapcardno]
                        ,[ticketno]
                        ,[exportcode]
                        ,[contractemp]
                        ,[branch_fid]
                        ,[department_fid]
                        ,[grade_fid]
                        ,[designation_fid]
                        ,[unit_fid]
                        ,[division_fid]
                        ,[project_fid]
                        ,[employeecategory_fid]
                        ,[costcategory_fid]
                        ,[currency_fid]
                        ,[ct_fid]
                        ,[attendanceyeardefinition_fid]
                        ,[freeze]
                        ,[freezedate]
                        ,[freezereason]
                        ,[employeenonactive]
                        ,[enableemployeeautoincrement]
                        ,[employeeautoincrementdate]
                        ,[weeklyoffoverride]
                        ,[weeklyoffSun]
                        ,[weeklyoffMon]
                        ,[weeklyoffTue]
                        ,[weeklyoffWed]
                        ,[weeklyoffThu]
                        ,[weeklyoffFri]
                        ,[weeklyoffSat]
                        ,[employeePayrollCalcbaseOverride]
                        ,[employeePayrollCalcbase_fid]
                        ,[EmployeeeGradeOTRateOverride]
                        ,[EmployeeOTRatePerHour]
                        ,[flat]
                        ,[premise]
                        ,[road]
                        ,[area]
                        ,[town]
                        ,[pincode]
                        ,[state]
                        ,[country]
                        ,[pflat]
                        ,[ppremise]
                        ,[proad]
                        ,[parea]
                        ,[ptown]
                        ,[ppincode]
                        ,[pstate]
                        ,[pcountry]
                        ,[phone1]
                        ,[phone2]
                        ,[mobile]
                        ,[email]
                        ,[maritalstatus]
                        ,[dateofmarriage]
                        ,[children]
                        ,[birthplace]
                        ,[religion]
                        ,[bloodgroup]
                        ,[caste]
                        ,[subcaste]
                        ,[languages]
                        ,[height]
                        ,[weight]
                        ,[identificationmark]
                        ,[nationality]
                        ,[InternationalWorker]
                        ,[passportnumber]
                        ,[passportissuedate]
                        ,[passportexpirydate]
                        ,[passportplaceofissue]
                        ,[vehicledetails]
                        ,[drivinglicenceno]
                        ,[drivinglicenceissuedate]
                        ,[drivinglicenceexpirydate]
                        ,[drivinglicencetwowheeler]
                        ,[drivinglicencethreewheeler]
                        ,[drivinglicencefourwheeler]
                        ,[professionalmembershipdetails]
                        ,[Offered]
                        ,[OfferRefNo]
                        ,[OfferDate]
                        ,[OfferValidityDate]
                        ,[OfferHeadHRMEmployee_fid]
                        ,[Recruitmenttype_fid]
                        ,[Appointed]
                        ,[AppointmentRefNo]
                        ,[AppointmentDate]
                        ,[AppointmentDateOfJoining]
                        ,[AppointmentDurationofTraining]
                        ,[AppointmentCancelled]
                        ,[NotOnPayroll]
                        ,[EmployeeDeviceCode]
                        ,[punchstatus]
                        ,[exitclearance]
                        ,[candidate_fid]
                        ,[vacancy_fid]
                        ,[fromRCR]
                        ,[epfdateofjoining]
                        ,[epsdateofjoining]
                        ,[epsdateofexit]
                        ,[personalemail]
                        ,[aadhar_eid]
                        ,[aadhar_name]
                        ,[aadhar_no]
                        ,[aadhar_bankname]
                        ,[aadhar_bankbranch]
                        ,[aadhar_bankaccount]
                        ,[aadhar_ifsc]
                        ,[enableemployeeautoincrementmonth]
                        ,[tdsModuleNotApplicable]
                        ,[EMTRegistrationDate]
                        ,[StopMonthOfCalculatePFI]
                        ,[isStopPFInterestCalculate]
                        ,[dateofjoininggroup]
                        ,[traineeDate]
                        ,[GratuitySchemeApplicable]
                        ,[GratuityScheme_Fid]
                        ,[DateOfEntryInGratuityScheme]
                        ,[GratuityTrust_ID_Employee]
                        ,[SASchemeApplicable]
                        ,[SAScheme_Fid]
                        ,[DateOfEntryInSAScheme]
                        ,[specialisaton_fid]
                        ,[pfuan]
                        ,[educationalstatus]
                        ,[physicallyhandicap]
                        ,[physicallyhandicapCategory]
                        ,[empstatus_fid]
                        ,[PayrollCycleDefinition_fid]
                        ,[minimumwagecategory_fid]
                        ,[overridenoticeperiod]
                        ,[noticeperiod_indays]
                        ,[isrehire]
                        ,[state_fid]
                        ,[EmployeeOtherInformation1]
                        ,[lastreportingday]
                        ,[previous_uan]
                 FROM [DBEasyPAY_BUD].[dbo].[tbl_employee]
				 WHERE 1=? and dateofexit is null";  
        /*Execute the query with a scrollable cursor so  
          we can determine the number of rows returned.*/  
        $cursorType = array("Scrollable" => SQLSRV_CURSOR_KEYSET);  
        $employeeList = sqlsrv_query($conn,$tsql,$params,$cursorType);  
        if ( $employeeList === false)  
            die("<pre>".print_r(sqlsrv_errors(), true)); 
        
        if(sqlsrv_has_rows($employeeList))  
        {  
	       //echo "Row Found";
            $rowCount = sqlsrv_num_rows($employeeList);   
            while( $row = sqlsrv_fetch_array( $employeeList, SQLSRV_FETCH_ASSOC))  
            {  
		       /* if(filter_var($row['email'], FILTER_VALIDATE_EMAIL))
				{
					$email = $row['email'];
					$name = $row['fname']." ".$row['lname'];
					$emp_list[$email] = $row;
                } */
				
				$bud_id = $row['employeecode'];
				$emp_list[$bud_id] = $row; 		
            }
			
			
			
		}   
	     /* Free the statement and connection resources. */  
        sqlsrv_free_stmt( $employeeList);  
        //sqlsrv_close( $conn );
		return $emp_list;
        		
   }
   
   public function getUserSurveyResultById($user_survey_id)
   {
	   	$user_survey_result = DB::select('select * from survey_user_link where user_survey_id = ?',[$user_survey_id]);
		
		return $user_survey_result[0];
	   
   }
	
	
}