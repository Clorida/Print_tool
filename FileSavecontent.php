
<?php
        $svg1=$_GET['svg'];

        $out=base64_encode($svg1);
          
        define('DIR_PATH',$_SERVER['DOCUMENT_ROOT'].'print/');
		echo DIR_PATH;
		

			
			$filteredData = explode(',', $out); 
			
			$randomName = rand(0, 99999);; 
			
			 $fp = fopen(DIR_PATH.$randomName.'.svg', 'w'); 



			fwrite($fp, $filteredData); 
			


			fclose($fp); 
			//$q=mysql_query("insert into images (name) values($fp)") or die (mysql_error()); 

					?>
	
        
