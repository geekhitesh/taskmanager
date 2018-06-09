<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey</title>
    <!-- Bootstrap Css -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="css/my-style.css" rel="stylesheet"> -->
    <style>
    * {
    margin: 0px;
    padding: 0px;
}
body {
    /* font-family: 'Roboto', sans-serif;*/
    font-family: 'Oswald', sans-serif;
    overflow-x: hidden;
    letter-spacing: .5px;
    font-weight: 400;
    font-style: normal;
    color: #282828c7;
    font-size: 14px;
}
.custom_body {
    background-color: #efeee5;
    /*background: linear-gradient(135deg, rgba(72, 214, 36, 0.98) 0%, rgba(56, 99, 255, 1) 107%, rgba(26, 35, 147, 1) 122%, rgba(111, 237, 46, 1) 100%);*/
    float: left;
    width: 100%;
    min-height: 660px;
}
.btn.btn-default.btn_style.sugbtn {
    background-color: #025d80;
    border-radius: 0px;
}
.buniyad-logo {
    width: 210px;
}
.logo-sec {
    text-align: center;
    padding-bottom: 0px;
}
.btn.btn-default.btn_style.sugbtn:hover {
    background-color: #dc8629;
}
label {
    display: inline-block;
    max-width: 100%;
    font-weight: 700;
    margin-bottom: 10px;
}
.login_box {
    margin: 0 auto;
    max-width: 500px;
    min-width: 320px;
    width: 100%;
}
.input-box {
    float: left;
    margin-bottom: 10px;
    text-align: left;
    width: 100%;
}
.i_icon {
    border: medium none;
    border-radius: 0;
    color: #3965a0;
    float: left;
    padding: 12px;
    top: 32px;
    width: 40px;
}
.input_layout {
    border: medium none;
    border-radius: 0;
    float: left;
    height: 40px;
    margin: 0;
    padding: 0 10px;
    width: 89%;
}
.main-box {
    /*background: rgba(255, 251, 251, 0.41) none repeat scroll 0 0;*/
    background: #fff;
    float: left;
    margin-bottom: 15px;
    margin-top: 15px;
    padding: 20px 20px;
    width: 100%;
    border: 1px solid #fff;
    box-shadow: 0px 5px 5px 5px #ababab;
}
.btn_style {
    background-color: rgb(10, 56, 117);
    color: #fff;
    padding: 10px 0;
    width: 100%;
    border: none;
}
.btn_style:hover {
    background-color: rgba(57, 101, 160, 1);
    color: #ffffff;
}
.note {
  position: relative;
 
}

.note:before {
    /*content: "";
    position: absolute;
    top: 15px;
    right: 0px;
    border-width: 0 20px 20px 0;
    border-style: solid;
    border-color: #efeee5 #efeee5 #e89337 #efeee5;
    background: #efeee5;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
    -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
    box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
    display: block;
    width: 0;*/
    width: 0;
    content: "";
    display: block;
    top: 15px;
    right: 0px;
    position: absolute; 
  height: 0;
  border-bottom: 20px solid #e89337;
  border-right: 20px solid transparent;
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
    -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
    box-shadow: 0 1px 1px rgba(0,0,0,0.3), -1px 1px 1px rgba(0,0,0,0.2);
}

.note.rounded {
  -moz-border-radius: 5px 0 5px 5px;
  border-radius: 5px 0 5px 5px;
}

.note.rounded:before {
  border-width: 8px;
  border-color: #fff #fff transparent transparent;
  -moz-border-radius: 0 0 0 5px;
  border-radius: 0 0 0 5px;
}
  </style>
  </head>
  <body>
    <!-- Start Login Section -->
    <div class="custom_body">
      <div class="container">
        <div class="row">
          <div class="login_box note">
            <section class="main-box">
              <div class="logo-sec"><img src="http://gosafe.co.in/Mailer/logo.png" class="buniyad-logo" alt="logo"></div>
              <hr>
              <p>Dear Employee,</p>
              <p>To improve the work envrionment, we are conducting this survey. 
                Please submit this survey at the earliest :-   
              </p>
              <form method="POST" action="../submit">
                <div class="input-box">
                  <div class="form-group">
                    <label>Any problems you are facing ?</label>
                    <textarea class="form-control" required name = "survey_question1_result" rows="5" id="survey_question1_result" placeholder="Message"></textarea>
                  </div>
                </div>
                <div class="input-box">
                  <div class="form-group">
                    <label>Suggestions:</label>
                    <textarea class="form-control" required name = "survey_question2_result" rows="5" id ="survey_question1_result" placeholder="Message"></textarea>
                  </div>
                </div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
				<input type="hidden" name="user_survey_link" id="user_survey_link" value="{{$user_survey_link}}" />
                <input type="submit" class="btn btn-default btn_style sugbtn">
			  </form>
              
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- End Login Section -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>