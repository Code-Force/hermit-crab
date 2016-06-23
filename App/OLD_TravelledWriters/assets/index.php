<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>imgSelect - Upload/Webcam Snapshot & Crop</title>
	
	<!-- Assets -->
	<link rel="stylesheet" href="assets/bootstrap.css">
	<link rel="stylesheet" href="assets/imgSelect.css">
	<script src="assets/jquery.js"></script>
	<script src="assets/imgSelect.js"></script>

</head>
<body>
	<div class="container">
		<img src="assets/pic.jpg" width="80" height="80" class="img">
		<h3>imgSelect - Upload/Webcam Snapshot & Crop</h3>

		<!-- Upload/Webcam buttons -->
        <button type="button" class="btn btn-info btn-small ajaxupload">Upload</button>
        <button type="button" class="btn btn-success btn-small" onclick="imgSelect.webcam()">Webcam</button>
      	
      	<!-- imgSelect container -->
        <div class="imgSelect-container">
            <div class="imgSelect-upload"></div>
            <div class="imgSelect-webcam">
				<div class="crop"></div>
                <div class="preview"></div>
            </div>

            <input type="hidden" id="x1">
            <input type="hidden" id="y1">
            <input type="hidden" id="w">
            <input type="hidden" id="h">
			
			<div class="imgSelect-actions">
				<button type="button" class="btn btn-primary btn-small save" onclick="imgSelect.save()">Save Image</button>
				<button type="button" class="btn btn-primary btn-small new-snap" onclick="imgSelect.webcam()">New Snapshot</button>
				<button type="button" class="btn btn-primary btn-small capture" onClick="imgSelect.webcamSnap()">Capture</button>
				<button type="button" class="btn btn-default btn-small" onClick="imgSelect.cancel()">Cancel</button>
			</div>
        </div>
		<div class="imgSelect-alert alert"></div>

	</div>
	<!-- Some style for demo page -->
	<style>
		body {background: #F3F3F3;}
		img.img {float: right; padding: 3px; border: 1px solid #ddd;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
		.container {
			width: 700px;
			min-height: 300px;
			margin: 2em auto;
			padding: 1.5em;
			background: #fff;
			border: 1px solid #D8D8D8;
			-webkit-border-radius: 6px;
			-moz-border-radius: 6px;
			border-radius: 6px;
			-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
			-moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
			box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
		}
	</style>
</body>
</html>