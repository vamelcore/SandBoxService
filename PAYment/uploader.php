<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<?php session_start(); if (isset($_SESSION['xls_data_array'])) {unset($_SESSION['xls_data_array']);} if (isset($_SESSION['diler_array'])) {unset($_SESSION['diler_array']);}?>
<title>Загрузка файла</title>

<link rel="stylesheet" href="../style.css" />

<link rel="stylesheet" href="js/jquery.ui.plupload/css/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<script type="text/javascript" src="js/jquery.ui.plupload/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.plupload/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plupload.full.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
  
<script type="text/javascript" src="js/i18n/ru.js"></script>

</head>
<body>

<div align="center">

<form id="form" method="post" action="dump.php">
  <div id="uploader" align="left" style="width:800px;">
    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
  </div>
  <br />
  <input type="button" onClick="top.location.href='../PAYment.php'" value="<- Назад" style="width:160px; height:25px; font-size:14px;"/>
  <input type="submit" value="Продолжить ->" style="width:160px; height:25px; font-size:14px;"/>
</form>

<script type="text/javascript">
// Initialize the widget when the DOM is ready
$(function() {
  $("#uploader").plupload({
    // General settings
    runtimes : 'html5,flash,silverlight,html4',
    url : 'upload.php',

    // User can upload no more then 20 files in one go (sets multiple_queues to false)
    max_file_count: 1,
    
    chunk_size: '1mb',

    // Resize images on clientside if we can
    resize : {
      width : 200, 
      height : 200, 
      quality : 90,
      crop: true // crop to exact dimensions
    },
    
    filters : {
      // Maximum file size
      max_file_size : '10mb',
      // Specify what files to browse for
      mime_types: [
//        {title : "Image files", extensions : "jpg,gif,png"},
//        {title : "Zip files", extensions : "zip"},
//		{title : "Exel files", extensions : "ods"},
		{title : "Exel files", extensions : "xls,xlsx"}
      ]
    },

    // Rename files by clicking on their titles
    rename: true,
    
    // Sort files
    sortable: true,

    // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
    dragdrop: true,
	
	//multiple_queues: true,

    // Views to activate
    views: {
      list: true,
      thumbs: true, // Show thumbs
      active: 'thumbs'
    },

    // Flash settings
    flash_swf_url : 'js/Moxie.swf',

    // Silverlight settings
    silverlight_xap_url : 'js/Moxie.xap'
  });


  // Handle the case when form was submitted before uploading has finished
  $('#form').submit(function(e) {
    // Files in queue upload them first
    if ($('#uploader').plupload('getFiles').length > 0) {

      // When all files are uploaded submit form
      $('#uploader').on('complete', function() {
        $('#form')[0].submit();
      });

      $('#uploader').plupload('start');
    } else {
      alert("Не загружено ни одного файла!");
    }
    return false; // Keep the form from submitting
  });
    
});
</script>

</div>
</body>
</html>
