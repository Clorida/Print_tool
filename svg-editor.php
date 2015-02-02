<?php
session_start();
?>
<!DOCTYPE html>
<html>
   <!-- removed for now, causes problems in Firefox: manifest="svg-editor.manifest" -->
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
      <meta name="apple-mobile-web-app-capable" content="yes"/>
      <link rel="icon" type="image/png" href="images/logo.png"/>
      <link rel="stylesheet" href="jgraduate/css/jPicker.css" type="text/css"/>
      <link rel="stylesheet" href="jgraduate/css/jgraduate.css" type="text/css"/>
      <link rel="stylesheet" href="svg-editor.css" type="text/css"/>
      <link rel="stylesheet" href="font.css" type="text/css"/>
      <link rel="stylesheet" href="spinbtn/JQuerySpinBtn.css" type="text/css"/>
      <script src="http://jwpsrv.com/library/YOUR_JW_PLAYER_ACCOUNT_TOKEN.js" ></script>
      <!--{if jquery_release}>
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
         <!{else}-->
      <script src="jquery.js"></script>
      <!--{endif}-->
      <script src="js-hotkeys/jquery.hotkeys.min.js"></script>
      <script src="jquerybbq/jquery.bbq.min.js"></script>
      <script src="svgicons/jquery.svgicons.js"></script>
      <script src="jgraduate/jquery.jgraduate.min.js"></script>
      <script src="spinbtn/JQuerySpinBtn.min.js"></script>
      <script src="touch.js"></script>
      <!--{if svg_edit_release}-->
      <script src="svgedit.compiled.js"></script>
      <!--{else}>
         <script src="svgedit.js"></script>
         <script src="jquery-svg.js"></script>
         <script src="contextmenu/jquery.contextMenu.js"></script>
         <script src="browser.js"></script>
         <script src="svgtransformlist.js"></script>
         <script src="math.js"></script>
         <script src="units.js"></script>
         <script src="svgutils.js"></script>
         <script src="sanitize.js"></script>
         <script src="history.js"></script>
         <script src="coords.js"></script>
         <script src="recalculate.js"></script>
         <script src="select.js"></script>
         <script src="draw.js"></script>
         <script src="path.js"></script>
         <script src="svgcanvas.js"></script>
         <script src="svg-editor.js"></script>
         <script src="locale/locale.js"></script>
         <script src="contextmenu.js"></script>
         <!{endif}-->
      <!-- If you do not wish to add extensions by URL, you can load them
         by creating the following file and adding by calls to svgEditor.setConfig -->
      <script src="config.js"></script>
      <!-- always minified scripts -->
      <script src="jquery-ui/jquery-ui-1.8.17.custom.min.js"></script>
      <script src="jgraduate/jpicker.js"></script>
      <!-- feeds -->
      <link rel="alternate" type="application/atom+xml" title="SVG-edit General Discussion" href="http://groups.google.com/group/svg-edit/feed/atom_v1_0_msgs.xml" />
      <link rel="alternate" type="application/atom+xml" title="SVG-edit Updates (Issues/Fixes/Commits)" href="http://code.google.com/feeds/p/svg-edit/updates/basic" />
      <!-- Add script with custom handlers here -->
      <title>SVG-edit</title>



      <script>
   function previewFile(){
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           preview.src = reader.result;
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
  }

  previewFile();  //calls the function named previewFile()
  </script>

  <script>
  $("#background_image").error(function () {
    $(this).hide();
    // or $(this).css({visibility:"hidden"});
});
</script>

<script type="text/javascript">// <![CDATA[

  //Function to hide the loading div
  function loadingDivHide()
  {
      document.getElementById("loading_div").style.display = "none";
      document.getElementById("content_area_div").style.display = "";
  }

// ]]></script>
   </head>
   <body>
     <body onload="loadingDivHide()">

     <div id="loading_div">
<img src="ajax-loader.gif"  height="66" width="66"><br>
<h1>Loading...</h1>
</div>
      <div id="svg_editor">
         <div id="rulers">
            <div id="ruler_corner"></div>
            <div id="ruler_x">
               <div>
                  <canvas height="15"></canvas>
               </div>
            </div>
            <div id="ruler_y">
               <div>
                  <canvas width="15"></canvas>
               </div>
            </div>
         </div>
         <div id="workarea">
            <style id="styleoverrides" type="text/css" media="screen" scoped="scoped"></style>
            <div id="svgcanvas" style="position:relative">
            </div>
         </div>
         <div id="sidepanels">
            <div id="layerpanel">
               <h3 id="layersLabel">Layers</h3>
               <fieldset id="layerbuttons">
                  <div id="layer_new" class="layer_button"  title="New Layer"></div>
                  <div id="layer_delete" class="layer_button"  title="Delete Layer"></div>
                  <div id="layer_rename" class="layer_button"  title="Rename Layer"></div>
                  <div id="layer_up" class="layer_button"  title="Move Layer Up"></div>
                  <div id="layer_down" class="layer_button"  title="Move Layer Down"></div>
                  <div id="layer_moreopts" class="layer_button"  title="More Options"></div>
               </fieldset>
               <table id="layerlist">
                  <tr class="layer">
                     <td class="layervis"></td>
                     <td class="layername">Layer 1</td>
                  </tr>
               </table>
               <!-- <span id="selLayerLabel">Move elements to:</span> -->
               <select id="selLayerNames" title="Move selected elements to a different layer" disabled="disabled">
                  <option selected="selected" value="layer1">Layer 1</option>
               </select>
            </div>
            <div id="sidepanel_handle" title="Drag left/right to resize side panel [X]"><p class="layer_title">MULTIPLE PAGES CLICK HERE</p></div>
         </div>
         <div class="top_bar">
            <div id="main_button">
            <!-- <div id="main_icon" class="tool_button" title="Main Menu">
               <span>SVG-Edit</span>
               <div id="logo"></div>
               <div class="dropdown"></div>
               </div> -->
            <div id="main_menu">
              <ul>
            <!-- File-like buttons: New, Save, Source -->

               <!-- <div id="tool_clear">
               	<div></div>
               	New Image (N)
               </div> -->
<!--             <div id="tool_open">
               <div id="fileinputs">
                  <div></div>
               </div>
               <span class="open_label">Open</span>
            </div> -->
            <!-- <li id="tool_import" style="display:none;">
               <div id="fileinputs_import">
               	<div></div>
               </div>
               Import Image
               </li> -->
           <!--  <div id="tool_save">
               <div></div>
               <span class="open_label">Save</span>
            </div> -->
           <!--  <div class="save_draft">
               <span class="open_save"><img src="images/save.png"/></span>
            </div>
            <div id="tool_export">
               <div></div>
               <span class="open_label">Export</open>
            </div> -->
            <div id="save_draft">
               <span class="open_save"><img src="images/save.png"/>Save</span>
            </div>
            <div class="save_draft">
               <div></div>
               <span class="open_label"><img src="images/submit.png"/>Submit</open>
            </div>
