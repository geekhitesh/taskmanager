var requesters_list;
var requestersList;

function getRequesters()
{
	console.log('Requester fetching process started');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      requesters_list = this.responseText;
	      loadRequesters();
	      getAssignedToMeTasksOpen();
	      getAssignedToTasksHistory();
	      getAssignedByMeTasksOpen();
	      getAssignedByMeTasksHistory();
		  getLoggedInTime();
	    }
	  };
	  xhttp.open("GET", "taskmanager/requesters", true);
	  xhttp.send();
	

}

function loadRequesters()
{

	var assigned_by = document.getElementById("requesters_list");
	//var assigned_to = document.getElementById("requesters_list");
	requestersList = JSON.parse(requesters_list);
	var index_i=0;

 	for(index_i=0;index_i < requestersList.length;index_i++)
	{
		var requester = requestersList[index_i];

		if(requester)
		{
			//console.log(requester);

			var option = document.createElement("option");
			option.text = requester['name'];
			option.setAttribute('value',requester['email']);
			assigned_by.add(option);

		}
	}


	console.log('Requester fetching process finished');
}


function getLoggedInTime()
{
	console.log('Tasks fetching process started');

  	var email_id = document.getElementById('user_email_id').value;
  	var url = "/hr/InTimeEmployee.php?emp_mail_id="+email_id;
	var xhttp = new XMLHttpRequest();
	var tasks;
	var time_span = '<span class="glyphicon glyphicon-time"></span>';
	var punch_time = document.getElementById('punch_time');
	//<span class="glyphicon glyphicon-user"></span>
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      console.log(this.responseText);
		  punch_time.innerHTML = "Today's Punch Time "+time_span+this.responseText;
		  
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();
	
	
}


function getAssignedToMeTasksOpen()
{
  	console.log('Tasks fetching process started');

  	var email_id = document.getElementById('user_email_id').value;
  	var url = "taskmanager/all-requests/to/open/"+email_id;
	var xhttp = new XMLHttpRequest();
	var tasks;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      tasks = this.responseText;
	      console.log(tasks);
	      loadAllAssignedToMeTasksOpen(tasks);
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();

}

function loadAllAssignedToMeTasksOpen(tasks)
{
	var tasks_list = JSON.parse(tasks);
	var index_i=0;
	var task;
	var task_summary;
	var task_description;
	var task_assigned_to;
	var task_assigned_by;
	var task_status;
	var task_creation_date;
	var parent_div = document.getElementById("assigned_to_me_open");
	var update_task_url = "";
	parent_div.innerHTML = "";
	//console.log("total tasks:"+tasks_list.length);
	var table_text = "";
	//document.getElementById("no_task").style.display = "none";

	document.getElementById("span_to_open").innerHTML=tasks_list.length;
	if(tasks_list.length > 0)
	{
		table_text = "<table class='table'>"+
								"<tr>"+
									"<th>SNo.</th>"+
									"<th>Task Number</th>"+
									"<th>Assigned By</th>"+
								    "<th>Creation Date</th>"+
								    "<th>Summary</th>"+
								    "<th>Description</th>"+
								    "<th>Due Date</th>"+
								    "<th>Update Task</th>"+
								"</tr><tbody id='assigned_to_me_open_table'>";

		/* Create the Table */

		for(index_i=0; index_i < tasks_list.length; index_i++)
		{
			task = tasks_list[index_i];
			task_number = task['task_id'];
			task_summary = task['task_summary'];
			task_description = task['task_description'];
			task_assigned_to = task['task_assigned_to_email'];
			task_assigned_by = task['task_assigned_by_email'];
			task_creation_date = task['task_creation_date'];
			task_status = task['task_status'];
			task_due_date = task['task_expiration_date'];
			update_task_url = "taskmanager/edit-task/"+task_number;

			var creation_date = new Date(task_creation_date);
			//console.log(creation_date);
			var due_date = new Date(task_due_date);
			//console.log(due_date);

			var diff = due_date - creation_date;
			//console.log(diff);
			var due_days = diff / (1000*60*60*24);
			var style;
			//console.log(due_days);

			var status = task_status.localeCompare('Open');
      		//console.log(status);

			if(due_days <= 0 && status==0)
			{
				style="style='color:red'";
			}
			else
			{
				style="";
			}

			//<a href="+task_url+" target="_blank" class="btn btn-danger block-center">Update Task Status</a>
					    
					

			table_text += "<tr>"+
								"<td>"+(index_i+1)+"</td>"+
								"<td>"+task_number+"</td>"+
								"<td>"+task_assigned_by+"</td>"+
								"<td>"+task_creation_date+"</td>"+
								"<td>"+task_summary+"</td>"+
								"<td>"+task_description+"</td>"+
								"<td "+style+">"+task_due_date+"</td>"+
								"<td><a href='"+update_task_url+"' target='_blank' class='btn btn-success block-center'>Update Task Status</a></td>"+
							"</tr>";
		}

		table_text +="</tbody></table";
	}
	else
	{
		//document.getElementById("no_task").style.display = "block";
	}
	parent_div.innerHTML = table_text;
	//console.log(parent_div.innerHTML);
}


