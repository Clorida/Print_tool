<?php
  $con = mysql_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
       mysql_select_db("clorida1_premiumprint");
            if(isset($_GET['id']))
        {
            $ind_id=$_GET['id'];
            
            $getind=mysql_query("SELECT * from xmr_fabric_clipart where category_id='".$ind_id."'");
            while($get_ind=mysql_fetch_array($getind))
            {
                    $indid=$get_ind['category_id'];
                    $tempname=$get_ind['thumbnail_template_name'];
                    echo'<div class="shapes"><a href="http://192.169.197.129/dev/premiumprint/modules/premiumprint_bo/controllers/admin/clipart/'.$indid.'/'.$tempname.'">
                          <img src="http://192.169.197.129/dev/premiumprint/modules/premiumprint_bo/controllers/admin/clipart/'.$indid.'/'.$tempname.'" 
                          background="#a8a8a8" width="100" heigth="50"></a></div>';
            }

        }
     
    
     
    ?>