<!--             <div class="help">
               <a href="#loginScreen"><img class="img_help" src="images/artwork.png"/><span class="help_title1">Your Artworks</span>
                     </a>
            </div> -->
                        <div class="help">
               <a href="#help"><img class="img_help" src="images/help.png"/><span class="help_title">Help</span>
                     </a>
            </div>



            <!-- <div id="tool_docprops">
               <div></div>
               Document Properties (D)
             </div> -->

          </ul>
               <!-- <p>
               	<a href="http://svg-edit.googlecode.com/" target="_blank">
               		SVG-edit Home Page
               	</a>
               </p> -->

               <!-- <button id="tool_prefs_option">
               	Editor Options
               </button> -->
            </div>
            </div>
            <div id="tools_top" class="tools_panel">
               <!-- <div id="editor_panel">
                  <div class="tool_sep"></div>
                  <div class="push_button" id="tool_source" title="Edit Source [U]"></div>
                  <div class="tool_button" id="tool_wireframe" title="Wireframe Mode [F]"></div>
                  </div> -->
               <!-- History buttons -->
               <div id="history_panel">
                  <div id="tool_import" style="display:none;">
                     <div id="fileinputs_import">
                        <div></div>
                     </div>
                     <span class="import_label">Image</span>
                  </div>
                  <div class="tool_button" id="tool_text" title="Text Tool"><span class="menu_label">Text</span></div>
                  <div class="push_button tool_button_disabled" id="tool_undo" title="Undo [Z]"><span class="menu_label">Undo</span></div>
                  <div class="push_button tool_button_disabled" id="tool_redo" title="Redo [Y]"><span class="menu_label">Redo</span></div>
               </div>
               <!-- Buttons when a single element is selected -->
               <div id="selected_panel">
                  <div class="toolset">
                     <div class="push_button" id="tool_clone" title="Duplicate Element [D]"><span class="menu_label">Clone</span></div>
                     <div class="push_button" id="tool_delete" title="Delete Element [Delete/Backspace]"><span class="menu_label">Delete</span></div>
                     <!-- <div class="push_button" id="tool_move_top" title="Bring to Front [ Ctrl+Shift+] ]"><span class="menu_label1">Move Front</span></div>
                     <div class="push_button" id="tool_move_bottom" title="Send to Back [ Ctrl+Shift+[ ]"><span class="menu_label1">Move Back</span></div> -->
                     <!-- <div class="push_button" id="tool_topath" title="Convert to Path"></div>
                        <div class="push_button" id="tool_reorient" title="Reorient path"></div>
                        <div class="push_button" id="tool_make_link" title="Make (hyper)link"></div>
                        <div class="tool_sep"></div>
                        <label id="idLabel" title="Identify the element">
                        	<span>id:</span>
                        	<input id="elem_id" class="attr_changer" data-attr="id" size="10" type="text"/>
                        </label> -->
                  </div>
               <!--    <label id="tool_angle" title="Change rotation angle" class="toolset">
                  <span id="angleLabel" class="icon_label"><span class="menu_label">Rotation</span></span>
                  <input id="angle" size="2" value="0" type="text"/>
                  </label> -->
                  <!-- <div class="toolset" id="tool_blur" title="Change gaussian blur value">
                     <label>
                     	<span id="blurLabel" class="icon_label"></span>
                     	<input id="blur" size="2" value="0" type="text"/>
                     </label>
                     <div id="blur_dropdown" class="dropdown">
                     	<button></button>
                     	<ul>
                     		<li class="special"><div id="blur_slider"></div></li>
                     	</ul>
                     </div>
                     </div> -->
                  <!-- <div class="dropdown toolset" id="tool_position" title="Align Element to Page">
                     <div id="cur_position" class="icon_label"></div>
                     <button></button>
                     </div> -->
                  <!-- <div id="xy_panel" class="toolset">
                     <label>
                     	x: <input id="selected_x" class="attr_changer" title="Change X coordinate" size="3" data-attr="x"/>
                     </label>
                     <label>
                     	y: <input id="selected_y" class="attr_changer" title="Change Y coordinate" size="3" data-attr="y"/>
                     </label>
                     </div> -->
               </div>
               <!-- Buttons when multiple elements are selected -->
               <div id="multiselected_panel">
                  <!-- <div class="tool_sep"></div>
                     <div class="push_button" id="tool_clone_multi" title="Clone Elements [C]"></div>
                     <div class="push_button" id="tool_delete_multi" title="Delete Selected Elements [Delete/Backspace]"></div>
                     <div class="tool_sep"></div> -->
                 <!--  <div class="push_button" id="tool_group_elements" title="Group Elements [G]">Group</div> -->
                  <!-- <div class="push_button" id="tool_make_link_multi" title="Make (hyper)link"></div> -->
                  <!-- <div class="push_button" id="tool_alignleft" title="Align Left"></div>
                     <div class="push_button" id="tool_aligncenter" title="Align Center"></div>
                     <div class="push_button" id="tool_alignright" title="Align Right"></div>
                     <div class="push_button" id="tool_aligntop" title="Align Top"></div>
                     <div class="push_button" id="tool_alignmiddle" title="Align Middle"></div>
                     <div class="push_button" id="tool_alignbottom" title="Align Bottom"></div> -->
                  <!-- <label id="tool_align_relative">
                     <span id="relativeToLabel">relative to:</span>
                     <select id="align_relative_to" title="Align relative to ...">
                     <option id="selected_objects" value="selected">selected objects</option>
                     <option id="largest_object" value="largest">largest object</option>
                     <option id="smallest_object" value="smallest">smallest object</option>
                     <option id="page" value="page">page</option>
                     </select>
                     </label> -->
                  <div class="tool_sep"></div>
               </div>
               <!-- <div id="rect_panel">
                  <div class="toolset">
                  	<label id="rect_width_tool" title="Change rectangle width">
                  		<span id="rwidthLabel" class="icon_label"></span>
                  		<input id="rect_width" class="attr_changer" size="3" data-attr="width"/>
                  	</label>
                  	<label id="rect_height_tool" title="Change rectangle height">
                  		<span id="rheightLabel" class="icon_label"></span>
                  		<input id="rect_height" class="attr_changer" size="3" data-attr="height"/>
                  	</label>
                  </div>
                  <label id="cornerRadiusLabel" title="Change Rectangle Corner Radius" class="toolset">
                  	<span class="icon_label"></span>
                  	<input id="rect_rx" size="3" value="0" type="text" data-attr="Corner Radius"/>
                  </label>
                  </div>

                  <div id="image_panel">
                  <div class="toolset">
                  <label><span id="iwidthLabel" class="icon_label"></span>
                  <input id="image_width" class="attr_changer" title="Change image width" size="3" data-attr="width"/>
                  </label>
                  <label><span id="iheightLabel" class="icon_label"></span>
                  <input id="image_height" class="attr_changer" title="Change image height" size="3" data-attr="height"/>
                  </label>
                  </div>
                  <div class="toolset">
                  <label id="tool_image_url">url:
                  	<input id="image_url" type="text" title="Change URL" size="35"/>
                  </label>
                  <label id="tool_change_image">
                  	<button id="change_image_url" style="display:none;">Change Image</button>
                  	<span id="url_notice" title="NOTE: This image cannot be embedded. It will depend on this path to be displayed"></span>
                  </label>
                  </div>
                  </div>

                  <div id="circle_panel">
                  <div class="toolset">
                  	<label id="tool_circle_cx">cx:
                  	<input id="circle_cx" class="attr_changer" title="Change circle's cx coordinate" size="3" data-attr="cx"/>
                  	</label>
                  	<label id="tool_circle_cy">cy:
                  	<input id="circle_cy" class="attr_changer" title="Change circle's cy coordinate" size="3" data-attr="cy"/>
                  	</label>
                  </div>
                  <div class="toolset">
                  	<label id="tool_circle_r">r:
                  	<input id="circle_r" class="attr_changer" title="Change circle's radius" size="3" data-attr="r"/>
                  	</label>
                  </div>
                  </div>

                  <div id="ellipse_panel">
                  <div class="toolset">
                  	<label id="tool_ellipse_cx">cx:
                  	<input id="ellipse_cx" class="attr_changer" title="Change ellipse's cx coordinate" size="3" data-attr="cx"/>
                  	</label>
                  	<label id="tool_ellipse_cy">cy:
                  	<input id="ellipse_cy" class="attr_changer" title="Change ellipse's cy coordinate" size="3" data-attr="cy"/>
                  	</label>
                  </div>
                  <div class="toolset">
                  	<label id="tool_ellipse_rx">rx:
                  	<input id="ellipse_rx" class="attr_changer" title="Change ellipse's x radius" size="3" data-attr="rx"/>
                  	</label>
                  	<label id="tool_ellipse_ry">ry:
                  	<input id="ellipse_ry" class="attr_changer" title="Change ellipse's y radius" size="3" data-attr="ry"/>
                  	</label>
                  </div>
                  </div>

                  <div id="line_panel">
                  <div class="toolset">
                  	<label id="tool_line_x1">x1:
                  	<input id="line_x1" class="attr_changer" title="Change line's starting x coordinate" size="3" data-attr="x1"/>
                  	</label>
                  	<label id="tool_line_y1">y1:
                  	<input id="line_y1" class="attr_changer" title="Change line's starting y coordinate" size="3" data-attr="y1"/>
                  	</label>
                  </div>
                  <div class="toolset">
                  	<label id="tool_line_x2">x2:
                  	<input id="line_x2" class="attr_changer" title="Change line's ending x coordinate" size="3" data-attr="x2"/>
                  	</label>
                  	<label id="tool_line_y2">y2:
                  	<input id="line_y2" class="attr_changer" title="Change line's ending y coordinate" size="3" data-attr="y2"/>
                  	</label>
                  </div>
                  </div>

                  <div id="text_panel">
                  <div class="toolset">
                  	<div class="tool_button" id="tool_bold" title="Bold Text [B]"><span></span>B</div>
                  	<div class="tool_button" id="tool_italic" title="Italic Text [I]"><span></span>i</div>
                  </div>

                  <div class="toolset" id="tool_font_family">
                  	<label>
                  		<!-- Font family -->
               <!-- <input id="font_family" type="text" title="Change Font Family" size="12"/>
                  </label>
                  <div id="font_family_dropdown" class="dropdown">
                  	<button></button>
                  	<ul>
                  		<li style="font-family:serif">Serif</li>
                  		<li style="font-family:sans-serif">Sans-serif</li>
                  		<li style="font-family:cursive">Cursive</li>
                  		<li style="font-family:fantasy">Fantasy</li>
                  		<li style="font-family:monospace">Monospace</li>
                  	</ul>
                  </div>
                  </div>

                  <label id="tool_font_size" title="Change Font Size">
                  <span id="font_sizeLabel" class="icon_label"></span>
                  <input id="font_size" size="3" value="0" type="text"/>
                  </label> -->
               <!-- Not visible, but still used -->
               <!-- <input id="text" type="text" size="35"/>
                  </div> -->
               <!-- formerly gsvg_panel -->
               <!-- <div id="container_panel">
                  <div class="tool_sep"></div> -->
               <!-- Add viewBox field here? -->
               <!-- <label id="group_title" title="Group identification label">
                  <span>label:</span>
                  <input id="g_title" data-attr="title" size="10" type="text"/>
                  </label>
                  </div>

                  <div id="use_panel">
                  <div class="push_button" id="tool_unlink_use" title="Break link to reference element (make unique)"></div>
                  </div> -->
               <div id="g_panel">
                  <div class="push_button" id="tool_ungroup" title="Ungroup Elements [G]"><span class="menu_label">Ungroup</span></div>
                   <div class="push_button" id="tool_group_elements" title="Group Elements [G]"><span class="menu_label">Group</span></div>
               </div>
               <!--  <div id="loginScreen">
                 <a href="#" class="cancel">&times;</a>
                 </div>
                 <div id="cover" > </div> -->
               <!-- For anchor elements -->
               <!-- <div id="a_panel">
                  <label id="tool_link_url" title="Set link URL (leave empty to remove)">
                  	<span id="linkLabel" class="icon_label"></span>
                  	<input id="link_url" type="text" size="35"/>
                  </label>
                  </div>

                  <div id="path_node_panel">
                  <div class="tool_sep"></div>
                  <div class="tool_button push_button_pressed" id="tool_node_link" title="Link Control Points"></div>
                  <div class="tool_sep"></div>
                  <label id="tool_node_x">x:
                  	<input id="path_node_x" class="attr_changer" title="Change node's x coordinate" size="3" data-attr="x"/>
                  </label>
                  <label id="tool_node_y">y:
                  	<input id="path_node_y" class="attr_changer" title="Change node's y coordinate" size="3" data-attr="y"/>
                  </label>

                  <select id="seg_type" title="Change Segment type">
                  	<option id="straight_segments" selected="selected" value="4">Straight</option>
                  	<option id="curve_segments" value="6">Curve</option>
                  </select>
                  <div class="tool_button" id="tool_node_clone" title="Clone Node"></div>
                  <div class="tool_button" id="tool_node_delete" title="Delete Node"></div>
                  <div class="tool_button" id="tool_openclose_path" title="Open/close sub-path"></div>
                  <div class="tool_button" id="tool_add_subpath" title="Add sub-path"></div>
                  </div> -->
               <!-- Zoom buttons -->
               <div id="zoom_panel" class="toolset" title="Change zoom level">
                  <label>
                  <span id="zoomLabel" class="zoom_tool icon_label"></span>
                  <input id="zoom" size="3" value="100" type="text" /><span class="top_unit">%</span>
                  </label>
                  <!-- <div id="zoom_dropdown" class="dropdown">
                     <button></button>
                     <ul>
                       <li>1000%</li>
                       <li>400%</li>
                       <li>200%</li>
                       <li>100%</li>
                       <li>50%</li>
                       <li>25%</li>
                       <li id="fit_to_canvas" data-val="canvas">Fit to canvas</li>
                       <li id="fit_to_sel" data-val="selection">Fit to selection</li>
                       <li id="fit_to_layer_content" data-val="layer">Fit to layer content</li>
                       <li id="fit_to_all" data-val="content">Fit to all content</li>
                       <li>100%</li>
                     </ul>
                     </div> -->
                  <div class="tool_sep"></div>
               </div>
            </div>

         </div>
         <!-- tools_top -->
         <div id="cur_context_panel">
         </div>
         <div id="tools_left" class="tools_panel">

