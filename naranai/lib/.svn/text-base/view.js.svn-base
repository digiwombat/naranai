window.addEvent('domready', function(){
		if($('edit'))
		{
			$('edit').setStyle('display', 'none');
							
			$('editclick').addEvent('click', function(){
				$('edit').style.display = ($('edit').style.display == 'none') ? 'block' : 'none';
			});
																		  
							
			new FormCheck('comment_form', {
				display : {
					errorsLocation : 1,
					indicateErrors : 2
				}
			});
			
			new FormCheck('tagform', {
				display : {
					errorsLocation : 1,
					indicateErrors : 2
				}
			});
			
			if(editor_style == 'enhanced')
			{
				// init
				var tlist2 = new FacebookList('img_tags', 'taglist');
									  
				// fetch and feed
				new Request.JSON({'url': base_url + '/tag_list.php', 'onComplete': function(j) {
					j.each(tlist2.autoFeed, tlist2);
				}}).send();
								
				$('tagform').addEvent('submit', function(){
					tlist2.update();
					this.action = base_url + "/save";
				});
			}
			$('add_note').addEvent('click', function(e) {
				note_id = note_id + 1
				
				new Event(e).stop;
				ratio = image.ratio();
				size = 100*ratio;
				var main = new Element('div', {
					'id': 'new_note_' + note_id,
					'class': 'image_note',
					'style': 'width: ' + size + 'px; height: ' + size + 'px;'
				});
				
				main.inject('image_holder', 'top');
				
				var added = new Element('div', {
					'id': 'new_drag_' + note_id,
					'class': 'drag'
				});
				
				added.inject(main, 'top');
				
				var sizer = new Element('div', {
					'class': 'resize',
				});
				
				sizer.inject(added);
				
				var dragger = main.makeDraggable({
					handle: added,
					container: 'image_holder'
				});

				
				//Make the element resizable. Resizing starts on the element with class = resize
				main.makeResizable({
					handle: added.getElement('.resize')
				});
				
				added.getElement('.resize').addEvent('mousedown', function(e) {
					dragger.detach();		   
				});
				
				added.getElement('.resize').addEvent('mouseup', function(e) {
					dragger.attach();		   
				});
				
				var spacer = new Element('div', {
					'class': 'tip_space'				
				});
				
				spacer.inject(main);
				
				var tip = new Element('div', {
					'id': 'new_tip_' + note_id,
					'title': 'Click to edit.',
					'class': 'tip',
					'style': 'width: 175px; height: 125px;'
				});
				
				tip.inject(main);
				tip.hide();
				
				main.addEvent('mouseover', function(e) {
					tip.show();		   
				});
				
				main.addEvent('mouseout', function(e) {
					tip.hide();
				});
				
				tip.addEvent('click', function(e) {
					y = tip.getPosition($('image_holder')).y;
					if(y > 300)
					{
						newtop = y - 15;
						$('note-holder').setStyle('top', newtop + 'px');
					}
					$('note_text').value = '';
					$('note-holder').show();
					$('note_id').value = note_id;
					$('note_new').value = 'true';
				});
				
			});
			
			if($('note_user_id').value != 0)
			{
				$$('.image_note .tip').addEvent('click', function(e) {
					this_id = this.getProperty('id').replace('tip_', '');
					y = this.getPosition($('image_holder')).y;
					if(y > 300)
					{
						newtop = y - 15;
						$('note-holder').setStyle('top', newtop + 'px');
					}
					$('note_text').value = $('tip_original_' + this_id).innerHTML.trim();
					$('note-holder').show();
					$('note_remove').show();
					$('note_id').value = this_id;
					$('note_new').value = 'false';
				});
				
				$$('.image_note').each(function(e){
					var sizer = new Element('div', {
						'class': 'resize',
					});
					
					sizer.inject(e);
					
					var dragger = e.makeDraggable({
						handle: e.getElement('.drag'),
						container: 'image_holder'
					});
					
					e.makeResizable({
						handle: e.getElement('.resize')
					});
					
					e.getElement('.resize').addEvent('mousedown', function(e) {
						dragger.detach();		   
					});
					
					e.getElement('.resize').addEvent('mouseup', function(e) {
						dragger.attach();		   
					});
				});
			}
			
			$('note_cancel').addEvent('click', function(e) {
				$('note-holder').hide();
				$('note_remove').hide();
			});
			
			if($('note_remove'))
			{
				$('note_remove').addEvent('click', function(e) {
					id = $('note_id').value;
					var remover = new Request.HTML({
						url: base_url + '/admin/delete/note',
						method: 'post',
						onSuccess: function()
						{
							$('note_' + id).destroy();
							$('note-holder').hide();
							$('note_remove').hide();
							$('note_remove').disabled = 0;
							$('note_cancel').disabled = 0;
							$('note_save').disabled = 0;
							$('note_text').disabled = 0;
						}
					});
					remover.send('note_id_number=' + id);
					$('note_remove').disabled = 1;
					$('note_cancel').disabled = 1;
					$('note_save').disabled = 1;
					$('note_text').disabled = 1;
					
				});
			}
			if($('add_favorite'))
			{
				$('add_favorite').addEvent('click', function(e) {
					image_id = $('note_image_id').value;
					user_id  = $('note_user_id').value;
					var saver = new Request.HTML({
						url: base_url + '/favourite/save',
						method: 'post'
					});
					saver.send('user_id=' + user_id + '&image_id=' + image_id + '&type=add');
					this.setStyle('display', 'none');
					$('remove_favorite').setStyle('display', 'inline')
				});
			}
			
			if($('remove_favorite'))
			{
				$('remove_favorite').addEvent('click', function(e) {
					image_id = $('note_image_id').value;
					user_id  = $('note_user_id').value;
					var saver = new Request.HTML({
						url: base_url + '/favourite/save',
						method: 'post'
					});
					saver.send('user_id=' + user_id + '&image_id=' + image_id + '&type=remove');
					this.setStyle('display', 'none');
					$('add_favorite').setStyle('display', 'inline')
					
				});
			}
			
			$('note_save').addEvent('click', function(e) {
				id = $('note_id').value;
				initial = $('note_new').value;
				ratio = image.ratio();
				var bacon = '';
				if(initial == 'true')
				{
					bacon = 'new_';	
				}
				thing = $(bacon + 'drag_' + id);
				main = $(bacon + 'note_' + id);
				tip = $(bacon + 'tip_' + id);
				x = thing.getPosition($('image_holder')).x-1;
				y = thing.getPosition($('image_holder')).y-1;
				width = thing.getSize().x;
				height = thing.getSize().y;
				if(ratio != 1)
				{
					x = x/ratio;
					y = y/ratio;
					width = width/ratio;
					height = height/ratio;
				}
				user_id = $('note_user_id').value;
				text = $('note_text').value;
				image_id = $('note_image_id').value;
				var saver = new Request.HTML({
					url: base_url + '/note/save',
					method: 'post',
					update: tip
				});
				saver.send('x=' + x + '&y=' + y + '&width=' + width + '&height=' + height + '&text=' + text + '&new=' + initial + '&id=' + id + '&user_id=' + user_id + '&image_id=' + image_id);
				if(initial != 'true')
				{
					$('tip_original_' + id).innerHTML = text;
				}
				$('note_text').value = '';
				$('note-holder').hide();
				$('note_remove').hide();
				if(initial == 'true')
				{
					tip.removeEvents();
					main.removeEvents();
					thing.removeEvents();
					tip.setStyle('cursor', 'default');
					tip.setStyle('height', 'auto');
					tip.setStyle('width', 'auto');
					main.setStyle('cursor', 'default');
					main.getElement('.resize').destroy();
					main.addEvent('mouseover', function(e) {
						tip.show();		   
					});
					
					main.addEvent('mouseout', function(e) {
						tip.hide();
					});
				}
				
			});
			if(editor_style == 'enhanced')
			{
				area = $$('.maininput');
			}
			else
			{
				area = $('img_tags');
			}
			area.addEvent('keypress', function(j){
					if (j.code == 39) j.stop();
					if (j.code == 34) j.stop();
					if (j.code == 13) j.stop();
					if (j.code == 44) j.stop();
			});
		}
		
		var image = new Image();
		image.resize_image();
		$('resize').addEvent('click', function(e) {
			image.resize_image();
		});
		
		$('main_image').addEvent('click', function(e) {
			show_notes();
		});
});



