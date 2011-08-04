window.addEvent('domready', function() 
{

	//$('tag_editor').hide();
	$('mode').addEvent('change', function(e)
	{
		var selected = $('mode').getSelected();
		var val = selected[0].get('value');
		if(val == 'edit_tags')
		{
			$('content').setStyle('background-color', '#94B6D4');
			
			$$('.list_image a').each(function(e)
			{
				
				e.addEvent('click', function(j)
				{
					new Event(j).stop();
					var id = this.getProperty('id');
					$('tag_editor').show();
					$('editing').innerHTML = id;
					$('tag_editor_id').value = id;
					$('tag_editor_bucket').value = this.getFirst().getProperty('title');
					$('tag_editor_old_tags').value = this.getFirst().getProperty('title');
				});
				
			});
			
			$('tag_editor_cancel').addEvent('click', function(j)
			{
					$('tag_editor').hide();
					$('tag_editor_id').value = '';
					$('tag_editor_bucket').value = '';
			});
			
			$('tag_editor_save').addEvent('click', function(j)
			{
					$('tag_editor').hide();
					$('tag_editor_form').send();
					id = $('tag_editor_id').value;
					$(id).getFirst().setProperty('title', $('tag_editor_bucket').value);
					$('tag_editor_id').value = '';
					$('tag_editor_bucket').value = '';
			});	

			$('tag_editor').addEvent('keypress', function(j){
				if (j.code == 13) j.stop();
				if (j.code == 39) j.stop();
				if (j.code == 34) j.stop();
			});
										   
		}
		if(val == 'view')
		{
			$('content').setStyle('background-color', '#FFFFFF');
			$$('.list_image a').removeEvents();
			$('tag_editor').hide();
			$('alert').hide();
			$('alert').innerHTML = "";
		}
		if(val == 'delete_images_84838ss')
		{
			$('content').setStyle('background-color', '#c04040');
			$('alert').innerHTML = "<strong>WARNING!</strong> Anything done in this mode cannot be undone.";
			$('alert').show();
			$$('.list_image a').each(function(e)
			{
				
				e.addEvent('click', function(j)
				{
					new Event(j).stop();
					var id = this.getProperty('id');
					$(id).fade(0.5);
					var deltorz = new Request({
						url: 'http://img.dasaku.net/admin/delete/' + id + '?frommain=1',
						onSuccess: function(lawl, meh) {
							$(id).fade(0.5);
						}
					});
					 
					deltorz.send();
				});
				
			});
		}
	});
									 
});