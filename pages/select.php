<?php


if(isset($_POST["task_id"]))  
{
    $output = '';

    $connect = mysqli_connect("localhost", "root", "BIGmorgan1999!", "wms");  
    $query = "SELECT * FROM task WHERE taskID = '".$_POST["task_id"]."'";  
    $result = mysqli_query($connect, $query);  


    $output .= '  
    <div class="table-responsive">  
         <table class="table table-bordered">';  
    while($row = mysqli_fetch_array($result))  
    {  
         $output .= '  
              <tr>  
                   <td width="30%"><label>Title</label></td>  
                   <td width="70%">'.$row["title"].'</td>  
              </tr>  
              <tr>  
                   <td width="30%"><label>Details</label></td>  
                   <td width="70%">'.$row["details"].'</td>  
              </tr>  
              <tr>  
                   <td width="30%"><label>Category</label></td>  
                   <td width="70%">'.$row["category"].'</td>  
              </tr>  
              <tr>  
                   <td width="30%"><label>Due Date</label></td>  
                   <td width="70%">'.$row["due_date"].'</td>  
              </tr> 
              ';  
    }  
    $output .= "</table></div>";  
    echo $output;  








}