<!-- text panel -->
               <div id="text_panel">
               <h1 class="side_title">Text</h1>
               <input id="text" type="text" size="20" placeholder="Enter your text"/>
                              <div class="toolset" id="tool_font_family">
                  <label>
                     <!-- Font family -->
                     <input id="font_family" type="text" title="Change Font Family" size="21"/>
                  </label>
                  <div id="font_family_dropdown" class="dropdown">
                     <button></button>
                     <ul>
                        <li style="font-family:serif">Serif</li>
                        <li style="font-family:sans-serif">Sans-serif</li>
                        <li style="font-family:cursive">Cursive</li>
                        <li style="font-family:fantasy">Fantasy</li>
                        <li style="font-family:monospace">Monospace</li>
                        <li style="font-family:bebas_neuebold">Bebas_Neuebold</li>
                        <li style="font-family:Alex Brush">Alex Brush</li>
                        <li style="font-family:Arial Narrow">Arial Narrow</li>
                        <li style="font-family:Arial Rounded MT Bold">Arial Rounded MT Bold</li>
                        <li style="font-family:Avenir">Avenir</li>
                        <li style="font-family:Baskerville">Baskerville</li>
                        <li style="font-family:Bembo">Bembo</li>
                        <li style="font-family:Century">Century</li>
                        <li style="font-family:Clarendon">Clarendon</li>
                        <li style="font-family:Cooper">Cooper</li>
                        <li style="font-family:Franklin Gothic">Franklin Gothic</li>
                        <li style="font-family:Frutiger">Frutiger</li>
                        <li style="font-family:Garamond">Garamond</li>
                        <li style="font-family:Gill Sans">Gill Sans</li>
                        <li style="font-family:Helvetica">Helvetica</li>
                        <li style="font-family:Minion Pro">Minion Pro</li>
                        <li style="font-family:Old English">Old English</li>
                        <li style="font-family:Perpetua">Perpetua</li>
                        <li style="font-family:Rockwell">Rockwell</li>
                        <li style="font-family:Stencil">Stencil</li>
                        <li style="font-family:Rubik Mono One">Rubik Mono One</li>
                        <li style="font-family:S2G Love">S2G Love</li>
                        <li style="font-family:Ubuntu">Ubuntu</li>
                     </ul>
                  </div>
               </div>
               <div class="toolset">
                  <div class="tool_button" id="tool_bold" title="Bold Text [B]"><span></span>B</div>
                  <div class="tool_button" id="tool_italic" title="Italic Text [I]"><span></span>I</div>
                  <div class="toll_button" id="tool_underline" title="Underline"><span></span>U</div>
               </div>
               <label id="tool_font_size" title="Change Font Size">
               <!-- <span id="font_sizeLabel" class="icon_label"></span> -->
               <input id="font_size" size="2" value="0" type="text"/><span class="font_label">pt</span>
               </label>
               <label id="tool_letter_spacing" title="Change letter spacing">
               <span id="letter_spacingLabel" class="icon_label"><img src="images/letter.png"/></span>
               <input id="letter_spacing" size="6" value="0" type="range"/>
               </label>
               <!-- <ul id="position_opts" class="optcols3">
                  <li class="push_button" id="tool_posleft" title="Align Left"></li>
                  <li class="push_button" id="tool_poscenter" title="Align Center"></li>
                  <li class="push_button" id="tool_posright" title="Align Right"></li> -->
                  <!-- <li class="push_button" id="tool_postop" title="Align Top"></li>
                     <li class="push_button" id="tool_posmiddle" title="Align Middle"></li>
                     <li class="push_button" id="tool_posbottom" title="Align Bottom"></li> -->
               <!-- </ul> -->
