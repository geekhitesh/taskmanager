var current_survey_date;
var survey_array;

function init()
{
	console.log('****** <Init> Process Started *****');
	
	getSurveyList();

}


function getSurveyList()
{
	document.getElementById("loading_surveys").style.display = "block";
	console.log('****** <Fetching Survey List> Process Started *****');
	var xhttp = new XMLHttpRequest();
	var url = "list";
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	       console.log(this.responseText);
		   document.getElementById("loading_surveys").style.display = "none";
		   renderSurveyList(this.responseText);
		   
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();
	
}


function renderSurveyList(survey_list)
{
	survey_array = JSON.parse(survey_list);
	var survey_ul = document.getElementById('survey_list');
	var total_surveys = survey_array.length;
	var index_i = 0;
	var survey_li;
	var survey_date;
	var survey_id;
	var survey;
	var init_survey_id = 0;

	
	console.log(survey_array);
	for(index_i=0; index_i < total_surveys; index_i++)
	{
		var survey = survey_array[index_i]
		survey_date = survey['survey_date'];
		survey_id = survey['survey_id'];
		
		if(index_i ==0)
		{
			init_survey_id = survey_id;
		}
		
		survey_li = document.createElement("li");
		survey_li.setAttribute('id',survey_id+"_li");
		survey_li.innerHTML = '<a href=# id='+survey_id+' onClick=getSurveyResults("'+survey_id+'")>Survey '+(index_i+1)+'</a>';
		//survey_li.appendChild(document.createTextNode());
		survey_ul.appendChild(survey_li);
	}
	
	document.getElementById(init_survey_id).click();
	//getSurveyResults(init_survey_id);
}


function getSurveyResults(survey_id)
{
	var index_i=0;
	var count = survey_array.length;
	var survey_date;
	var survey_li = document.getElementById(survey_id+'_li');
	var class_name = "active";
	var one_element;
	var all_elements = document.getElementsByClassName(class_name);
	document.getElementById("loading_survey_results").style.display = "block";
	document.getElementById("survey_results").style.display = "none";
	
	for(index_i=0;index_i < all_elements.length;index_i++)
	{
		one_element = all_elements[index_i];
		one_element.removeAttribute('class');
	}
	
	survey_li.setAttribute('class','active');
	
	for(index_i=0; index_i < count; index_i++)
	{
		var survey = survey_array[index_i];
		
		if(survey_id == survey['survey_id'])
		{
			survey_date = survey['survey_date'];
			console.log("Survey Date: "+survey_date);
			document.getElementById('survey_results_header').innerHTML = 'Survey Results ('+survey_date+')';
		    
		}
		
	}
	
	console.log('****** <Fetching Survey Results> Process Started *****');
	var xhttp = new XMLHttpRequest();
	var url = "results/"+survey_id;
	var survey_button = document.getElementById(survey_id+"_li");
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	       console.log(this.responseText);
		   document.getElementById("loading_survey_results").style.display = "none";
		   document.getElementById("survey_results").style.display = "block";
		  renderSurveyResults(this.responseText);
	    }
	  };
	  xhttp.open("GET",url, true);
	  xhttp.send();
}


function renderSurveyResults(survey_result_list)
{
	console.log('rendering started');
	var survey_result_array = JSON.parse(survey_result_list);
	var count = survey_result_array.length;
	var index_i = 0;
	var survey_results_div = document.getElementById("survey_results");
	var table_text = "";
	var survey_result;

	table_text = "<table class='table'>"+
						"<tr>"+
							"<th>SNo.</th>"+
							"<th>User Email</th>"+
							"<th>Survey Taken Time</th>"+
							"<th>Problems faced by employees</th>"+
							"<th>Suggestions by employees</th>"+
							"<th>Respond</th>"+
						"</tr><tbody id='survey_results_table'>";
	
	if(count > 0)
	{
		console.log('survey results > 0');

		/* Create the Table */

		for(index_i=0; index_i < count; index_i++)
		{
			survey_result = survey_result_array[index_i];
			var user_email = survey_result['user_email'];
			var survey_taken_time = survey_result['survey_taken_time'];
			var survey_question1_result = survey_result['survey_question1_result'];
			var survey_question2_result = survey_result['survey_question2_result'];
			var user_survey_id = survey_result['user_survey_id'];

			table_text += "<tr>"+
								"<td>"+(index_i+1)+"</td>"+
								"<td>"+user_email+"</td>"+
								"<td>"+survey_taken_time+"</td>"+
								"<td>"+survey_question1_result+"</td>"+
								"<td>"+survey_question2_result+"</td>"+
								"<td><button type='button' class='btn-link' onClick=showReplyUserForm('"+user_email+"','"+user_survey_id+"');>Reply To Survey</a></td>"+
							"</tr>";
		}

		table_text +="</tbody></table";
		
	}
	else
	{
		//survey_results_div.innerHTML = "<h1>No Employee has taken the survey yet. Please check after some time.</h1>";	

		table_text += "<tr>"+
							"<td>"+(index_i+1)+"</td>"+
							"<td> </td>"+
							"<td> </td>"+
							"<td> </td>"+
							"<td> </td>"+
							"<td></td>"+
						"</tr>";
        table_text +="</tbody></table";							
	}
	
	survey_results_div.innerHTML = table_text;
	
	//console.log(parent_div.innerHTML);
	
}


function showReplyUserForm(email_id,user_survey_id)
{
	$("#replyUserForm").modal("show");
	document.getElementById('user_email').value = email_id;
	document.getElementById('email_reply_text').value = 'Thanks for your patience. We are working on your issue and will try to resolve it shortly';
	document.getElementById('user_survey_id').value = user_survey_id;
}


function respondToUser()
{
	var user_email = document.getElementById('user_email').value;
	var user_survey_id = document.getElementById('user_survey_id').value;
	var email_reply_text = document.getElementById('email_reply_text').value;
	
	/*if(trim(email_reply_text) == '')
	{
		alert('Reply To User cannot be empty');
		return false;
	}*/
	
	alert('Sending Email');
	
	console.log('****** <Fetching Survey Results> Process Started *****');
	var xhttp = new XMLHttpRequest();
	
	var url = "respond-to-user/"+user_survey_id+"/"+email_reply_text;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	       alert('Email is sent to employee');
	    }
	  };
	  xhttp.open("GET",url, true);
	  xhttp.send();
}