function getAssignedToTasksHistory()
{
  	console.log('Tasks fetching process started');

  	var email_id = document.getElementById('user_email_id').value;
  	var url = "taskmanager/all-requests/to/"+email_id;
  	console.log(email_id);
	var xhttp = new XMLHttpRequest();
	var tasks;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      tasks = this.responseText;
	      console.log(tasks);
	      loadAllAssignedToTasksHistory(tasks);
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();

}


function loadAllAssignedToTasksHistory(tasks)
{
	var tasks_list = JSON.parse(tasks);
	var index_i=0;
	var task;
	var task_summary;
	var task_description;
	var task_assigned_to;
	var task_assigned_by;
	var task_status;
	var task_creation_date;
	var parent_div = document.getElementById("assigned_to_me_history");
	parent_div.innerHTML = "";
	//console.log("total tasks:"+tasks_list.length);
	console.log(requestersList);
	var table_text = "";
	//document.getElementById("no_task").style.display = "none";
	document.getElementById("span_to_history").innerHTML=tasks_list.length;
	if(tasks_list.length > 0)
	{
		table_text = "<table class='table'>"+
								"<tr>"+
									"<th>SNo.</th>"+
									"<th>Task Number</th>"+
									"<th>Assigned By</th>"+
								    "<th>Creation Date</th>"+
								    "<th>Summary</th>"+
								    "<th>Description</th>"+
								    "<th>Due Date</th>"+
								    "<th>Task Status</th>"+
								"</tr><tbody id='assigned_to_me_history_table'>";

		/* Create the Table */

		for(index_i=0; index_i < tasks_list.length; index_i++)
		{
			task = tasks_list[index_i];
			task_number = task['task_id'];
			task_summary = task['task_summary'];
			task_description = task['task_description'];
			task_assigned_to = task['task_assigned_to_email'];
			task_assigned_by = task['task_assigned_by_email'];
			task_creation_date = task['task_creation_date'];
			task_status = task['task_status'];
			task_due_date = task['task_expiration_date'];

			var creation_date = new Date(task_creation_date);
			//console.log(creation_date);
			var due_date = new Date(task_due_date);
			//console.log(due_date);

			var diff = due_date - creation_date;
			//console.log(diff);
			var due_days = diff / (1000*60*60*24);
			var style;
			//console.log(due_days);

			var status = task_status.localeCompare('Open');
      		//console.log(status);

			if(due_days <= 0 && status==0)
			{
				style="style='color:red'";
			}
			else
			{
				style="";
			}


			table_text += "<tr>"+
										"<td>"+(index_i+1)+"</td>"+
										"<td>"+task_number+"</td>"+
										"<td>"+task_assigned_by+"</td>"+
										"<td>"+task_creation_date+"</td>"+
										"<td>"+task_summary+"</td>"+
										"<td>"+task_description+"</td>"+
										"<td "+style+">"+task_due_date+"</td>"+
										"<td>"+task_status+"</td>"+
									"</tr>";
		}

		table_text +="</tbody></table";
	}
	else
	{
		//document.getElementById("no_task").style.display = "block";
	}
	parent_div.innerHTML = table_text;
	//console.log(parent_div.innerHTML);
}