<!--                <div id="xy_panel" class="toolset">
                  <label>
                  x: <input id="selected_x" class="attr_changer" title="Change X coordinate" size="3" data-attr="x"/>
                  </label>
                  <label>
                  y: <input id="selected_y" class="attr_changer" title="Change Y coordinate" size="3" data-attr="y"/>
                  </label>
               </div> -->
               <!-- <li class="push_button" id="tool_postop" title="Align Top"></div>
                  <li class="push_button" id="tool_posmiddle" title="Align Middle"></li>
                  <li class="push_button" id="tool_posbottom" title="Align Bottom"></li> -->
               <!-- Not visible, but still used -->
               <!-- <input id="text" type="text" size="35"/> -->
               <!-- <div class="dropdown toolset" id="tool_position" title="Align Element to Page">
                  <div id="cur_position" class="icon_label"></div>
                  <button></button>
                  </div> -->
            </div>
            <!-- text panel ends -->




            <div class="obj_position">
               <h1 class="side_title">Object pose</h1>
                                   <div class="obj_pos">
                         <img class="img_corner"src="images/corner.png"/>

                           <div id="xy_panel" class="toolset">
                  <label>
                  x <input id="selected_x" class="attr_changer" title="Change X coordinate" size="3" data-attr="x"/>
                  </label>
                  <label>
                  y <input id="selected_y" class="attr_changer" title="Change Y coordinate" size="3" data-attr="y"/>
                  </label>
               </div>

               <div class="obj_width">

                  <div class="toolset">
                  <label><span id="iwidthLabel" class="icon_label">W</span>
                  <input id="image_width" class="attr_changer" title="Change image width" size="3" data-attr="width"/>
                  </label>
                  <label><span id="iheightLabel" class="icon_label">H</span>
                  <input id="image_height" class="attr_changer" title="Change image height" size="3" data-attr="height"/>
                  </label>
               </div>
            </div>
            </div>

                              <label id="tool_angle" title="Change rotation angle" class="toolset">
                  <!-- <span id="angleLabel" class="icon_label"> --><span class="menu_label"><img class="rotate_img" src="images/circular268.png"/></span></span>
                  <input id="angle" size="2" value="0" type="text"/>
                  </label>
                     <div class="push_button" id="flipx" title="flipX"><img src="http://192.169.197.129/dev/premiumprint/print/images/FLIPX.png"/></div>
                     <div class="push_button" id="flipy" title="flipY"><img src="http://192.169.197.129/dev/premiumprint/print/images/FLIPY.png"/></div>
                     <div class="push_button" id="tool_move_top" title="Bring to Front [ Ctrl+Shift+] ]"><span class="menu_label1"></span></div>
                     <div class="push_button" id="tool_move_bottom" title="Send to Back [ Ctrl+Shift+[ ]"><span class="menu_label1"></span></div>
            </div>


           <!-- <div id="svg_docprops"> -->
              <!-- <div class="overlay"></div> -->
              <!-- <div id="svg_docprops_container"> -->
                 <!-- <div id="tool_docprops_back" class="toolbar_button"> -->
                    <!-- <button id="tool_docprops_save">OK</button> -->
                    <!-- <button id="tool_docprops_cancel">Cancel</button> -->
                 <!-- </div> -->
                 <div class="color_side">
                    <h1 class="side_title">Object/Outline color</h1>
                    <div id="palette_holder">
                       <div id="palette" title="Click to change fill color, shift-click to change stroke color"></div>
                    </div>
                    <div class="color_tool" id="tool_fill">
                       <label class="icon_label" for="fill_color" title="Change fill color"></label>
                       <div class="color_block">
                          <div id="fill_bg"></div>
                          <div id="fill_color" class="color_block"></div>
                       </div>
                    </div>
                    <div class="opacity_holder">
                      <span class="label_opac">Fade</span>
                       <div class="special">
                          <div id="opac_slider"></div>
                       </div>
                    </div>
                    <div class="color_tool" id="tool_stroke">
                      <label class="stroke_label">
                        <span class="outline">Outline</span>
                      <input id="stroke_width" title="Change stroke width by 1, shift-click to change by 0.1" size="2" value="5" type="range" min="0" max="10" step="1" data-attr="Stroke Width"/>
                      </label>
                       <label class="icon_label" title="Change stroke color"></label>
                       <div class="color_block">
                          <div id="stroke_bg"></div>
                          <div id="stroke_color" class="color_block" title="Change stroke color"></div>
                       </div>

                       <div id="toggle_stroke_tools" title="Show/hide more stroke tools"></div>
                       <!-- <label class="stroke_tool">
                          <select id="stroke_style" title="Change stroke dash style">
                             <option selected="selected" value="none">&#8212;</option>
                             <option value="2,2">...</option>
                             <option value="5,5">- -</option>
                             <option value="5,2,2,2">- .</option>
                             <option value="5,2,2,2,2,2">- ..</option>
                          </select>
                       </label> -->
                    </div>
                 </div>
                 <div class="image_color">
                  <h1 class="side_title">Image/Logo</h1>
                  <label class="bright_label">
                        <span class="brightness">Brightness</span>
                      <input id="brightness1" title="Change stroke width by 1, shift-click to change by 0.1" size="2" value="5" type="range" min="0" max="10" step="1" data-attr="Stroke Width" disabled/>
                      <input class="bright"id="brightness" type="text" disabled>
                      </label>
                  <label class="cont_label">
                        <span class="contrast">Contrast</span>
                      <input id="contrast1" title="Change stroke width by 1, shift-click to change by 0.1" size="2" value="5" type="range" min="0" max="10" step="1" data-attr="Stroke Width" disabled/>
                     <input id="contrast" class="cont" type="text" disabled>
                      </label>
                  <label class="color1_label">
                        <span class="color">Color</span>
                      <input id="color1" title="Change stroke width by 1, shift-click to change by 0.1" size="2" value="5" type="range" min="0" max="10" step="1" data-attr="Stroke Width" disabled>
                      <input id="color" class="color_input" type="text" disabled>
                      </label>
                  <div class="checkbox">  
    <input id="check1" type="checkbox" name="check" value="check1" disabled>  
    <label for="check1" class="check1_label">Remove White Background</label>   
    <input id="check" type="range" name="check" value="check1" disabled>
</div>
                               <div class="checkbox">  
    <input id="check2" type="checkbox" name="check" value="check2" disabled>  
    <label for="check2" class="check2_label">Convert to Vector</label>   
    <input id="check_2" type="range" name="check" value="check" disabled>
