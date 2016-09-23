var hcc_allowed_tags = html_code_comments.allowed_tags;

window.onload = function() {
	UpdateAttributes();
}

document.getElementById('remove-attribute-tag').onchange = function(){
	UpdateAttributes();
}; 

function UpdateAttributes() {
	var tag = document.getElementById('remove-attribute-tag').value;
		
	var select = document.getElementById('remove-attribute-name');
	var button = document.getElementById('remove-attribute-button');
	
	select.options.length = 0;	
	
	if (hcc_allowed_tags[tag].length == 0) {
		select.disabled = button.disabled = true;
	} else {
		select.disabled = button.disabled = false;
		
		for(var key in hcc_allowed_tags[tag]) {
			var option = document.createElement('option');
			option.text = key;
			select.add(option);
		}
	}
}