<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
 <script type="text/javascript"src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript"src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script type="text/javascript">
                $(document).ready(function(){
                    $("#name").autocomplete({
                        source:'autocomplete.php',
                        minLength:1
                    });
                });
        </script>
       <!--  <script>
				  			$(".categorylist").change(function()
								{
									$.ajax({
						                type: "POST",
						                url: "filter.php",
						                data: {ajax:true, category_id:$(".categorylist").val()},
									    success:function(msg){     
						    			console.log(msg);
						    			$(".categorylist").html(msg);
						    			}
									});
								});
								 
								    </script>	-->
    <style>
	.shape_serach
	{
		margin: 0px auto 15px;
		text-align: center;
	}
	.search_btn{
padding: 10px 20px;
border: medium none;
border-radius: 4px;
background: none repeat scroll 0% 0% #1BA1E2;
cursor: pointer;
color: #FFF;
margin-top: 5px;
	}
	.ui-menu-item
	{
		list-style: outside none none;
	background: none repeat scroll 0% 0% #DBDBDB;
	width: 295px;
	margin-left: -39px !important;
	padding-left: 10px;
	cursor: pointer;
	border: #F5F5F5 0.5px solid;
	padding: 5px;
	}
	/*.shape_container{
	width: 535px;
	margin: 0 auto;
	}*/
	.shape_container {
    width: 580px;
    /*margin: 0 200px;*/
    margin: 0 auto;
}

	.shapes{
		float: left;
		margin: 5px;
		background: #E7E7E7;
		padding: 5px;
		border-radius: 5px;
	}

.ui-autocomplete {
 /*   left: -59px !important;
    width: 270px !important;*/
/*    width: 270px !important;
list-style: none;
margin-top: 0px !important;
z-index: 99999 !important;*/
width: 270px !important;
list-style: outside none none;
margin-top: -265px !important;
z-index: 99999 !important;
margin-left: -240px;
float: left !important;
}

.cat_list{
	float: left;
border: 1px solid rgb(185, 185, 185);
/*margin-left: -200px;
padding-right: 40px;*/
position: relative;
border-radius: 10px;
margin: 0 auto;
}
.cat_li{
	float: left;
border-bottom: 1px solid rgb(185, 185, 185);
margin-left: 0px;
margin-right: 40px;
position: relative;
}
select.categorylist {
  padding: 10px;
  border: solid 1px #1BA1E2;
    width: 20%;
}
</style>
</head>
<body>
			<div class="shape_serach">
				<form method="post" action="">
				        
				            <input type="text" id="name" name="name" placeholder="serach shapes" 
	        					style="width: 40%;
	        						border: solid 1px #1BA1E2;padding: 10px; font-size: 14px; color: rgb(0, 0, 0);"/>
						   
				         
				        
				
								 <?php
				 						$con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
				        				 mysqli_select_db($con,"clorida1_premiumprint");
				        				 /*echo dirname(__FILE__).'<br>';*/
				        				 /*echo $_SERVER['DOCUMENT_ROOT'];*/
				        				 define('DIR_PATH', '../../../modules/premiumprint_bo/controllers/admin/clipart/');
				           					$get_ind=mysqli_query($con,"select * from xmr_fabric_industry_category");
				          				 ?>
								          		<select class="categorylist" name="industrialcategory">
											        <option value="all">All Category</option>
				 											<?php
													           while($getind=mysqli_fetch_array($get_ind))
													           {
													           	  $ind_id=$getind['id'];
													           	  $ind_name=$getind['industry_category_name'];
												           	?> 
											        <option value="<?= $ind_id ?>"><?= $ind_name ?></option>
															 <?php
									      					  	}
									      					  ?>
						      					</select>		
						    <input type="submit" name="submit" class="search_btn" value="search" class="shape_btn"  />	    
				</form>
			</div> 

<div class="shape_container">
<?php
 define('DIR_PATH', '../../../modules/premiumprint_bo/controllers/admin/clipart/');
 $con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
         mysqli_select_db($con,"clorida1_premiumprint");
       if (isset($_POST['submit']))
		{
		      $name = $_POST['name'];
		      $ind_cate=$_POST['industrialcategory'];
		$get_image=mysqli_query($con,"select * from xmr_fabric_clipart where thumbnail_template_name='".$name."' OR category_id='".$ind_cate."'");
		 while ($row = mysqli_fetch_array($get_image))
		 {
		 	$image_name=$row['thumbnail_template_name'];
		    $ind_id=$row['category_id'];

		 	echo '<div class="shapes"><a href="'.DIR_PATH.$ind_id.'/'.$image_name.'">
		 		  <img src="'.DIR_PATH.$ind_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50"></a></div>';
		 }
		}
		else
		{
		 $get_image=mysqli_query($con,"select * from xmr_fabric_clipart");
		 while ($row = mysqli_fetch_array($get_image))
		 {
		 	$image_name=$row['thumbnail_template_name'];
		 	$ind_id=$row['category_id'];

		 	echo '<div class="shapes"><a href="'.DIR_PATH.$ind_id.'/'.$image_name.'">
		 		  <img src="'.DIR_PATH.$ind_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50"></a></div>';
		 }
		}
?>

</div>
<!-- <a href="smiley.svg">smiley.svg</a>
<br>
<a href="../../images/logo.png">logo.png</a> -->

<script>
/*globals $*/
/*jslint vars: true*/
$('a').click(function() {'use strict';
	var meta_str;
	var href = this.href;
	var target = window.parent;
	// Convert Non-SVG images to data URL first 
	// (this could also have been done server-side by the library)
	if (this.href.indexOf('.svg') === -1) {

		meta_str = JSON.stringify({
			name: $(this).text(),
			id: href
		});
		target.postMessage(meta_str, '*');

		var img = new Image();
		img.onload = function() {
			var canvas = document.createElement('canvas');
			canvas.width = this.width;
			canvas.height = this.height;
			// load the raster image into the canvas
			canvas.getContext('2d').drawImage(this, 0, 0);
			// retrieve the data: URL
			var dataurl;
			try {
				dataurl = canvas.toDataURL();
			} catch(err) {
				// This fails in Firefox with file:// URLs :(
				alert("Data URL conversion failed: " + err);
				dataurl = "";
			}
			target.postMessage('|' + href + '|' + dataurl, '*');
		};
		img.src = href;
	} else {
		// Send metadata (also indicates file is about to be sent)
		meta_str = JSON.stringify({
			name: $(this).text(),
			id: href
		});
		target.postMessage(meta_str, '*');
		// Do ajax request for image's href value
		$.get(href, function(data) {
			data = '|' + href + '|' + data;
			// This is where the magic happens!
			target.postMessage(data, '*');
			
		}, 'html'); // 'html' is necessary to keep returned data as a string
	}
	return false;
});

</script>
</body>
</html>
