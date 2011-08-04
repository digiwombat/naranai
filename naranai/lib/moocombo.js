/*
Written by Adam M. Euans

Example:
	<html>
	<title>Moo Combo Box</title>
		<script type="text/javascript" src="mootools.js"></script>
		<script type="text/javascript" src="mooComboBox.js"></script>
	</head>
	<body>
		<select name="firstName" type="comboBox">
			<option value="Adam">Adam</option>
			<option value="Carlos">Carlos</option>
			<option value="Michael">Michael</option>
			<option value="Tim">Tim</option>
		</select>
		</body>
	</html>
*/

var mooComboBox = {
	init: function() {
		this.widthOffset = (window.opera)?0:24,
	    this.heightOffset = (window.opera)?19:6,
		// Loop through all combo boxes
		$$('SELECT[class=combo_box]').each(mooComboBox.setCombo);
	},
			
	setCombo: function(el) {
			// Get x,y coordinates of the select box
			var coords = el.getCoordinates();
			
			// Get default variables and change initial select field
			var _n = el.getProperty('name');
			var _v = el.getProperty('value');
			el.set({name: _n + 'Sel', id: _n + 'Sel'});

			// Insert a text field after the select box
			var txtBox = new Element('input',{
				'type' : 'text',
				'id'   : _n,
				'name' : _n,
				'value': _v,
				'disabled' : el.disabled
				}).setStyles({
					position : 'absolute',
					top		 : 4,
					left	 : 4,
					width	 : coords.width - this.widthOffset,
					height	 : coords.height - this.heightOffset,
					zIndex	 : 1000
				}).injectBefore(el);					
						
			// Add iFrame for IE			
			if (window.ie) {
				new Element('iframe',{
					'id'		  : _n + 'Shim',
					'src'		  : 'about:blank',
					'scrolling'   : 'no',
					'frameborder' : 0
				}).setStyles({
					position : 'absolute',
					top      : txtBox.getStyle('top'),
					left     : txtBox.getStyle('left'),
					width    : txtBox.getStyle('width'),
					height   : txtBox.getStyle('height') 
				}).injectBefore(el);
			};
			
			// Add onchange event to select box to populate text field
			el.addEvent( 'change', mooComboBox.onSelect.bindWithEvent(el) );
	},
	
	onSelect: function() {
		$(this.name.replace('Sel','')).value = this.options[this.selectedIndex].value;
	}
};

window.addEvent('domready', mooComboBox.init);

