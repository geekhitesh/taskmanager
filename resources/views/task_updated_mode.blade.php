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

<body onload="getAllAssignedToTasks();">
  <div class="container-fluid">
      <div class=" row alert alert-success">
       <b> Task {{$task[0]->task_id}} is updated successfully. </b>
      </div>
  </div>
</body>
</html>