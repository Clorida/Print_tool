<?php
 if(isset($_POST['svg']))
   {
         $svg = $_POST['svg'];
         $prod_id = $_POST['prod_id'];
         $idcus = $_POST['idcus'];
         $temp_path1=$_POST['temp_path'];
         $svg = strstr($svg, '<svg xmlns="');
         $svg = substr($svg, 0, strpos($svg, '<g id="selectorParentGroup"'));
         $cus_dir = $_POST['cus'];
         define('DIR_PATH',$_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/'.$idcus.'/');
          $get_temp=mysqli_query($con,"SELECT * from xmr_fabric_Tempcustomer_design where 
            customer_id='".$idcus."' and product_id='".$prod_id."' ");

         while($gettemp=mysqli_fetch_array($get_temp))
         {
             $customer_id=$gettemp['customer_id'];
             $product_id=$gettemp['product_id'];
             $image_id=$gettemp['image_id'];
             $image_name=$gettemp['image_name'];
         }
         
         
         $svg_name=$idcus.'_'.$prod_id.'_'.$image_id.'.svg';
         $write_file = DIR_PATH.$svg_name;
         $file = fopen($write_file, 'w');
         fwrite($file, $svg);
         fclose($file);
 }
?>
