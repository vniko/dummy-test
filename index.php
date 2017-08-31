<!DOCTYPE html>
<html lang="ru"><!-- file:///zoon/zoon/packages/ZoonView/Common/head.tpl >>> --><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	

	<title>Zoon.ru</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	
<meta name="viewport" content="width=520,maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script>
window.page_load_start = new Date();
window.page_gen_time = 0;//"{page_generation_time()}"*1.1;
window.Global = {};
window.Global.user = {"id":"2","has_coords":false,"has_coords_in_any_city":false,"lat":55.751153,"lon":37.619602,"ext_type":"facebook"};
window.Global.city_location = [37.619602,55.751153];
window.headerHeight = 0;

window._gaq = [];
window.abtest = {};
</script>
<script>
if ('ontouchstart' in document.documentElement) {
	document.documentElement.className += ' touch-support';
}
</script>

	
<script type="text/javascript" src="./js/underscore-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/require.js" charset="UTF-8"></script>

<script>
window.is_mobile = false;
window.is_ipad = false;
window.is_android = false;
window.is_phone = false;

(function(){
	var rjsconfig = {
		baseUrl: './',
		enforceDefine: true,
		paths: {},
		shim: {},
		waitSeconds: 15
	};

	var P = rjsconfig.paths;
	var S = rjsconfig.shim;
	P['jquery'] = 'js/jquery-1.9.1.min';
	P['js/jquery.lazyload'] = 'js/jquery.lazyload-1.9.7.min';
	S['js/jquery.lazyload'] = { deps : ['jquery'], exports : '$.fn.lazyload' };
	P['fileuploader'] = 'js/fileuploader/fileuploader';
	P['zfileuploader'] = 'js/zfileuploader';
	S['fileuploader'] = { exports: 'qq' };
	S['zfileuploader'] = { deps: ['fileuploader'], exports: 'qq' };
	requirejs.config(rjsconfig);
})();

define('underscore',function(){ return _;});

var jqready = function(cb) {
	require(['jquery'], function($) {
		$(function() { cb($); });
	});
};
var jquery = function(cb) {
	require(['jquery'], function($) {
		cb($);
	});
};
var lazyload = function(container, settings) {
	var lazyClass = 'js-lazyload-images';
	require(['jquery', 'js/jquery.lazyload'], function($) {
		var node = $(container);
		var $lazyNode = $('.' + lazyClass, node);
		$lazyNode.lazyload(settings).removeClass(lazyClass);
		node.scroll();
	});
};
</script>

<script> var docready = function(cb) { cb(); }; </script>

</head>

<!-- file:///zoon/zoon/packages/ZoonView/Common/head.tpl <<< -->
<body class="wide new_page page-corp headroom-disabled bg-gray stick_footer desktop_layout" style="">

<p>

	<div id="wrapper">
		


<div class="layer-box layer-box-default layer-box-price-list-edit">
	<div class="layer-header">
		<h2>Прайс лист для организации с id=<?php echo !empty($_REQUEST['owner_id']) ? intval($_REQUEST['owner_id']) : 1;?></h2>
	</div>
	<div class="layer-inner">
		<div class="price-table"></div>
	</div>
	<button href="#" class="button button-purple submit" style="font-size:20px; padding:10px 20px;">Сохранить</button>
	
	<div id="hintBalloon" class="balloon-simple balloon-darken balloon-hint get-out" style="z-index: 100500">
		<i class="s-icons-balloon-arrow-top s-icons-balloon-arrow-dark balloon-arrow"></i>
		<div class="balloon-content simple-text" style="padding: 15px;"></div>
	</div>
</div>
	

<div class="js-ins"></div>
	
<script type="text/template" id="photoTemplate" class="layer-content">
<div style="white-space: normal;">
	<span class="img-box clearfix">
		<img src="/images/border.gif" class="pull-left mr10 js-lazyload-images" width="55" height="55"/>
		<a class="pull-left button button-silver img-delete" href="#"><i class="button-photo-icon s-icons-photo-delete-dark"></i>Удалить</a>
	</span>
