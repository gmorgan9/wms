<?php


if(isset($_POST["meeting_id"]))  
{
    $output = '';

    $connect = mysqli_connect("localhost", "root", "BIGmorgan1999!", "wms");  
    $query = "SELECT * FROM meeting WHERE meetingID = '".$_POST["meeting_id"]."'";  
    $result = mysqli_query($connect, $query);  


    $output .= '  
    <div class="table-responsive">  
         <table class="table table-bordered">';  
    while($row = mysqli_fetch_array($result)) {  
        $output .= ' 
    <div class="col-md-8 w-100">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Title</h6>
                    </div>
                    <div class="col-sm-9 text-start">
                        '.$row["title"].'
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date</h6>
                    </div>
                    '. $f_date = date('M d, Y', strtotime($row['date'])) .'
                    <div class="col-sm-9 text-center">
                        '.$f_date.'
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Details</h6>
                    </div>
                    <div class="col-sm-9 text-start">
                        '.$row["details"].'
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Location</h6>
                    </div>
                    <div class="col-sm-9 text-start">
                        '.$row["location"].'
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Link</h6>
                    </div>
                    <div class="col-sm-9 text-start">
                        '.$row["link"].'
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    ';  
    }  
    $output .= "</table></div>";  
    echo $output;  








}