<?php

if(isset($_POST['upload'])){
	
	echo json_encode($_FILES);	
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Form Inputs</title>
		<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?skin=sunburst"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="iframeUploader.js"></script>
		<style>
			pre { padding: 15px; display: block;  }
		</style>
		<style>
	body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 150%; }
	.file-container { padding: 2px 10px; margin-bottom: 1px; }
	.file-container .file-input { }
	.file-container .file-add { cursor: pointer; color: green; width: 200px; background: green; color: white;  padding: 3px 0; text-align: center; }
	.file-container .file-add:hover { background: #7ABA7B; }
	.file-container .file-name { font-weight: bold; font-size: 15px; }
	.file-container .file-remove { display: none; cursor: pointer; margin-right: 10px; color: red; border: 1px solid red; padding: 2px; text-align: center; }
	.file-container .file-remove:hover{ background: red; color: white; } 
				
		</style>
		<script>	
			var myUploader;
			var response = function(data){
				$('#output').html(JSON.stringify(data));
			}
			$(function(){
				myUploader = new IFrameUploadList('upload-container', "files", "<?php echo $_SERVER['PHP_SELF']; ?>", response);
			});
			

			
		</script>
	</head>

	<body>
		<div>
			<header>
				<h1>iFrame Upload (ajax like) </h1>
			</header>
			
			<div id="upload-container" style="border: 5px solid #ccc; padding: 15px;">
				
			</div>
			<div>
				<input  type="button" value="Upload"  onclick="myUploader.submit()" />  
			</div>
			<fieldset style="margin:10px 0">
				<legend>Server Response</legend>
				<div id="output" style="padding: 10px;">
					
				</div>	
			</fieldset>
			
<pre class="prettyprint"> // create a new upload object
<span class="nocode" style="color: white">&lt;script&gt;</span>
	var myUploader;
	var response = function(data){
		$('#output').html(JSON.stringify(data));
	}
	$(function(){
		myUploader = new IFrameUploadList('upload-container', "files", "YOURURL.php", response);
	});

<span class="nocode" style="color: white">&lt;/script&gt;</span></pre>

<pre class="prettyprint" style="color: #fff;">&lt;div id=&quot;upload-container&quot;&gt; &lt;/div&gt;
&lt;input  type=&quot;button&quot; value=&quot;Upload&quot;  onclick=&quot;myUploader.submit()&quot; /&gt; 

&lt;div id=&quot;output&quot; &gt; &lt;/div&gt;
</pre>
		
			<h3>Params <small> - Construct(containerId, fileName, uploadUrl, callback);</small></h3>
			<ul class="prm">
				<li><label>containerId:</label> The ID of a div or similar container to hold the file list.</li>
				<li><label>fileName:</label> The name for the file array, adds the "name[]" to input in form.</li>
				<li><label>uploadUrl:</label> The url to the upload page.</li>
				<li><label>callback:</label> The function to fire with the data from the iframe, server response</li>
			</ul>
			<h3>Methods <small></small></h3>
			<ul class="prm">
				<li><label>submit():</label> Submits the form to server.</li>
			</ul>						
			<h3>Requirements</h3>
			<ul>
				<li>jQuery latest version</li>
				<li>Server to receive Post data</li>
			</ul>
			<h3>Demo Environment</h3>
			<ul>
				<li>PHP</li>
				<li>jQuery</li>
			</ul>		
			<h3>Quick Explanation</h3>
			<p>How to send a file via iframe.</p>
			
			<h2>SOURCE</h2>
			<h3>CSS</h3>
<pre class="prettyprint">.file-container  { font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 150%; }
.file-container { padding: 2px 10px; margin-bottom: 1px; }
.file-container .file-input { }
.file-container .file-add { cursor: pointer; color: green; width: 200px; background: green; color: white;  padding: 3px 0; text-align: center; }
.file-container .file-add:hover { background: #7ABA7B; }
.file-container .file-name { font-weight: bold; font-size: 15px; }
.file-container .file-remove { display: none; cursor: pointer; margin-right: 10px; color: red; border: 1px solid red; padding: 2px; text-align: center; }
.file-container .file-remove:hover{ background: red; color: white; } 
</pre>			
			<h3>JavaScript</h3>
<pre class="prettyprint">var IFrameUploadList = function(containerId, fileName, uploadUrl, callback){
	var self = this;
	var isIE = (navigator.appName == 'Microsoft Internet Explorer');
	var uc = $('#'+containerId);
	var inputName = fileName + "[]";
	var frameName = new Date().getTime()+"_"+new Date().getDate()+"_frame";	
	function xele(type,attrs){
		var ele = document.createElement(type);	$.each(attrs, function(i, item){ ele.setAttribute(i,item); }); return ele;
	}	
	var frame = $(xele('iframe',{ name: frameName, src: "about:blank", style: 'display: none'})); 
	frame.appendTo('body');
	var inp = $(xele('input',{ type: "text", name: "upload" }));
	var form = $(xele('form', {style: 'display: none', method: "POST", action: uploadUrl,'accept-charset':"UTF-8", target: frameName, enctype:"multipart/form-data" }));
	form.append(inp); form.appendTo('body');
	var addNewUpload = function(){
		uc.append(uploadInput());
	}
	this.callback = callback;
	frame.bind('load',function(){
		self.callback(JSON.parse($($(this).contents()[0]).find('body').html()));
	});
	var uploadInput = function(){
		var cont = $(xele('div',  { 'class':'file-container' }));
		var inp = $(xele('input', { type: "file", 'class': 'file-input', name: inputName }));
		var add = $(xele('div',   { 'class': 'file-add' })); add.html('add');
		var nm = $(xele('span',   { 'class': 'file-name' }));
		var rmv = $(xele('span',  { 'class': 'file-remove' })); rmv.html('remove');
		isIE ? add.hide():inp.hide();
		$(add).click(function(){
			inp.click();
		});
		$(rmv).click(function(){
			cont.remove();
		});
		inp.change(function(e){
			var name = $(this).val().split('\\');
			nm.html(name[name.length - 1]);
			add.hide(); inp.hide(); rmv.show();
			$(this).blur(); addNewUpload();
			$(this).appendTo(form);
		});
		cont.append(inp).append(add).append(rmv).append(nm);
		return cont;
	}
	addNewUpload();
	this.submit = function(callback){
		form.submit();
	}
}</pre>
			<footer style="color: #ccc; margin-top: 55px; border-top: 1px solid #ccc;">
				<p>eligeske</p>
			</footer>
		</div>
	</body>
</html>

