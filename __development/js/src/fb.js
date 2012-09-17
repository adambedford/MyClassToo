// JavaScript Document
// Facebook JS API scripts

  FB.init({
    appId  : '171083009618346',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });



function newInvite(){
                 var receiverUserIds = FB.ui({ 
                        method	: 'apprequests',
                        message	: 'My Class Too allows you to share your class schedule with your friends',
						title	: 'Suggest My Class Too.com to your friends'
                 },
                 function(receiverUserIds) {
                          console.log("IDS : " + receiverUserIds.request_ids);
                        }
                 );
                 //http://developers.facebook.com/docs/reference/dialogs/requests/
}

function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){        
                FB.ui({ method : 'feed', 
                        message: userPrompt,
                        link   :  hrefLink,
                        caption:  hrefTitle,
                        picture: 'http://myclasstoo.com/img/layout/mct_small.png'
               });
               //http://developers.facebook.com/docs/reference/dialogs/feed/
   
}
			
function publishStream(u_id,term){
	streamPublish("MyClassToo.com", 'Easily share your class schedule with your friends!', 'Checkout myclasstoo.com', 'http://myclasstpp.com' ,"My latest schedule!");
}


/*
	jQuery to post latest schedule to user's feed automatically
*/

$(document).ready(function() {
	
	function ajax_feed(u_id,term) {
		
		
		
	}
	
	$("#sched_share").click(function(event) {
		
		event.preventDefault();
		
		var url = $(this).attr("href");
		//var term = $(this).attr("data-term");
		data = 'ajax=true';
		
		$("body").append('<div id="ui_dialog_container"></div>');
		var dialog = $("#ui_dialog_container");						
		
		dialog.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
		
		var dialogOpts = {
			title: "Share your schedule",
			modal: true,
			height: 200,
			width: 350,
			position: 'center',
		};

		dialog.dialog(dialogOpts);
		
		$.ajax({
			url: url,
			type: 'get',
			data: data,
			cache: false,
			success: function(data) {
				//alert(data);
				
				
				//var response = $("#response",data);
				
				dialog.html(data);

			}
			
		});

	});
	
	
});


