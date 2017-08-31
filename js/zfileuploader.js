/**
 * Кастомизация для ZOON http://github.com/Valums-File-Uploader/file-uploader
 */

/**
 * Class that creates upload widget with drag-and-drop and file list
 * @inherits qq.FileUploader
 */
qq.ZFileUploader = function(o){

	var customOptions = {
		template: '<div class="qq-uploader">' +
			'<div class="qq-upload-drop-area"><span>Чтобы загрузить перетащите файлы сюда</span></div>' +
			'<div class="qq-upload-button button button-purple">Загрузить</div>' +
			'<ul class="qq-upload-list"></ul>' +
			'</div>',
		messages: {
			typeError: "Разрешены только файлы с расширениями: {extensions}",
			sizeError: "Файл {file} слишком большой, максимальный размер файла {sizeLimit}.",
			minSizeError: "Файл {file} слишком маленький, минимально допустимый размер файла {minSizeLimit}.",
			emptyError: "{file} пустой, пожалуйста, выберите другой файл.",
			onLeave: "Файлы в процессе заргузки, не закрывайте, пожалуйста, страницу."
		},
		fileTemplate: '<li>' +
			'<span class="qq-progress-bar"></span>' +
			'<span class="qq-upload-file"></span>' +
			'<span class="qq-upload-spinner"></span>' +
			' [<span class="qq-upload-size"></span>] ' +
			'<a class="qq-upload-cancel" href="#">{cancelButtonText}</a>' +
			'<span class="qq-upload-failed-text">{failUploadtext}</span>' +
			'</li>',
		uploadButtonText: 'Загрузить файл',
		cancelButtonText: 'Отменить',
		failUploadText: 'Загрузка не удалась'
	};

	// overwrite custom options with user supplied
	qq.extend(customOptions, o);

	// call parent constructor
	qq.FileUploader.call(this, customOptions);

	qq.extend(this._options, { uploader: this });
	this._fileUploadErrors = 0;
};

// inherit from FileUploader
qq.extend(qq.ZFileUploader.prototype, qq.FileUploader.prototype);

qq.extend(qq.ZFileUploader.prototype, {
	_createUploadHandler: function() {
		var handler = qq.FileUploader.prototype._createUploadHandler.apply(this, arguments);
		var self = this;
		
		handler._options.onUpload = function(id, fileName, xhr){
			self._onUpload(id, fileName, xhr);
			return self._options.onUpload(id, fileName, xhr);
		}
		
		return handler;
	},
	
	_onComplete: function(id, fileName, result) {
		qq.FileUploader.prototype._onComplete.apply(this, arguments);
		if(!result.success) {
			this._fileUploadErrors++
		}
	},

	_onInputChange: function(input) {
		this._fileUploadErrors = 0;
		qq.FileUploader.prototype._onInputChange.apply(this, arguments);
	},

	getUploadErrors : function(){
		return this._fileUploadErrors;
	}
});

qq.extend(qq.UploadHandlerXhr.prototype, {
	_oldupload: qq.UploadHandlerXhr.prototype._upload,
	_upload: function(id, params){
		var tmp = this._options.onUpload(id, this.getName(id), true);
		if (tmp) params = $.extend(params||{}, tmp);
		var cb = this._options.onUpload;
		this._options.onUpload = function() {};
		this._oldupload(id, params);
		this._options.onUpload = cb;
	}
});
qq.extend(qq.UploadHandlerForm.prototype, {
	_oldupload: qq.UploadHandlerForm.prototype._upload,
	_upload: function(id, params){
		var tmp = this._options.onUpload(id, this.getName(id), false);
		if (tmp) params = $.extend(params||{}, tmp);
		var cb = this._options.onUpload;
		this._options.onUpload = function() {};
		this._oldupload(id, params);
		this._options.onUpload = cb;
	}
});

qq.FileUploaderBasic.prototype._createUploadHandlerOld = qq.FileUploaderBasic.prototype._createUploadHandler;
qq.FileUploaderBasic.prototype._createUploadHandler = function() {
	var handler = this._createUploadHandlerOld();
	var self = this;
	
	handler._options.onUpload = function(id, fileName, xhr){
		self._onUpload(id, fileName, xhr);
		return self._options.onUpload(id, fileName, xhr);
	}
	
	return handler;
};

(function(){
	window.zfileuploaderLoaded = window.zfileuploaderLoaded || false;
	if(window.zfileuploaderLoaded) return;
	window.zfileuploaderLoaded = true;
	
	var events = ['dragstart', 'dragend'];
	var nodes = [document];
	
	for(var ev = 0; ev < events.length; ev++) for(var n = 0; n < nodes.length; n++) {
		qq.attach(nodes[n], events[ev], function(e){
			var elements = qq.getByClass(document, 'qq-upload-drop-area');
			var i, l = elements.length;
			for(i = 0; i < l; i++) qq[e.type == events[0] ? 'addClass' : 'removeClass'](elements[i], 'qq-upload-drop-area-disabled');
		});
	}
}());
