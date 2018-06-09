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
  <script src="http://localhost/tutorialsbin/public/taskmanager.js"></script>

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

<body>



  <form role="form" action="../update-task" method="POST">
      <div class="form-group">
            <label for="task_status"> <span class="glyphicon glyphicon-flag"></span> Task Status</label>
              <select id="task_status" name="task_status" class="form-control">
                <option>Open</option> 
                <option>Close</option>
              </select>
      </div>

      <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
      <div class="form-group">
          <label for="task_closure_comments"><span class="glyphicon glyphicon-envelope"></span> Task Closure Comments</label>
          <textarea type="text" class="form-control" required id="task_closure_comments" name="task_closure_comments" value="" placeholder="Task Closure Comments"></textarea>
      </div>

      <div class="form-group">
        <label for="task_id"><span class="glyphicon glyphicon-user"></span> Task Number</label>
        <input type="text" class="form-control" readonly name="task_id" id="task_id" value={{$task[0]->task_id}} placeholder="Task Number">
       </div> 

      <div class="form-group">
        <label for="task_owner"><span class="glyphicon glyphicon-user"></span> Task Owner</label>
        <input type="text" class="form-control" disabled id="task_owner" value={{$task[0]->task_assigned_by_email}} placeholder="Task Owner">
       </div> 

      <div class="form-group">
        <label for="task_owner"><span class="glyphicon glyphicon-user"></span> Assigned To</label>
        <input type="text" class="form-control" disabled id="task_owner" value={{$task[0]->task_assigned_to_email}} placeholder="Assigned To">
       </div>   
       <div class="form-group">
        <label for="task_summary"><span class="glyphicon glyphicon-pencil"></span> Task Summary</label>
        <input type="text" class="form-control" disabled id="task_summary" value={{$task[0]->task_summary}} placeholder="Task Summary">
       </div>
       <div class="form-group">
        <label for="task_description"><span class="glyphicon glyphicon-envelope"></span> Task Description</label>
        <textarea type="text" class="form-control" disabled id="task_description" value={{$task[0]->task_description}}  placeholder="Task Description"></textarea>
       </div>
       <div class="form-group">
        <label for="task_due_date"><span class="glyphicon glyphicon-calendar"></span> Task Due Date</label>
        <input type="text" class="form-control" disabled  id="task_due_date" value={{$task[0]->task_expiration_date}} placeholder="Task Due Date">
       </div>

       <div class="form-group">
          <button type="submit" class="btn btn-success btn-block">
            <span class="glyphicon glyphicon-off"></span> 
            Update Task
          </button>
       </div>

  </form>

</body>



</html>

