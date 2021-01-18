<?php

$con = mysqli_connect('localhost', 'root', '');

$db = mysqli_select_db($con, 'suven');


?>



  <?php 
   if(isset($_POST['per']) && isset($_POST['jname']) )
   {
     $per = $_POST['per'];
     session_start();
     $_SESSION['user'] = $_POST['jname']; 

     $jname = $_POST['jname'];
       $qy = "insert into result(name, score) values('$jname', '$per')";
        $result = mysqli_query($con, $qy);

        if($result==true)
        {
          echo "Valid";
        }
        else
        {
          echo "Invalid";
        }
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quiz</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 <?php $query1 = "SELECT * From result ORDER BY id DESC LIMIT 1";
$result1 = mysqli_query($con,$query1);
$row1 = mysqli_fetch_array($result1);
$median = "";
session_start();


if (isset($_SESSION['user'])) {
//echo $_SESSION['user'];
  $jname = $_SESSION['user'];
$total = 0 ;
$query2 = "SELECT * From result where name ='$jname' ";
$result2 = mysqli_query($con,$query2);

$len = mysqli_num_rows($result2);


while($row2 = mysqli_fetch_array($result2))
{
  $total = $total + $row2['score'];
}

$median  = ($total/$len);

 
}




?>

 <div class="fluid-container">
  <div style="padding-top:20px" class="row">
    <div class="col-sm-1"></div>
      <div class="col-sm-2"><img style="height:90px" src="logo.png"></div>
    <div style="padding-top:20px" class="col-sm-6"><center><h2>Alpha Quiz System</h2></center></div>
    <div style="padding-top:70px" class="col-sm-3">
      <h6>
        <span style="background-color:#F3EDED;border-radius: 0;" class="badge badge-default">Total Numer of test takers: <?php echo ($row1['id']+1); ?></span>
    </h6>
  </div>



  </div>
  <hr>
 </div>

 <div style="padding-top:20px" class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="card">
          <div style="color:#A94442;background-color:#F2DEDE" class="card-header">
            

 <center><h3 id="result"></h3><h3 id="median">Median Score is: <?php  echo round($median, 2),"%"; ?></h3></center>


<?php 


  ?>
           

          </div>
          <div class="card-body">
            <center>
              <h4>Total No. of Questions : 20</h4>
              <h4 id="correct"></h4>
              <h4 id="wrong"></h4>
            </center>
         

          </div>
          <div class="card-footer text-muted">
              <h5 id="suggest"></h5>
    
          </div>
      </div>
    </div>
    <div class="col-sm-1"></div>

  </div>



<div style="padding-top:20px" class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="card">
          <div style="color:white;background-color: #337AB7" class="card-header">QUIZ ANALYSIS</div>
          <div class="card-body">
              <table style="background-color: #F2DEDE;color:#A94442" class="table table-bordered">
               
                 <div class="row">
                   <div class="col-sm-3">Q No</div>
                   <div class="col-sm-5">User Answer</div>
                   <div class="col-sm-4">Marks Alloacated</div>

                 </div>
               
                <tbody>
                  <script type="text/javascript" src="json/datasec2.json"></script>
                   <script type="text/javascript" src="data.json"></script>

                  <script >
                    
                        counter=0;
                        index=0;
                        var score = 0;
                        var arr = JSON.parse(window.localStorage.getItem("arr"));
                        var mydata = JSON.parse(data);

                        var mydatalogin = JSON.parse(datalogin);
                        jname = mydatalogin[0].name;
                        

                        for(i=0; i<=19; i++)
                        {
                      
                          jans = mydata[counter].options[arr[i]-1];
                          jmatch = mydata[counter].ans;
                          jcon = parseInt(jmatch, 10);
                          jcon2 = parseInt(arr[i], 10);

                          document.write("<tr id='row2'><td width=23%>" + (i+1) + "</td>");
                          document.write("<td width=40%>" + jans + "</td>");
                          if(jcon == jcon2)
                          {
                             score++;
                            document.write("<td width=30%>1 Marks</td></tr>");
                          
                          }
                          else
                          {
                       
                             document.write("<td>0 Marks</td></tr>");
                         
                          }
                            counter++;
                            
                      
                        }

                        var per = ((score*100)/20);
                        document.getElementById("result").innerHTML="Your Score is: " +per+"%";
                         document.getElementById("correct").innerHTML="Your Correct answer is : " +score;
                          document.getElementById("wrong").innerHTML="Your Wrong Answer is: " +(20-score);

                          if(score < 5)
                          {
                             document.getElementById("suggest").innerHTML="Upsss !! You need Serious Improvement "; 
                          }
                          else if(score > 5 && score < 10)
                          {
                              document.getElementById("suggest").innerHTML="Good !! You need Improvement "; 
                          }
                          else if(score > 10 && score < 15)
                          {
                              document.getElementById("suggest").innerHTML="Better !! You are Doing Better "; 
                          }
                          else
                          {
                              document.getElementById("suggest").innerHTML="Best !! Good Job "; 
                          }

                        $.ajax({
                            type: "POST",
                            url: "final.php",
                            data: {per:per,jname:jname},
                            success:function(data){

          
      

                            },
                          
                          });


                      

                      
                    
               </script>
  
                </tbody>
              </table>
       
         

          </div>
      </div>
    </div>
    <div class="col-sm-1"></div>

  </div>

</body>
</html>
