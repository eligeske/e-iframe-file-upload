var IFrameUploadList = function(containerId, fileName, uploadUrl, callback){
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
}