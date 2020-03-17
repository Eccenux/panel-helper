// global log
var LOG = new Logger('PanelHelper');

(function($)
{
	$(function()
	{
		// Accordion
		$(".accordion").accordion({ header: "h3", autoHeight: false, collapsible: true });
		// Tabs
		$(".tabs").tabs();
		// Radio/checkboxes/buttons
		$(".buttonset,[data-type='buttonset']").buttonset();
		$('[type="radio"],[type="checkbox"],[type="submit"],[type="button"]').button();
		$('button').each(function(){
			// attributes to options
			var options = {};
			var icon = this.getAttribute('data-icon');
			if (icon && icon.length) {
				options['icons'] = { primary: "ui-icon-" + icon };
			}
			var icon = this.getAttribute('data-icon-right');
			if (icon && icon.length) {
				options['icons'] = { secondary: "ui-icon-" + icon };
			}
			$(this).button(options);
		});
		// select
		//$('select').selectmenu();
		// combobox
		$('.combobox').combobox();
	});
}(jQuery))
/*
<div class="accordion">
	<div>
		<h3><a href="#">First</a></h3>
		<div>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</div>
	</div>
	<div>
		<h3><a href="#">Second</a></h3>
		<div>Phasellus mattis tincidunt nibh.</div>
	</div>
	<div>
		<h3><a href="#">Third</a></h3>
		<div>Nam dui erat, auctor a, dignissim quis.</div>
	</div>
</div>

<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Nunc tincidunt</a></li>
		<li><a href="#tabs-2">Proin dolor</a></li>
		<li><a href="#tabs-3">Aenean lacinia</a></li>
	</ul>
	<div id="tabs-1">
		<p>Tab 1 content</p>
	</div>
	<div id="tabs-2">
		<p>Tab 2 content</p>
	</div>
	<div id="tabs-3">
		<p>Tab 3 content</p>
	</div>
</div>
 
*/