function confirm_delete(type)
{
	switch(type)
	{
		case 'group':
			text = 'This will remove the image from its group. Are you sure you want to do that?';
			break;
		default:
			text = 'This will completely remove the image. Are you sure you want to do that?';
			break;
	}
	var r=confirm(text);
	if (r==true)
	  {
	   return true;
	  }
	else
	  {
		return false;
	  }
}

var Image = new Class({
    initialize: function(){
		var note_width_hold = new Array();
		var note_height_hold = new Array();
		var note_top_hold = new Array();
		var note_left_hold = new Array();
		$$('.image_note').each(function(e) {
			id = e.getProperty('id').replace('note_', '');
			note_width_hold[id] = e.getStyle('width').toInt();
			note_height_hold[id] = e.getStyle('height').toInt();
			note_top_hold[id] = e.getStyle('top').toInt();
			note_left_hold[id] = e.getStyle('left').toInt();
		});
		this.note_width = note_width_hold;
		this.note_height = note_height_hold;
		this.note_top = note_top_hold;
		this.note_left = note_left_hold;
    },
	
	resize_image: function() 
	{
		var main_image = $("main_image");

		if ((main_image.scale_factor == 1) || (main_image.scale_factor == null)) 
		{
			var client_width = $("content").clientWidth - 15;
			var client_height = $("content").clientHeight;

			if (main_image.getStyle('width').toInt() > client_width) 
			{
				var ratio = main_image.scale_factor = client_width / orig_width;
				main_image.setStyle('width', orig_width * ratio + 'px');
				main_image.setStyle('height', orig_height * ratio + 'px');
				$('alert').innerHTML = "This image has been resized. Click the link in the sidebar to view the full image.";
				$('alert').setStyle('display', 'block');
			}
		} 
		else 
		{
			main_image.scale_factor = 1;
			main_image.setStyle('width', orig_width + 'px');
			main_image.setStyle('height', orig_height + 'px');
			$('alert').setStyle('display', 'none');
		}
	  
		this.scale_notes();		
	},
	 
	scale_notes: function()
	{
		var ratio = this.ratio();
		for (p in this.note_width) 
		{
			if($('note_' + p))
			{
				$('note_' + p).setStyle('width', this.note_width[p] * ratio + 'px');
				$('note_' + p).setStyle('height', this.note_height[p] * ratio + 'px');
				$('note_' + p).setStyle('top', this.note_top[p] * ratio + 'px');
				$('note_' + p).setStyle('left', this.note_left[p] * ratio + 'px');
				console.log(ratio);
			}
		}
	},

	ratio: function() 
	{
		return $('main_image').getStyle('width').toInt() / orig_width;
	}
	
});

function show_notes() 
{
	$$('.image_note').each(function (e){
		if(e.getStyle('display') == 'block')
		{
			e.hide();
		}
		else
		{
			e.show();
		}
	});
}