</div>
                 </div>
                 <div class="settings">
                   <!-- <button id="download">hai</button> -->
                 <h1 class="side_title">Page Setting</h1>
                 <!-- <fieldset id="svg_docprops_docprops"> -->
                    <!-- <legend id="svginfo_image_props">Image Properties</legend> -->
                    <!-- <label>
                    <!-- <span id="svginfo_title">Title:</span>
                    <input type="text" id="canvas_title"/>
                    </label> -->
                    <!-- <fieldset id="change_resolution"> -->
                    <!-- <label class="size_drop">
                         <select id="resolution">
                            <option id="selectedPredefined" selected="selected">Select predefined:</option>
                            <!-- <option>640x480</option> -->
                            <!-- <option>200 x 100</option>
                            <option>300 x 150</option>
                            <option>290 x 180</option>
                            <option>400 x 200</option>
                            <option id="fitToContent" value="content">Fit to Content</option>
                         </select>
                      </label>  -->
                    <!-- <div class="document_size"> -->
                       <!-- <legend id="svginfo_dim">Canvas Dimensions</legend> -->
                       <div class="document_width">
                        <label class="doc_Width"><span id="svginfo_width">width:</span> <input type="text" id="canvas_width" size="3"/><span class="doc_unit1">mm</span></label>
                      </div>
                       <div class="document_heigth">
                         <label class="doc_height"><span id="svginfo_height">height:</span> <input type="text" id="canvas_height" size="3"/><span class="doc_unit1">mm</span></label>
                       </div>
                       <!-- <div class="doc_unit">mm x mm</div> -->

                     <!-- </div> -->
                    <!-- </fieldset> -->
                    <!-- <fieldset id="image_save_opts">
                       <legend id="includedImages">Included Images</legend>
                       <label><input type="radio" name="image_opt" value="embed" checked="checked"/> <span id="image_opt_embed">Embed data (local files)</span> </label>
                       <label><input type="radio" name="image_opt" value="ref"/> <span id="image_opt_ref">Use file reference</span> </label>
                    </fieldset> -->
                 <!-- </fieldset> -->
                 <div id="tool_docprops_back" class="toolbar_button">
                 <button id="tool_docprops_save">OK</button>
               </div>
         <div class="checkbox_holder">
               <div class="checkbox">  
    <input id="keep" type="checkbox" name="check" value="check1" disabled>  
    <label for="keep" class="check1_label">Keep Ratio</label>   
    <!-- <input id="keep" type="range" name="check" value="check1"> -->
</div>
<br/>
            <div class="checkbox">  
    <input id="background" type="checkbox" name="check" value="check2" disabled>  
    <label for="background" class="check2_label">Background</label>   
    <!-- <input id="background" type="range" name="check" value="check"> -->
</div>
         </div>
             </div>
              <!-- </div>
           </div> -->
<!--             <div id="rect_panel">
               <div class="toolset">
                  <label id="rect_width_tool" title="Change rectangle width">
                  <span id="rwidthLabel" class="icon_label"></span>
                  <input id="rect_width" class="attr_changer" size="3" data-attr="width"/>
                  </label>
                  <label id="rect_height_tool" title="Change rectangle height">
                  <span id="rheightLabel" class="icon_label"></span>
                  <input id="rect_height" class="attr_changer" size="3" data-attr="height"/>
                  </label>
               </div>
               <label id="cornerRadiusLabel" title="Change Rectangle Corner Radius" class="toolset">
               <span class="icon_label"></span>
               <input id="rect_rx" size="3" value="0" type="text" data-attr="Corner Radius"/>
               </label>
            </div> -->
<!--             <div id="image_panel">
               <h1 class="side_title">Image</h1>
               <div class="toolset">
                  <label><span id="iwidthLabel" class="icon_label"></span>
                  <input id="image_width" class="attr_changer" title="Change image width" size="3" data-attr="width"/>
                  </label>
                  <label><span id="iheightLabel" class="icon_label"></span>
                  <input id="image_height" class="attr_changer" title="Change image height" size="3" data-attr="height"/>
                  </label>
               </div> -->
  <!--              <div id="xy_panel" class="toolset">
                  <label>
                  x: <input id="selected_x" class="attr_changer" title="Change X coordinate" size="3" data-attr="x"/>
                  </label>
                  <label>
                  y: <input id="selected_y" class="attr_changer" title="Change Y coordinate" size="3" data-attr="y"/>
                  </label>
               </div> -->
               <!-- <div class="toolset">
                  <label id="tool_image_url">url:
                    <input id="image_url" type="text" title="Change URL" size="35"/>
                  </label>
                  <label id="tool_change_image">
                    <button id="change_image_url" style="display:none;">Change Image</button>
                    <span id="url_notice" title="NOTE: This image cannot be embedded. It will depend on this path to be displayed"></span>
                  </label>
                  </div> -->
           <!--  </div>
            <div id="circle_panel">
               <div class="toolset">
                  <label id="tool_circle_cx">cx:
                  <input id="circle_cx" class="attr_changer" title="Change circle's cx coordinate" size="3" data-attr="cx"/>
                  </label>
                  <label id="tool_circle_cy">cy:
                  <input id="circle_cy" class="attr_changer" title="Change circle's cy coordinate" size="3" data-attr="cy"/>
                  </label>
               </div>
               <div class="toolset">
                  <label id="tool_circle_r">r:
                  <input id="circle_r" class="attr_changer" title="Change circle's radius" size="3" data-attr="r"/>
                  </label>
               </div>
            </div>
            <div id="ellipse_panel">
               <div class="toolset">
                  <label id="tool_ellipse_cx">cx:
                  <input id="ellipse_cx" class="attr_changer" title="Change ellipse's cx coordinate" size="3" data-attr="cx"/>
                  </label>
                  <label id="tool_ellipse_cy">cy:
                  <input id="ellipse_cy" class="attr_changer" title="Change ellipse's cy coordinate" size="3" data-attr="cy"/>
                  </label>
               </div>
               <div class="toolset">
                  <label id="tool_ellipse_rx">rx:
                  <input id="ellipse_rx" class="attr_changer" title="Change ellipse's x radius" size="3" data-attr="rx"/>
                  </label>
                  <label id="tool_ellipse_ry">ry:
                  <input id="ellipse_ry" class="attr_changer" title="Change ellipse's y radius" size="3" data-attr="ry"/>
                  </label>
               </div>
            </div>
            <div id="line_panel">
               <div class="toolset">
                  <label id="tool_line_x1">x1:
                  <input id="line_x1" class="attr_changer" title="Change line's starting x coordinate" size="3" data-attr="x1"/>
                  </label>
                  <label id="tool_line_y1">y1:
                  <input id="line_y1" class="attr_changer" title="Change line's starting y coordinate" size="3" data-attr="y1"/>
                  </label>
               </div>
               <div class="toolset">
                  <label id="tool_line_x2">x2:
                  <input id="line_x2" class="attr_changer" title="Change line's ending x coordinate" size="3" data-attr="x2"/>
                  </label>
                  <label id="tool_line_y2">y2:
                  <input id="line_y2" class="attr_changer" title="Change line's ending y coordinate" size="3" data-attr="y2"/>
                  </label>
               </div>
            </div> -->
