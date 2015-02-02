 <?php
     $con = mysql_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint') or die("error");
         mysql_select_db("clorida1_premiumprint");
     
     $term=$_GET["term"];
     
     $query=mysql_query("SELECT DISTINCT thumbnail_template_name FROM xmr_fabric_clipart where thumbnail_template_name like '%".$term."%' order by id ");
     $json=array();
     
        while($student=mysql_fetch_array($query)){
             $json[]=array(
                        'value'=> $student["thumbnail_template_name"],
                        'label'=>$student["thumbnail_template_name"]
                         );
        }
     
     echo json_encode($json);
     
    ?>