var promt_modal = {
	title: function(title = null){
		return (title != null) ? title : '';
	},
	
	message: function(msg = null){
		return (msg != null) ? msg : '';
	},
	cancel_text: function(text = null){
		return (text != null) ? text : 'Cancel';
	},
	submit_text: function(text = null){
		return (text != null) ? text : 'Submit';
	},
	on_submit: function(action = 'link'){
		return (action != 'link') ? action : 'Submit';
	}

}

console.log(promt_modal.title());