</div>
</script><script type="text/template" id="photoUploadTemplate" class="layer-content">
<div style="white-space: normal;">
	<span class="gray mr10">URL или</span>
	<div class="qq-uploader" style="display: inline">
		<div class="qq-upload-drop-area pull-left mr10" style="display: inline;"><span style="display:block;width:55px;height:55px;background:#eee"></span></div>
		<div class="qq-upload-button iblock middle">
			<a href="#" onclick="return false;" class="button button-silver"><i class="button-photo-icon s-icons-photo-add-dark"></i>Обзор...</a>
		</div>
		<ul class="qq-upload-list iblock middle"></ul>
	</div>
</div>
</script><script type="text/template" id="columnHeader" class="layer-content">
	<span class="ht-header-text mr10"></span><a href="#" class="ht-header-description-switch js-hint s-icons-question"></a>
	<div class="ht-header-description"></div>
</script><script class="layer-content">
	require({
		paths: { handsontable: [ 'js/handsontable/0.24.1/handsontable.full' ] },
		shim: { handsontable: { deps: [ 'jquery' ], exports: '$.fn.handsontable' } }
	});

	//append css
	(document.head || $('head')[0] || document.documentElement).appendChild(function(){
		var link = document.createElement('link');
		link.type = 'text/css';
		link.rel = 'stylesheet';
		link.href = 'js/handsontable/0.24.1/handsontable.full.css';
		return link;
	}());
	
	require(['jquery'], function() {
		var URL_save = 'ajax.php';
		var owner_id = <?php echo !empty($_REQUEST['owner_id']) ? intval($_REQUEST['owner_id']) : 1;?>;
		var margin = 150;
		var currency = 'руб';

		var requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame ||
				window.mozRequestAnimationFrame || window.msRequestAnimationFrame || _.defer;
		var cancelAnimationFrame = window.cancelAnimationFrame || window.webkitCancelAnimationFrame ||
				window.mozCancelAnimationFrame || window.msCancelAnimationFrame || window.clearTimeout;
		
		var ajax = $.ajax({ url: URL_save, data: { action: 'edit', owner_id: owner_id}, type: 'POST' });

		require([ 'jquery', 'underscore', 'handsontable', 'zfileuploader' ], function($, _, Handsontable){
			var $box = $('.layer-box');
			var $header = $('.layer-header', $box);
			var $inner = $('.layer-inner', $box);
			var $bottom = $('.layer-bottom', $box);
			var $table = $('.price-table', $inner);
			var $balloon = $('#hintBalloon');
			var hasChanges = false;
			var hot;
			
			var KEY_CODES = Handsontable.helper.keyCode || Handsontable.helper.KEY_CODES || {};
			
			function refreshHotSize(){
				if (!hot) return;
				hot.render();
				hot.render();
			}

			var UnclosingAutocompleteEditor = (function(){
				var ParentEditor = Handsontable.editors.AutocompleteEditor;
				var Editor = ParentEditor.prototype.extend();

				function onBeforeKeyDown (event) {
					var editor = this.getActiveEditor();
					if (event.keyCode === KEY_CODES.ENTER && editor.isOpened() && editor.htEditor.getSelected()) {
						this.prevent(event);
					}
				}
				function onSelect (editor, event, coords) {
					if (
						(event.button !== 2 || !this.selection.inInSelection(coords)) &&
						!event.shiftKey &&
						(coords.row >= 0 || coords.col >= 0)
					) {
						this.selection.setRangeStart(coords);
						editor.prevent(event);
					}
				}

				Editor.prototype.beginEditing = function(){
					ParentEditor.prototype.beginEditing.apply(this, _.toArray(arguments));
					this.instance.addHook('beforeKeyDown', onBeforeKeyDown);
				};
				Editor.prototype.finishEditing = function(restoreOriginalValue){
					this.instance.removeHook('beforeKeyDown', onBeforeKeyDown);
					ParentEditor.prototype.finishEditing.apply(this, _.toArray(arguments));
				};
				Editor.prototype.open = function(){
					ParentEditor.prototype.open.apply(this, _.toArray(arguments));
					this.htEditor.addHook('beforeOnCellMouseDown', _.partial(onSelect, this));
				};
				Editor.prototype.close = function(){
					ParentEditor.prototype.close.apply(this, _.toArray(arguments));
					$(this.instance.view.wt.wtOverlays.topOverlay.hider).css('padding-bottom', '');
				};
				Editor.prototype.prevent = function(event){
					var _this = this;
					if (!_this.htEditor) return;
					var value = _this.htEditor.getValue();
					_this.setValue(value);
					_this.htEditor.deselectCell();
					_this.focus();
					_this.queryChoices(value);
					event.stopImmediatePropagation();
					event.preventDefault();
				};
				Editor.prototype.updateChoicesList = function(choices){
					ParentEditor.prototype.updateChoicesList.apply(this, _.toArray(arguments));
					
					var _this = this;
					var ht = _this.instance;
					var htEditor = _this.htEditor;
					var wt = ht.view.wt;
					var wtOverlays = wt.wtOverlays;
					var wtViewport = wt.wtViewport;
					var topOverlay = wtOverlays.topOverlay;
					
					var $td = $(_this.TD);
					var $editorRoot = $(htEditor.rootElement);
					var $holder = $(topOverlay.holder);
					var $hider = $(topOverlay.hider);
					
					var tableBottom = topOverlay.getScrollPosition() + $holder.height();
					
					var editorBottom = 20
						+ wtViewport.rowsRenderCalculator.startPosition
						+ $td.position().top
						+ $editorRoot.position().top
						+ _this.getDropdownHeight()
					;

					var diff;
					
					diff = editorBottom - $hider.height();
					if (diff > 0) {
						var orig = $hider.data('origPaddingBottom');
						if (_.isUndefined(orig)) {
							orig = parseFloat($hider.css('padding-bottom'));
							$hider.data('origPaddingBottom', orig);
						}
						$hider.css('padding-bottom', orig < diff ? diff : '');
					}
					
					diff = editorBottom - tableBottom;
					if (diff > 0) {
						topOverlay.setScrollPosition( topOverlay.getScrollPosition() + diff );
					}

					wtOverlays.syncScrollWithMaster();
				};

				return Editor;
			}());

			$balloon.appendTo($('.js-ins'));
			
			$(window).on('resize', _.debounce(function(){
				var newWidth = $(window).width() - margin;
				if (newWidth < 1060) {
					newWidth = 1060;
				}
				$box.width(newWidth);

				$box.height($(window).height() - margin);
				$table.width($box.width());
				$table.height($box.height() - $header.outerHeight() - $bottom.outerHeight());

				refreshHotSize();
			}, 100));
			$(window).trigger('resize');
			
			
			$table.on('click', '.js-hint', function(e){
				e.preventDefault();
				
				if(!$balloon.hasClass('get-out') && $balloon.data('target') == this) {
					$balloon.addClass('get-out');
					return;
				}
				
				var $this = $(this);
				var offset = $this.offset();
				var content = $this.closest('th').find('.ht-header-description').html();
				
				$balloon.find('.balloon-content').html(content);
				
				$balloon.css({
					left: (offset.left - document.body.offset().left) - $balloon.width()/2 + $this.width()/2,
					top: offset.top - document.body.offset().top + 25
				});
				
				$balloon.data('target', this);
				$balloon.removeClass('get-out');
			});
			
			$(document).off('click.pricelisthint').on('click.pricelisthint', function(e){
				var $target = $(e.target);
				
				if(!$target.closest($balloon).length && !$target.closest('.js-hint').length) {
					$balloon.addClass('get-out');
				}
			});
			
			ajax.done(function(options) {
					options.colHeaders = true;
					options.startRows = 1;
					options.minSpareRows = 1;
					options.stretchH = 'all';
					options.colWidths = [20,20,20,10,10,20];
					options.manualColumnResize = true;
					options.rowHeights = 20;
					options.manualRowResize = true;
					options.minSpareRows = 1;
					options.persistentState = true;
					options.fillHandle = 'vertical';

					options.columns.cost.type = 'text';

					options.columns.title.type = 'text';

					options.columns.photo.renderer = function (instance, td, row, col, prop, value, cellProperties) {
						value = Handsontable.helper.stringify(value);
						$(td).empty();

						if (value.indexOf('http') === 0) {
							var $tpl = $($.trim($('#photoTemplate').html()));
							$('img', $tpl).attr({ 'data-original': value });
							$('.img-delete', $tpl).on('click', function (event) {
								event.preventDefault();
								instance.setDataAtCell(row, col, '');
							});
							lazyload($tpl, {
								container: $tpl
							});
							$(td).append($tpl);
						} else {
							new qq.ZFileUploader({
								element: td,
								action: 'ajax.php',
								params: { action: 'uploadPhoto', owner_id: owner_id},
								multiple: false,
								debug: false,
								template: $.trim($('#photoUploadTemplate').html()),
								onComplete: function(id, fileName, result) {
									if (result.success) {
										alert(result.photo);
										instance.setDataAtCell(row, col, result.photo);
									}
								}
							});
						}

						return td;
					};

					options.columns = $.map(options.columns, function (column, index) {
						var $tpl = $('<div></div>').append($.trim($('#columnHeader').html()));

						$('.ht-header-text', $tpl).html(column.title);

						if (column.description) {
							$('.ht-header-description', $tpl).html(column.description);
							$('.ht-header-description', $tpl).hide();
						} else {
							$('.ht-header-description', $tpl).remove();
							$('.ht-header-description-switch', $tpl).remove();
						}
						
						column.data = index;
						//column.width = 80;
						column.title = $tpl.html();

						return column;
					});
					
					options.enterMoves = {
						row: 0,
						col: 1
					};
					
					options.afterChange = function(changes, source) {
						if(changes && changes[0][2] != changes[0][3] && !hasChanges) {
							$(window).trigger('track-event', [ 'corp_pricelist', 'edit' ]);
							hasChanges = true;
						}
					};
					
					options.beforeChange = function(changes, source) {
						for (var i = changes.length - 1; i >= 0; i--) {
							if(changes[i][1] == 'category') {
								var value = $.trim(changes[i][3]);
								var index = value.indexOf('/');
								if(index == value.length-1) {
									changes[i][3] = changes[i][3].slice(0, index);
								}
							}
						}
					};
				
					hot = new Handsontable($table.get(0), options);
					$table.find('.wtHider').eq(0).addClass('htCoreMain');
					hot.validateCells(function(){ hot.render(); });
					_.defer(function(){ hot.render(); });
					
					$inner.css('background', 'none');
	
					hot.addHook('afterRender', function(){
						var render = {};
						
						function fit (td, row, col) {
							var cell = hot.getCellMeta(row, col);
							var $td = $(td);
							var tdHeight = $td.height();

							if (cell.__td_height === tdHeight) {
								return;
							}
							cell.__td_height = tdHeight;
							
							var renderId = row + '-' + col;
							if (render[renderId]) {
								cancelAnimationFrame(render[renderId]);
							}
							render[renderId] = requestAnimationFrame(function(){
								delete render[renderId];
								
								var $fit = $(td.firstChild);
								var lineHeight = parseFloat($fit.css('line-height'));
								var lines = Math.floor(tdHeight / lineHeight);
								var height = lines * lineHeight;
								var multiline = height > lineHeight;

								if (multiline) {
									$fit.height(height).css({ whiteSpace: '' });
								}

								cell.__height = height;
								cell.__multiline = multiline;
							});
						}
						
						return function(){
							var wtTable = this.view.wt.wtTable;
							var first = wtTable.getFirstRenderedRow();
							var last = wtTable.getLastRenderedRow();
							var toFit = _.reduce(options.columns, function(memo, c, i){
								if (c._fit_inner) memo.push(i);
								return memo;
							}, []);

							for (var row = first; row <= last; ++row) {
								_.each(toFit, function(col){
									fit(wtTable.getCell({ row: row, col: col }), row, col);
								});
							}

							var activeEditor = hot.getActiveEditor();
							if (activeEditor && activeEditor.state === Handsontable.EditorState.EDITING) {
								activeEditor.refreshDimensions();
							}
						};
					}());
			});

			var uploadCallback = function(result) {
				if (result.message) {
					alert(result.message);
				}
			};

			$('.submit').on('click', function (event) {
				event.preventDefault();

				$.ajax({
					url: URL_save,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'save',
						owner_id: owner_id, 
						data: JSON.stringify(hot.getSourceData())
					}
				}).done(uploadCallback);
			});

		
		});
	});
</script><div id="hintBalloon" class="balloon-simple balloon-darken balloon-hint get-out" style="z-index: 100500">
		<i class="s-icons-balloon-arrow-top s-icons-balloon-arrow-dark balloon-arrow"></i>
		<div class="balloon-content simple-text" style="padding: 15px;"></div>
	</div></div></div><div id="CopyPasteDiv" style="position: fixed; top: -10000px; left: -10000px;"><textarea class="copyPaste" style="width: 10000px; height: 10000px; overflow: hidden; opacity: 0;"></textarea></div></body><style type="text/css" id="contextinator-jumper"></style></html>