<!-- text poanel -->
            <!-- <div class="color_tool" id="tool_opacity" title="Change selected item opacity"> -->
            <!-- <label>
               <span id="group_opacityLabel" class="icon_label"></span>
               <input id="group_opacity" size="3" value="100" type="text"/>
               </label> -->
            <!-- <div id="opacity_dropdown" class="dropdown">
               <button></button>
               <ul> -->
            <!-- <li>0%</li>
               <li>25%</li>
               <li>50%</li>
               <li>75%</li>
               <li>100%</li> -->


                  <!-- <div class="blur_holder">
                     <img class="blur_left" src="images/stare.png"/>
                     <div class="special">
                        <div id="blur_slider"></div>
                     </div>
                     <img class="blur_right" src="images/stare.png"/>
                  </div> -->

            <!-- </ul> -->
            <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="toolset" id="tool_blur" title="Change gaussian blur value">
               <label>
                 <span id="blurLabel" class="icon_label"></span>
                 <input id="blur" size="2" value="0" type="text"/>
               </label>
               <div id="blur_dropdown" class="dropdown">
                 <button></button>
                 <ul> -->
            <!-- </ul> -->
            <!-- </div>
               </div> -->
            <!-- color section -->

            <!-- color end -->
            <!-- outline section -->



            <!-- outline end -->
            <!-- <div class="tool_button" id="tool_select" title="Select Tool"></div> -->
            <!-- <div class="tool_button" id="tool_fhpath" title="Pencil Tool"></div> -->
            <div class="tool_button" id="tool_line" title="Line Tool"></div>
            <!-- <div class="tool_button flyout_current" id="tools_rect_show" title="Square/Rect Tool">
               <div class="flyout_arrow_horiz"></div>
               </div>
               <div class="tool_button flyout_current" id="tools_ellipse_show" title="Ellipse/Circle Tool">
               <div class="flyout_arrow_horiz"></div>
               </div>-->
            <!-- <div class="tool_button" id="tool_path" title="Path Tool"></div> -->
            <!-- <div class="tool_button" id="tool_text" title="Text Tool"></div> -->
            <!-- <div class="tool_button" id="tool_image" title="Image Tool"></div>
               <div class="tool_button" id="tool_zoom" title="Zoom Tool [Ctrl+Up/Down]"></div> -->
            <div style="display: none">
               <div id="tool_rect" title="Rectangle"></div>
               <div id="tool_square" title="Square"></div>
               <div id="tool_fhrect" title="Free-Hand Rectangle"></div>
               <div id="tool_ellipse" title="Ellipse"></div>
               <div id="tool_circle" title="Circle"></div>
               <div id="tool_fhellipse" title="Free-Hand Ellipse"></div>
            </div>

    <div id="svg_prefs_container">
      <!-- <h1 class="side_title">Background</h1> -->

            <fieldset>
               <!-- <legend id="svginfo_editor_prefs">Editor Preferences</legend> -->
         <!--       <label>
                  <span id="svginfo_lang">Language:</span>
                   Source: http://en.wikipedia.org/wiki/Language_names -->
    <!--               <select id="lang_select">
                     <option id="lang_ar" value="ar">العربية</option>
                     <option id="lang_cs" value="cs">Čeština</option>
                     <option id="lang_de" value="de">Deutsch</option>
                     <option id="lang_en" value="en" selected="selected">English</option>
                     <option id="lang_es" value="es">Español</option>
                     <option id="lang_fa" value="fa">فارسی</option>
                     <option id="lang_fr" value="fr">Français</option>
                     <option id="lang_fy" value="fy">Frysk</option>
                     <option id="lang_hi" value="hi">&#2361;&#2367;&#2344;&#2381;&#2342;&#2368;, &#2361;&#2367;&#2306;&#2342;&#2368;</option>
                     <option id="lang_it" value="it">Italiano</option>
                     <option id="lang_ja" value="ja">日本語</option>
                     <option id="lang_nl" value="nl">Nederlands</option>
                     <option id="lang_pl" value="pl">Polski</option>
                     <option id="lang_pt-BR" value="pt-BR">Português (BR)</option>
                     <option id="lang_ro" value="ro">Română</option>
                     <option id="lang_ru" value="ru">Русский</option>
                     <option id="lang_sk" value="sk">Slovenčina</option>
                     <option id="lang_zh-TW" value="zh-TW">繁體中文</option>
                  </select> -->
              <!--  </label>  -->