function getAssignedByMeTasksOpen()
{
  	console.log('Tasks fetching process started');

  	var email_id = document.getElementById('user_email_id').value;;
  	var url = "taskmanager/all-requests/by/"+email_id;
	var xhttp = new XMLHttpRequest();
	var tasks;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      tasks = this.responseText;
	      console.log(tasks);
	      loadAllAssignedByMeTasksOpen(tasks);
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();

}

function loadAllAssignedByMeTasksOpen(tasks)
{
	var tasks_list = JSON.parse(tasks);
	var index_i=0;
	var task;
	var task_summary;
	var task_description;
	var task_assigned_to;
	var task_assigned_by;
	var task_status;
	var task_creation_date;
	var serial_number =0;
	var parent_div = document.getElementById("assigned_by_me_open");
	parent_div.innerHTML = "";
	//console.log("total tasks:"+tasks_list.length);
	var table_text = "";
	//document.getElementById("no_task").style.display = "none";
	console.log(requestersList);
	if(tasks_list.length > 0)
	{
		table_text = "<table class='table'>"+
								"<tr>"+
									"<th>SNo.</th>"+
									"<th>Task Number</th>"+
									"<th>Assigned To</th>"+
								    "<th>Creation Date</th>"+
								    "<th>Summary</th>"+
								    "<th>Description</th>"+
								    "<th>Due Date</th>"+
								"</tr><tbody id='assigned_by_me_open_table'>";

		/* Create the Table */

		for(index_i=0; index_i < tasks_list.length; index_i++)
		{
			task = tasks_list[index_i];
			task_number = task['task_id'];
			task_summary = task['task_summary'];
			task_description = task['task_description'];
			task_assigned_to = task['task_assigned_to_email'];
			task_assigned_by = task['task_assigned_by_email'];
			task_creation_date = task['task_creation_date'];
			task_status = task['task_status'];
			task_due_date = task['task_expiration_date'];

			console.log(task_assigned_to);

			var creation_date = new Date(task_creation_date);
			//console.log(creation_date);
			var due_date = new Date(task_due_date);
			//console.log(due_date);

			var diff = due_date - creation_date;
			//console.log(diff);
			var due_days = diff / (1000*60*60*24);
			var style;
			//console.log(due_days);

			var status = task_status.localeCompare('Open');
      		//console.log(status);

			if(due_days <= 0 && status==0)
			{
				style="style='color:red'";
			}
			else
			{
				style="";
			}

			if(status==0)
			{
				serial_number++;
				table_text += "<tr>"+
										"<td>"+(serial_number)+"</td>"+
										"<td>"+task_number+"</td>"+
										"<td>"+task_assigned_to+"</td>"+
										"<td>"+task_creation_date+"</td>"+
										"<td>"+task_summary+"</td>"+
										"<td>"+task_description+"</td>"+
										"<td "+style+">"+task_due_date+"</td>"+
									"</tr>";

			}

			
		}

		table_text +="</tbody></table";
	}
	else
	{
		//document.getElementById("no_task").style.display = "block";
	}
	parent_div.innerHTML = table_text;
	//console.log(parent_div.innerHTML);
	document.getElementById("span_by_open").innerHTML=serial_number;
}


function getAssignedByMeTasksHistory()
{
  	console.log('Tasks fetching process started');

  	var email_id = document.getElementById('user_email_id').value;;
  	var url = "taskmanager/all-requests/by/"+email_id;
	var xhttp = new XMLHttpRequest();
	var tasks;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      tasks = this.responseText;
	      console.log(tasks);
	      loadAllAssignedByMeTasksHistory(tasks);
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();

}

