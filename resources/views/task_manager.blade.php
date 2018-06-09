<!DOCTYPE html>
<html lang="en">
<head>
  <title>Simple Task Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--<script src="taskmanager.js"/> -->

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

.buttonload {
    background-color: #4CAF50; /* Green background */
    border: none; /* Remove borders */
    color: white; /* White text */
    padding: 12px 24px; /* Some padding */
    font-size: 16px; /* Set a font-size */
}

/* Add a right margin to each icon */
.fa {
    margin-left: -12px;
    margin-right: 8px;
}
</style>

</head>


<body onload="getRequesters();">

<div class="container-fluid"> 
	<div class="row alert alert-info"> 
		<div class="col-sm-3">
			<select id="requesters_list" class="form-control" onChange="getAllAssignedToTasks(this)">
				<option>Select Assignee</option> 
			</select>
		</div>		
		<div class="col-sm-3" id="show_tasks" style="display: block;">
			<button type="button" class="form-control btn btn-info" id="create_new_task" data-toggle="modal" data-target="#myModal"> Assign New Task </button>
		</div>
	</div>

	<div id="user_tasks" class="row table-responsive"> 

	</div>	
	
	<div id="no_task" class="row alert alert-danger" style="display:none;"> 
		There is no task assigned. If it is discrepancy, Please contact administrator.
	</div>

	<div id="loading_task" class="row" style="display:none;">
		<button class="buttonload">
			<i class="fa fa-refresh fa-spin"></i>Please wait while we are sending email and loading all your tasks again.
		</button>
	</div>

		<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Modal Header</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form">
	        	<div class="form-group">
	        	 	<label for="task_owner"><span class="glyphicon glyphicon-user"></span> Task Owner</label>
	        	 		<select id="task_owner" class="form-control">
							<option>Select Assignee</option> 
						</select>
	        	 </div>	
	        	 <div class="form-group">
	        	 	<label for="task_summary"><span class="glyphicon glyphicon-pencil"></span> Task Summary</label>
	        	 	<input type="text" class="form-control" id="task_summary" placeholder="Task Summary">
	        	 </div>
	        	 <div class="form-group">
	        	 	<label for="task_description"><span class="glyphicon glyphicon-envelope"></span> Task Description</label>
	        	 	<textarea type="text" class="form-control" id="task_description" placeholder="Task Description"></textarea>
	        	 </div>
	        	 <div class="form-group">
	        	 	<label for="task_due_date"><span class="glyphicon glyphicon-calendar"></span> Task Due Date</label>
	        	 	<input type="text" class="form-control" id="task_due_date" value="2017-10-05 00:00:00" placeholder="Task Due Date">
	        	 </div>        	 	        	 	        	 
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success btn-block" data-dismiss="modal" onclick="createNewTask();">
	        	<span class="glyphicon glyphicon-off"></span> 
	        	Create Task
	        </button>
	      </div>
	    </div>

	  </div>
	</div>
	
</div>	

</body>


<script>
var requesters_list;

function getRequesters()
{
	console.log('Requester fetching process started');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      requesters_list = this.responseText;
	      loadRequesters();
	    }
	  };
	  xhttp.open("GET", "taskmanager/requesters", true);
	  xhttp.send();
	

}


function loadRequesters()
{

	var select_id = document.getElementById("requesters_list");
	var requestersList = JSON.parse(requesters_list);
	var task_assigned_to_email = "";
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
			select_id.add(option);
		}
	}
	console.log('Requester fetching process finished');
}


function getAllAssignedToTasks()
{
  	console.log('Tasks fetching process started');

  	var task_assigned_owner = document.getElementById("requesters_list");
	var email_id = task_assigned_owner.options[task_assigned_owner.selectedIndex].value;

  	//var email_id = s[s.selectedIndex].value;
  	task_assigned_to_email = email_id;
  	var url = "taskmanager/all-requests/to/"+email_id;
	var xhttp = new XMLHttpRequest();
	var tasks;
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	      tasks = this.responseText;
	      //console.log(tasks);
	      loadAllAssignedToTasks(tasks);
	    }
	  };
	  xhttp.open("GET", url, true);
	  xhttp.send();

}


function loadAllAssignedToTasks(tasks)
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
	var parent_div = document.getElementById("user_tasks");
	parent_div.innerHTML = "";
	//console.log("total tasks:"+tasks_list.length);
	var table_text = "";
	document.getElementById("no_task").style.display = "none";
	if(tasks_list.length > 0)
	{
		table_text = "<table clas='table table-bordered table-hover'>"+
								"<tr>"+
									"<th>Serial Number</th>"+
									"<th>Task Number</th>"+
								    "<th>Task Creation Date</th>"+
								    "<th>Task Summary</th>"+
								    "<th>Task Description</th>"+
								    "<th>Task Due Date</th>"+
								    "<th>Task Status</th>"+
								"</tr>";

		/* Create the Table */

		for(index_i=0; index_i < tasks_list.length; index_i++)
		{
			task = tasks_list[index_i];
			task_number = task['task_id'];
			task_summary = task['task_summary'];
			task_description = task['task_description'];
			task_assigned_to = requesters_list[task['task_assigned_to_email']];
			task_assigned_by = requesters_list[task['task_assigned_by_email']];
			task_creation_date = task['task_creation_date'];
			task_status = task['task_status'];
			task_due_date = task['task_expiration_date'];

			var creation_date = new Date(task_creation_date);
			console.log(creation_date);
			var due_date = new Date(task_due_date);
			console.log(due_date);

			var diff = due_date - creation_date;
			console.log(diff);
			var due_days = diff / (1000*60*60*24);
			var style;
			console.log(due_days);

			var status = task_status.localeCompare('Open');
      		console.log(status);

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
		document.getElementById("no_task").style.display = "block";
	}
	parent_div.innerHTML = table_text;
	//console.log(parent_div.innerHTML);
}


$('#create_new_task').click(function() {
    var $options = $("#requesters_list > option").clone();
    $('#task_owner').append($options);
});

function createNewTask()
{
	var task_summary=document.getElementById("task_summary").value;
	var task_description=document.getElementById("task_description").value;
	var task_due_date = document.getElementById("task_due_date").value;
	var task_assigned_owner = document.getElementById("task_owner");
	var task_assigned_by_email = task_assigned_owner.options[task_assigned_owner.selectedIndex].value;
	url = "taskmanager/create-task";
	console.log(task_description);

	var queryString = "task_summary="+task_summary+"&"+
	                  "task_description="+task_description+"&"+
	                  "task_due_date="+task_due_date+"&"+
	                  "task_assigned_by_email="+task_assigned_by_email+"&"+
	                  "task_assigned_to_email="+task_assigned_to_email;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     	 	 console.log(this.responseText);
     	 	 getAllAssignedToTasks();
			 document.getElementById("no_task").style.display = "none";
			 document.getElementById("loading_task").style.display = "none"; 
			 document.getElementById("user_tasks").style.display = "block";
			 
   		}
	};

	url += "?"+queryString;
	console.log(url);
  xhttp.open("GET", url, true);
  xhttp.send();
  
  document.getElementById("loading_task").style.display = "block";
  document.getElementById("user_tasks").style.display = "none";
   
}

</script>

</html>