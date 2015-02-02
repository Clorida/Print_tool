<!DOCTYPE html>
<?php
//session_start();
?>
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
	.art_serach
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
	/*.art_container{
	width: 535px;
	margin: 0 auto;
	}*/
	.art_container {
    width: 580px;
    /*margin: 0 200px;*/
    margin: 0 auto;
}

	.art{
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
.art img {
	width: 100px;
	height: 120px;
}
</style>
</head>
<body>
<div class="art_serach" style="display:none;">
	
</div> 

<div class="art_container">
	<?php
		$current_url = $_GET['current_url'];
		$url = parse_url($current_url);
		//print_r($url);
		$parameters = $url["query"];
		parse_str($parameters, $data);
		//print_r($data);
		$cus_id = $data['idcus'];
	   	define('DIR_PATH','../../../modules/premiumprint_fo/controllers/front/');
	   	//echo $_SESSION['idcus'];
		//echo $prod_id = $_GET['id_prod'];
		$temp_path=$_GET['temp_path'];
		$im_path=$_GET['image_id'];
		$con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
	    mysqli_select_db($con,"clorida1_premiumprint");
		$gettemplate=mysqli_query($con,"SELECT * FROM xmr_fabric_Tempcustomer_design where customer_id='".$cus_id."'");
		while($gettemplates=mysqli_fetch_array($gettemplate))
	   	{
	   	     $image_name=$gettemplates['image_name'];
	   	     $cus_id=$gettemplates['customer_id'];
	   	     echo '<div class="art">
	   	     			<a href="'.DIR_PATH.''.$cus_id.'/'.$image_name.'">
   							<img src="'.DIR_PATH.''.$cus_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50" style="float:left">
						</a>
					</div>';
	   	}  
		/*while ($row = mysqli_fetch_array($get_image))
		{
		 	$image_name=$row['thumbnail_template_name'];
		    $ind_id=$row['category_id'];

		 	echo '<div class="art"><a href="'.DIR_PATH.$ind_id.'/'.$image_name.'">
		 		  <img src="'.DIR_PATH.$ind_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50"></a></div>';
		}		 
		$get_image=mysqli_query($con,"select * from xmr_fabric_clipart");
		while ($row = mysqli_fetch_array($get_image))
		{
		 	$image_name=$row['thumbnail_template_name'];
		 	$ind_id=$row['category_id'];

		 	echo '<div class="art"><a href="'.DIR_PATH.$ind_id.'/'.$image_name.'">
		 		  <img src="'.DIR_PATH.$ind_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50"></a></div>';
		}*/
	?>
</div>
<!-- <a href="smiley.svg">smiley.svg</a>
<br>
<a href="../../images/logo.png">logo.png</a> -->

<script>
/*globals $*/
/*jslint vars: true*/
$('a').click(function() {'use strict';
	var meta_str1;
	var href = this.href;
	var target1 = window.parent;
	// Convert Non-SVG images to data URL first 
	// (this could also have been done server-side by the library)
	if (this.href.indexOf('.svg') === -1) {

		meta_str1 = JSON.stringify({
			name: $(this).text(),
			id: href
		});
		target1.postMessage(meta_str1, '*');

		var img1 = new Image();
		img1.onload = function() {
			var canvas1 = document.createElement('canvas1');
			canvas1.width = this.width;
			canvas1.height = this.height;
			// load the raster image into the canvas1
			canvas1.getContext('2d').drawImage(this, 0, 0);
			// retrieve the data: URL
			var dataurl;
			try {
				dataurl = canvas1.toDataURL();
			} catch(err) {
				// This fails in Firefox with file:// URLs :(
				alert("Data URL conversion failed: " + err);
				dataurl = "";
			}
			target1.postMessage('|' + href + '|' + dataurl, '*');
		};
		img1.src = href;
	} else {
		// Send metadata (also indicates file is about to be sent)
		meta_str1 = JSON.stringify({
			name: $(this).text(),
			id: href
		});
		target1.postMessage(meta_str1, '*');
		// Do ajax request for image's href value
		$.get(href, function(data) {
			data = '|' + href + '|' + data;
			// This is where the magic happens!
			target1.postMessage(data, '*');
			
		}, 'html'); // 'html' is necessary to keep returned data as a string
	}
	return false;
});

</script>
</body>
</html>
