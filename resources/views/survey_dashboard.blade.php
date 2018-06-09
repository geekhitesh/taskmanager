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
  <script src="../../survey.js?2"></script>
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


<body onload="init();">

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

	<nav class="navbar navbar-default">
		<!--<div class="navbar-header">
			<a class="navbar-brand" href="#">www.buniyadtransparency.com</a>
		</div>-->
		<div class="container-fluid">
			<ul id="survey_list" class="pagination">
			</ul>
			<div id="loading_surveys" style="display:none;" >
				<h1> Loading Surveys.. Please Wait </h1>
				<img src="../../loading.gif" alt="loading surveys" />
			</div>
		</div>
	</nav>
	
	
  
	<div class="container">
	  <h3 id="survey_results_header">Survey Results</h3>
	  	
		<div class="row"> 
			<input class="form-control" id="serch_feedback" type="text" placeholder="Search..">
		</div>
		<br/>
		<div id="survey_results" style="display:none;" class="row table-responsive"> 

		</div>
		<div id="loading_survey_results" style="display:none;" >
			<h1> Loading Survey Results.. Please Wait </h1>
			<img src="../../loading.gif" alt="loading surveys" />
		</div>		
	</div>
	
	
	
	<div class="modal fade" id="replyUserForm" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-body">

		  <div class="form-group">
			<label for="Email"><span class="glyphicon glyphicon-user"></span>User Email:</label>
			<input type="text" required class="form-control" id="user_email" name="user_email" placeholder="Email">
		  </div>    
		
		  <div class="form-group">
			  <label for="report_issue"><span class="glyphicon glyphicon-pencil"></span>Reply</label>
			  <textarea class="form-control" id="email_reply_text" rows="5" name="email_reply_text" placeholder="Reply to user"></textarea>
		  </div>      
		  
		  <input type="hidden" name="user_survey_id" id="user_survey_id" value=""/>
		  <button type="button" data-dismiss="modal" class="btn btn-success btn-block" onclick="respondToUser();"><span class="glyphicon glyphicon-off" ></span>Send Reply</button>          
		  
		  
			</div>
		  </div>
		  
		</div>
	</div> 

</body>


<script>

$(document).ready(function(){
  $("#serch_feedback").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#survey_results_table tr").each(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


</script>

</html>