<!--                <label>
                  <span id="svginfo_icons">Icon size:</span>
                  <select id="iconsize">
                     <option id="icon_small" value="s">Small</option>
                     <option id="icon_medium" value="m" selected="selected">Medium</option>
                     <option id="icon_large" value="l">Large</option>
                     <option id="icon_xlarge" value="xl">Extra Large</option>
                  </select>
               </label> -->
               <fieldset id="change_background">
                  <legend id="svginfo_change_background"></legend>
                  <div id="bg_blocks"></div>


               		<script type="text/javascript">
	                    $(document).ready(function()
	                    {
	                     	$( "#canvas_bg_url1" ).change(function() 
	                     	{
	                          var file_data = $("#canvas_bg_url1").prop("files")[0];
	                          // alert('file_data');
	                          var form_data = new FormData();
	                          form_data.append("file", file_data);

	                          $.ajax({
	                                    url: "http://192.169.197.129/dev/premiumprint/print/ajax_upload.php",
	                                    dataType: "text",
	                                    cache: false,
	                                    contentType: false,
	                                    processData: false,
	                                    data: form_data,
	                                    type: "POST",
	                                    success: function(data)
	                                    {
	                                        console.log(data);
	                                    }
	            					});
	      					 });
	                  	});
                	</script>

                  	<label>
	                    <span id="svginfo_bg_url"></span>
	                    <input type="text" id="canvas_bg_url"/>
	                    <input class="custom-file-input" type="file" id="canvas_bg_url1"/>
                    </label>


                  <!-- <p id="svginfo_bg_note">Note: Background will not be saved with image.</p> -->
               </fieldset>
      			<!--<fieldset id="change_grid">
                  <legend id="svginfo_grid_settings">Grid</legend>
                  <label><span id="svginfo_snap_onoff">Snapping on/off</span><input type="checkbox" value="snapping_on" id="grid_snapping_on"/></label>
                  <label><span id="svginfo_snap_step">Snapping Step-Size:</span> <input type="text" id="grid_snapping_step" size="3" value="10"/></label>
                  <label><span id="svginfo_grid_color">Grid color:</span> <input type="text" id="grid_color" size="3" value="#000"/></label>
               </fieldset> -->
               <fieldset id="units_rulers">
                  <legend id="svginfo_units_rulers">Units &amp; Rulers</legend>
                  <label><span id="svginfo_rulers_onoff">Show rulers</span><input type="checkbox" value="show_rulers" id="show_rulers" checked="checked"/></label>
                  	<label>
                    	<span id="svginfo_unit">Base Unit:</span>
	                    <select id="base_unit">
	                        <option value="px">Pixels</option>
	                        <option value="cm">Centimeters</option>
	                        <option value="mm">Millimeters</option>
	                        <option value="in">Inches</option>
	                        <option value="pt">Points</option>
	                        <option value="pc">Picas</option>
	                        <option value="em">Ems</option>
	                        <option value="ex">Exs</option>
	                    </select>
                  	</label>
                  </fieldset>
                  <!-- Should this be an export option instead? -->
                  <!--
                     <span id="svginfo_unit_system">Unit System:</span>
                     <label>
                        <input type="radio" name="unit_system" value="single" checked="checked"/>
                        <span id="svginfo_single_type_unit">Single type unit</span>
                        <small id="svginfo_single_type_unit_sub">CSS unit type is set on root element. If a different unit type is entered in a text field, it is converted back to user units on export.</small>
                     </label>
                     <label>
                        <input type="radio" name="unit_system" value="multi"/>
                        <span id="svginfo_multi_units">Multiple CSS units</span>
                        <small id="svginfo_single_type_unit_sub">Attributes can be given different CSS units, which may lead to inconsistant results among viewers.</small>
                     </label>
                     -->

            </fieldset>
                        <div id="tool_prefs_back" class="toolbar_button">
               <button id="tool_prefs_save">OK</button>
               <!-- <button id="tool_prefs_cancel">Cancel</button> -->
            </div>
         </div>

		<!-- <input type="file" onchange="previewFile()"><br>
		<img src="" height="200" alt="Image preview..."> -->

         </div>
         <!-- tools_left -->
         <!-- <div id="tools_bottom" class="tools_panel"> -->
         <!-- Zoom buttons -->
         <!-- <div id="zoom_panel" class="toolset" title="Change zoom level">
            <label>
            <span id="zoomLabel" class="zoom_tool icon_label"></span>
            <input id="zoom" size="3" value="100" type="text" />
            </label>
            <div id="zoom_dropdown" class="dropdown">
            	<button></button>
            	<ul>
            		<li>1000%</li>
            		<li>400%</li>
            		<li>200%</li>
            		<li>100%</li>
            		<li>50%</li>
            		<li>25%</li>
            		<li id="fit_to_canvas" data-val="canvas">Fit to canvas</li>
            		<li id="fit_to_sel" data-val="selection">Fit to selection</li>
            		<li id="fit_to_layer_content" data-val="layer">Fit to layer content</li>
            		<li id="fit_to_all" data-val="content">Fit to all content</li>
            		<li>100%</li>
            	</ul>
            </div>
            <div class="tool_sep"></div>
            </div> -->
         <!-- <div id="tools_bottom_2">
            </div> -->
         <!-- <div id="tools_bottom_3"> -->
         <!-- <div id="palette_holder"><div id="palette" title="Click to change fill color, shift-click to change stroke color"></div></div> -->
         <!-- </div> -->
         <!-- <div id="copyright"><span id="copyrightLabel">Powered by</span> <a href="http://svg-edit.googlecode.com/" target="_blank">SVG-edit v2.6-beta</a></div> -->
         <!-- </div> -->
         <!-- <div id="option_lists" class="dropdown">
            <ul id="linejoin_opts">
            	<li class="tool_button current" id="linejoin_miter" title="Linejoin: Miter"></li>
            	<li class="tool_button" id="linejoin_round" title="Linejoin: Round"></li>
            	<li class="tool_button" id="linejoin_bevel" title="Linejoin: Bevel"></li>
            </ul>

            <ul id="linecap_opts">
            	<li class="tool_button current" id="linecap_butt" title="Linecap: Butt"></li>
            	<li class="tool_button" id="linecap_square" title="Linecap: Square"></li>
            	<li class="tool_button" id="linecap_round" title="Linecap: Round"></li>
            </ul>

            <ul id="position_opts" class="optcols3">
            	<li class="push_button" id="tool_posleft" title="Align Left"></li>
            	<li class="push_button" id="tool_poscenter" title="Align Center"></li>
            	<li class="push_button" id="tool_posright" title="Align Right"></li>
            	<li class="push_button" id="tool_postop" title="Align Top"></li>
            	<li class="push_button" id="tool_posmiddle" title="Align Middle"></li>
            	<li class="push_button" id="tool_posbottom" title="Align Bottom"></li>
            </ul>
            </div> -->
         <!-- hidden divs -->
         <div id="color_picker"></div>

      </div>
      <!-- svg_editor -->
    <div id="svg_source_editor">
         <div class="overlay"></div>
        <div id="svg_source_container">
            <div id="tool_source_back" class="toolbar_button">
               <button id="tool_source_save">Apply Changes</button>
               <button id="tool_source_cancel">Cancel</button>
            </div>
            <div id="save_output_btns">
               <p id="copy_save_note">Copy the contents of this box into a text editor, then save the file with a .svg extension.</p>
               <button id="copy_save_done">Done</button>
            </div>
            <form>
               <textarea id="svg_source_textarea" spellcheck="false"></textarea>
            </form>
    	</div>
    </div>
      <div id="svg_docprops">
         <div class="overlay"></div>
         <div id="svg_docprops_container">
            <div id="tool_docprops_back" class="toolbar_button">
               <button id="tool_docprops_save">OK</button>
               <button id="tool_docprops_cancel">Cancel</button>
            </div>
            <fieldset id="svg_docprops_docprops">
               <legend id="svginfo_image_props">Image Properties</legend>
               <label>
               <span id="svginfo_title">Title:</span>
               <input type="text" id="canvas_title"/>
               </label>
               <fieldset id="change_resolution">
                  <legend id="svginfo_dim">Canvas Dimensions</legend>
                  <label><span id="svginfo_width">width:</span> <input type="text" id="canvas_width" size="6"/></label>
                  <label><span id="svginfo_height">height:</span> <input type="text" id="canvas_height" size="6"/></label>
                  <label>
                     <select id="resolution">
                        <option id="selectedPredefined" selected="selected">Select predefined:</option>
                        <option>640x480</option>
                        <option>800x600</option>
                        <option>1024x768</option>
                        <option>1280x960</option>
                        <option>1600x1200</option>
                        <option id="fitToContent" value="content">Fit to Content</option>
                     </select>
                  </label>
               </fieldset>
               <fieldset id="image_save_opts">
                  <legend id="includedImages">Included Images</legend>
                  <label><input type="radio" name="image_opt" value="embed" checked="checked"/> <span id="image_opt_embed">Embed data (local files)</span> </label>
                  <label><input type="radio" name="image_opt" value="ref"/> <span id="image_opt_ref">Use file reference</span> </label>
               </fieldset>
            </fieldset>
         </div>
      </div>
		<!--        <div id="svg_prefs">
        				 <div class="overlay"></div>
      				</div> -->
      <div id="dialog_box">
         <div class="overlay"></div>
         <div id="dialog_container">
            <div id="dialog_content"></div>
            <div id="dialog_buttons"></div>
         </div>
      </div>
		<div id="loginScreen">
            <a href="#" class="cancel">&times;</a>        
            <h2 class="artwork_title">Your Artworks</h2>
            <?php
		        $idcus = $_GET['idcus'];
		        $_SESSION['idcus'] = $idcus;
		        $prod_id = $_GET['id_prod'];
		        $temp_path=$_GET['temp_path'];
		        $im_path=$_GET['image_id'];
		        $con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
	            mysqli_select_db($con,"clorida1_premiumprint");
	            $gettemplate=mysqli_query($con,"SELECT * FROM xmr_fabric_Tempcustomer_design where customer_id='".$idcus."'");
	            define('DIR_PATH','../modules/premiumprint_fo/controllers/front/');
	                while($gettemplates=mysqli_fetch_array($gettemplate))
	                {
	                        $image_name=$gettemplates['image_name'];

	                        $cus_id=$gettemplates['customer_id'];
	                        ?>
	                        <a id="template" href="http:../print/svg-editor.php?idcus=<?= $cus_id ?>&id_prod=<?= $prod_id ?>&idtemp=<?=$image_name?>&temp_path=youraccount" target="_BLANK">
	                        <img src="<?=DIR_PATH.$cus_id.'/'.$image_name?>" background="#a8a8a8" width="100" heigth="50" style="float:left"></a>
	                      <!--  <div class="shapes"><a href="'.DIR_PATH.''.$cus_id.'/'.$image_name.'">
	                       <img src="'.DIR_PATH.''.$cus_id.'/'.$image_name.'" background="#a8a8a8" width="100" heigth="50" style="float:left"></a></div> -->
	                       <?php
	                }
            ?>
        </div>         
        <div id="cover" > </div>
 		<div id="help">
        	<a href="#" class="cancel">&times;</a>
            <div class="player_holder">
				<video width="640" controls>
  					<source src="video/small.mp4" type="video/mp4">
  					<source src="video/small.ogg" type="video/ogg">
  					Your browser does not support HTML5 video.
				</video>
			</div>
        </div>
        <div id="cover" > </div>
      <ul id="cmenu_canvas" class="contextMenu">
         <li><a href="#cut">Cut</a></li>
         <li><a href="#copy">Copy</a></li>
         <li><a href="#paste">Paste</a></li>
         <li><a href="#paste_in_place">Paste in Place</a></li>
         <li class="separator"><a href="#delete">Delete</a></li>
         <li class="separator"><a href="#group">Group<span class="shortcut">G</span></a></li>
         <li><a href="#ungroup">Ungroup<span class="shortcut">G</span></a></li>
         <li class="separator"><a href="#move_front">Bring to Front<span class="shortcut">SHFT+CTRL+]</span></a></li>
         <li><a href="#move_up">Bring Forward<span class="shortcut">CTRL+]</span></a></li>
         <li><a href="#move_down">Send Backward<span class="shortcut">CTRL+[</span></a></li>
         <li><a href="#move_back">Send to Back<span class="shortcut">SHFT+CTRL+[</span></a></li>
      </ul>
      	<ul id="cmenu_layers" class="contextMenu">
         <li><a href="#dupe">Duplicate Layer...</a></li>
         <li><a href="#delete">Delete Layer</a></li>
         <li><a href="#merge_down">Merge Down</a></li>
         <li><a href="#merge_all">Merge All</a></li>
     	</ul>
    <script type="text/javascript">
        $(p).click(function()
        {
        	$("#background_image").error(function () 
        	{
    			$(this).hide();
			});
		});
	</script>
</body>
</html>
	<?php
		
		$idcus = $_GET['idcus'];
		$prod_id = $_GET['id_prod'];
		$temp_path=$_GET['temp_path'];
		$im_path=$_GET['image_id'];
		$con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
		if (!$con)
		{
		    die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"clorida1_premiumprint");
		$get_temp=mysqli_query($con,"SELECT * from xmr_fabric_Tempcustomer_design where
		        customer_id='".$idcus."' and product_id='".$prod_id."' ");
		      	while($gettemp=mysqli_fetch_array($get_temp))
		      	{
		             $image_id=$gettemp['image_id'];
		      	}
		?>
		<!--Script to Save Art Work Automatically for Every 10 Seconds-->
<script>
   window.setInterval(function(){
      var svg = $("#svgroot").html();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: 'http://192.169.197.129/dev/premiumprint/print/svg-editor.php',
         data: 'svg='+svg+
         '&idcus=<?php echo $idcus; ?>'+
         '&prod_id=<?php echo $prod_id; ?>'+
         '&temp_path=<?php echo $temp_path; ?>'+
         '&im_path=<?php echo $im_path; ?>'
      });
}, 10000);
   $(".save_draft").click(function(){
      var svg = $("#svgroot").html();
      alert("File <?php echo $idcus.'_'.$prod_id.'_'.$im_path.''?>saved")
      $.ajax({
         type: "POST",
         dataType: "json",
         url: 'http://192.169.197.129/dev/premiumprint/print/svg-editor.php',
         data: 'svg='+svg+
         '&idcus=<?php echo $idcus; ?>'+
         '&prod_id=<?php echo $prod_id; ?>'+
          '&temp_path=<?php echo $temp_path; ?>'+
           '&im_path=<?php echo $im_path; ?>'     
      });
   });
   $(window).load(function()
   {
   $(location).attr('href');

    
    var pathname = window.location.search;
    var pathname = "<?php echo $cus_id=$_GET['idcus'];?>";
    var path1="<?php echo $prod_id=$_GET['id_prod'];?>";
    var path2="<?php echo $temp_id=$_GET['idtemp'];?>";
    var path3="<?php echo $temp_path=$_GET['temp_path'];?>"
   if(path3=="youraccount")
     {
      
     svgEditor.loadFromURL("http://192.169.197.129/dev/premiumprint/modules/premiumprint_fo/controllers/front/"+pathname+'/'+path2);
     }
     else
     {
      svgEditor.loadFromURL("http://192.169.197.129/dev/premiumprint/modules/premiumprint_bo/controllers/admin/templates/"+path1+'/'+path2);
     }
});
</script>
	<?php
$con = mysqli_connect('localhost','clorida1_premium','GD6W=(5@iIc1','clorida1_premiumprint');
if (!$con) {
     die('Could not connect: ' . mysqli_error($con));
   }

mysqli_select_db($con,"clorida1_premiumprint");
$cus_id=$_GET['idcus'];
$idprod=$_GET['id_prod'];
$temp_path=$_GET['temp_path'];
$im_path=$_GET['image_id'];
if(!is_dir($_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/'.$cus_id))
{
     mkdir($_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/'.$cus_id);   
}

if(isset($_POST['svg']))
	{
		        $svg = $_POST['svg'];
		        $prod_id = $_POST['prod_id'];
		        $idcus = $_POST['idcus'];
		        $temp_path1=$_POST['temp_path'];
		        $im_id=$_POST['im_path'];
		        $svg = strstr($svg, '<svg xmlns="');
		        $svg = substr($svg, 0, strpos($svg, '<g id="selectorParentGroup"'));
		        $cus_dir = $_POST['cus'];
		        //mkdir($_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/a');
		        define('DIR_PATH',$_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/');
				
		        if($im_id!="")
		        {
					//mkdir($im_id);
		        	$get_temp=mysqli_query($con,"SELECT * from xmr_fabric_Tempcustomer_design where
		        	customer_id='".$idcus."' and product_id='".$prod_id."' and image_id='".$im_id."' ");
			        while($gettemp=mysqli_fetch_array($get_temp))
			        {
			            echo $customer_id=$gettemp['customer_id'];
			             $product_id=$gettemp['product_id'];
			             $im1_id=$gettemp['image_id'];
			             $image_name=$gettemp['image_name'];
			        }
					$svg_name=$idcus.'_'.$prod_id.'_'.$im1_id.'.svg';
			        $write_file = DIR_PATH.$idcus.'/'.$svg_name;
			        $file = fopen($write_file, 'w');
			        fwrite($file, $svg);
			        fclose($file);
		    	}
				else
		   		{
		           $get_temp=mysqli_query($con,"SELECT * from xmr_fabric_Tempcustomer_design where
		            customer_id='".$idcus."' and product_id='".$prod_id."' order by image_id desc limit 1");
		            while($gettemp=mysqli_fetch_array($get_temp))
		            {
		                $customer_id=$gettemp['customer_id'];
		                $product_id=$gettemp['product_id'];
		                echo $im1_id=$gettemp['image_id'];
		                $image_name=$gettemp['image_name'];
		            }
		                  //$im1_id=$im1_id+1;
		                  echo $svg_name=$idcus.'_'.$prod_id.'_'.$im1_id.'.svg';
		                  $write_file = DIR_PATH.$idcus.'/'.$svg_name;
		                  $file = fopen($write_file, 'w');
		                  fwrite($file, $svg);
		                  fclose($file);
		        }
        
    }
   $tempp_path=$_GET['temp_path'];
         		  	if(($tempp_path!="youraccount")&&(!$_POST['svg']))
         		   		{
							echo "test";
         			        $get_temp=mysqli_query($con,"SELECT * from xmr_fabric_Tempcustomer_design where
         			        customer_id='".$idcus."' and product_id='".$prod_id."' ");
         			        //mkdir($_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/c');
         			      	while($gettemp=mysqli_fetch_array($get_temp))
         			      	{
         			      		 $customer_id=$gettemp['customer_id'];
         			      		 $product_id=$gettemp['product_id'];
         			             $image_id=$gettemp['image_id'];
         			      	}
         			      	if ($image_id=="")
         			      	{
         			      		$image_id=0;
         			      	}
         			            $image_id=$image_id+1;
         			            $svg_name=$idcus.'_'.$prod_id.'_'.$image_id.'.svg';
         			            define('DIR_PATH',$_SERVER['DOCUMENT_ROOT'].'dev/premiumprint/modules/premiumprint_fo/controllers/front/');
         			            $write_file = DIR_PATH.$idcus.'/'.$svg_name;
         			            $write_file;
         			            $file = fopen($write_file, 'w+');
         			            //$file=fopen($write_file,'w');
         			            fwrite($file, $svg);
         			            fclose($file);
         			            $ins="INSERT into xmr_fabric_Tempcustomer_design values
         			            ('','".$idcus."','".$prod_id."','".$svg_name."','".$image_id."')";
         			            mysqli_query($con,$ins);
         		    	}
    
?>
 
