
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Task Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="taskmanager.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">


<style>
/*table {
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
}*/

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
    <div class="row">
        <div class="row col col-sm-4">
          <img src="http://d2ani3uksvp2ht.cloudfront.net/assets-37/images/buniyad_logo.png" alt="Buniyad Logo" title="Buniyad Logo">
        </div>
      <div class="row col col-sm-4 form-group">
          <label id="punch_time" ></label>
          
      </div>
      
      <div class="row col col-sm-2 form-group">
          <label for="email_id" ><span class="glyphicon glyphicon-user"></span>{{$user['name']}}</label>
          <input type="hidden" class="form-control" readonly="" id="user_email_id" name="email_id" value="{{$user['email_id']}}"/>         
      </div>
	  
	  <div class="row col col-sm-2 form-group">
		 <label for="log_out"><span class="glyphicon glyphicon-log-out"></span> <a href="/taskmanager/public/logout"><b>Log Out</b></a></label>
	  
	  </div>
	  
    </div>

      <ul class="nav nav-tabs">
          <li class="active"><a class="alert alert-info" data-toggle="tab" href="#assigned_to_me_open1" onclick="getAssignedToMeTasksOpen();"><b>Assigned To Me - Open </b><span id="span_to_open" class="badge"></span></a></li>
          <li><a class="alert alert-success" data-toggle="tab" href="#assigned_to_me_history1" onclick="getAssignedToTasksHistory();"><b>Assigned To Me - All </b><span id="span_to_history" class="badge"></span></a></li>
          <li><a class="alert alert-warning" data-toggle="tab" href="#assigned_by_me_open1" onclick="getAssignedByMeTasksOpen();"><b>Assigned By Me - Open </b><span id="span_by_open" class="badge"></span></a></li>
          <li><a class="alert alert-danger" data-toggle="tab" href="#assigned_by_me_history1" onclick="getAssignedByMeTasksHistory();"><b> Assigned By Me - All   </b><span id="span_by_history" class="badge"></span> </a></li>
          <li><a class="alert alert-info" data-toggle="tab" id="create_task" href="#assign_new_task"><b>Assign New Task</b></a></li>
      </ul>

      <div class="tab-content">

        <div id="assigned_to_me_open1" class="tab-pane fadenin active">
            <div class="row"><label></label></div>
            <input class="form-control" id="assigned_to_me_open_input" type="text" placeholder="Search..">
            <div id="assigned_to_me_open" class='table table-responsive table-bordered table-striped'></div>
        </div>

        <div id="assigned_to_me_history1" class="tab-pane fade">
            <div class="row"><label></label></div>
            <input class="form-control" id="assigned_to_me_history_input" type="text" placeholder="Search..">
            <div id="assigned_to_me_history" class='table table-responsive table-bordered table-striped'>
                <div id="no_task" class="row alert alert-danger" style="display:block;"> 
                   There is no task assigned. If it is discrepancy, Please contact administrator.
                </div>
            </div>
        </div>
        
        <div id="assigned_by_me_open1" class="tab-pane fade">
          <div class="row"><label></label></div>
            <input class="form-control" id="assigned_by_me_open_input" type="text" placeholder="Search..">
          <div id="assigned_by_me_open" class='table table-responsive table-bordered table-striped'></div>
        </div>

        <div id="assigned_by_me_history1" class="tab-pane fade">
          <div class="row"><label></label></div>
            <input class="form-control" id="assigned_by_me_history_input" type="text" placeholder="Search..">
          <div id="assigned_by_me_history" class='table table-responsive table-bordered table-striped'></div>
        </div>

        <div id="assign_new_task" class="tab-pane fade">
                    <div id="loading_task" class="row" style="display:none;">
                        <button class="buttonload btn btn-block">
                          <i class="fa fa-refresh fa-spin"></i>Please wait while we are sending email and loading all your tasks again.
                        </button>
                    </div>
                    <form role="form" id="create_task_form">

                      <div class="form-group">
                          <label for="requesters_list"><span class="glyphicon glyphicon-user"></span> Assigned By</label>
                          <select id="requesters_list" class="form-control">
                              <option>Assigned By</option> 
                          </select>
                       </div> 

                      <div class="form-group">
                        <label for="assigned_to"><span class="glyphicon glyphicon-user"></span> Assigned To</label>
                          <select id="assigned_to" class="form-control">
                              <option>Assigned To</option> 
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
                        <input type="text" class="form-control" id="task_due_date" placeholder="Task Due Date">
                       </div>                                  
                    </form>
                    <button type="button" id="create_task_button" class="btn btn-success btn-block" data-dismiss="modal" onclick="createNewTask();">
                      <span class="glyphicon glyphicon-off"></span> Create Task
                    </button>

        </div>
    </div>





  </div>
</body>


<script>
$('#create_task').click(function() {
    var $options = $("#requesters_list > option").clone();
    $('#assigned_to').append($options);
});


$(document).ready(function(){
  $("#assigned_to_me_open_input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#assigned_to_me_open_table tr").each(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


$(document).ready(function(){
  $("#assigned_to_me_history_input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#assigned_to_me_history_table tr").each(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#assigned_by_me_open_input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#assigned_by_me_open_table tr").each(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#assigned_by_me_history_input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#assigned_by_me_history_table tr").each(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


  $( function() {
    $( "#task_due_date" ).datepicker({
    dateFormat: "yy-mm-dd"
  });
  } );

</script>

</html>