function loadAllAssignedByMeTasksHistory(tasks)
{
	var tasks_list = JSON.parse(tasks);
	var index_i=0;
	var task;
	var task_summary;
	var task_description;
	var task_assigned_to;
	var task_assigned_by;
	var task_status;
	var task_creation_date;
	var serial_number = 0;
	var parent_div = document.getElementById("assigned_by_me_history");
	var task_closure_comments;
	parent_div.innerHTML = "";
	//console.log("total tasks:"+tasks_list.length);
	var table_text = "";
	//document.getElementById("no_task").style.display = "none";
	console.log(requestersList);
	document.getElementById("span_by_history").innerHTML=tasks_list.length;
	if(tasks_list.length > 0)
	{
		table_text = "<table class='table'>"+
								"<tr>"+
									"<th>SNo.</th>"+
									"<th>Task Number</th>"+
									"<th>Assigned To</th>"+
								    "<th>Creation Date</th>"+
								    "<th>Summary</th>"+
								    "<th>Description</th>"+
								    "<th>Due Date</th>"+
								    "<th>Task Status</th>"+
								     "<th>Task Closure Comments</th>"+
								"</tr><tbody id='assigned_by_me_history_table'>";

		/* Create the Table */

		for(index_i=0; index_i < tasks_list.length; index_i++)
		{
			task = tasks_list[index_i];
			task_number = task['task_id'];
			task_summary = task['task_summary'];
			task_description = task['task_description'];
			task_assigned_to = task['task_assigned_to_email'];
			task_assigned_by = task['task_assigned_by_email'];
			task_creation_date = task['task_creation_date'];
			task_status = task['task_status'];
			task_due_date = task['task_expiration_date'];
			task_closure_comments = task['task_closure_comments'];

			console.log(task_assigned_to);

			var creation_date = new Date(task_creation_date);
			//console.log(creation_date);
			var due_date = new Date(task_due_date);
			//console.log(due_date);

			var diff = due_date - creation_date;
			//console.log(diff);
			var due_days = diff / (1000*60*60*24);
			var style;
			//console.log(due_days);

			var status = task_status.localeCompare('Open');

			if(status==0 && !task_closure_comments)
			{
				task_closure_comments = "";
			}
      		//console.log(status);

			if(due_days <= 0 && status==0)
			{
				style="style='color:red'";
			}
			else
			{
				style="";
			}

			table_text += "<tr>"+
									"<td>"+(index_i+1)+"</td>"+
									"<td>"+task_number+"</td>"+
									"<td>"+task_assigned_to+"</td>"+
									"<td>"+task_creation_date+"</td>"+
									"<td>"+task_summary+"</td>"+
									"<td>"+task_description+"</td>"+
									"<td "+style+">"+task_due_date+"</td>"+
									"<td>"+task_status+"</td>"+
									"<td>"+task_closure_comments+"</td>"+
								"</tr>";


			
		}

		table_text +="</tbody></table";
	}
	else
	{
		//document.getElementById("no_task").style.display = "block";
	}
	parent_div.innerHTML = table_text;
	//console.log(parent_div.innerHTML);
}



function createNewTask()
{
	var task_summary=document.getElementById("task_summary").value;
	var task_description=document.getElementById("task_description").value;
	var task_due_date = document.getElementById("task_due_date").value;
	var task_assigned_owner = document.getElementById("requesters_list");
	var task_assigned_by_email = task_assigned_owner.options[task_assigned_owner.selectedIndex].value;
	var task_assigned_to =document.getElementById("assigned_to");
	var task_assigned_to_email = task_assigned_to.options[task_assigned_to.selectedIndex].value;
	url = "taskmanager/create-task";
	//console.log(task_description);

	var queryString = "task_summary="+task_summary+"&"+
	                  "task_description="+task_description+"&"+
	                  "task_due_date="+task_due_date+"&"+
	                  "task_assigned_by_email="+task_assigned_by_email+"&"+
	                  "task_assigned_to_email="+task_assigned_to_email;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     	 	 console.log(this.responseText);
     	 	 //getAllAssignedToTasks();
			 //document.getElementById("no_task").style.display = "none";
			 document.getElementById("loading_task").style.display = "none"; 
			 //document.getElementById("user_tasks").style.display = "block";
			 $('#create_task_button').prop('disabled', false);
			 alert('New task is assigned to '+ task_assigned_to_email);
			 $('#create_task_form').trigger("reset");
			 
   		}
	};

	url += "?"+queryString;
	console.log(url);
  xhttp.open("GET", url, true);

  xhttp.send();
  
  document.getElementById("loading_task").style.display = "block";
  //document.getElementById("user_tasks").style.display = "none";
  $('#create_task_button').prop('disabled', true);
}