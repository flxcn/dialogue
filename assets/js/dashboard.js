$(document).ready(function(){

    getDelegatesInCommittee(delegate_id, committee_id);

    setInterval(function(){
        updateLastActiveOn(session_id);
        getDelegatesInCommittee(delegate_id, committee_id);
        getMessagesByConversation(delegate_id, other_delegate_id);
    }, 5000);

    function getDelegatesInCommittee(delegate_id, committee_id)
    {
        $.ajax({
            url:"get-delegates-in-committee.php",
            method:"POST",
            //data: "delegate_id="+delegate_id+"&committee_id"+committee_id,
            data: {delegate_id: delegate_id, committee_id: committee_id},
            success:function(data){
                var html = '';
                var count = Object.keys(data).length;
                $.each(data, function(key, value){
                    html += '<button class="delegate" id="'+ value.delegate_id + '" data-delegaterepresentation="'+ value.representation +'">';
                    html +=     '<li class="list-group-item d-flex justify-content-between lh-condensed">';
                    html +=         '<div class="text-left">';
                    html +=             '<h6 class="my-0">' + value.representation + '</h6>';
                    if(value.activity_status == "Online") {
                        html +=         '<small class="text-success"><b>Online</b></small>';
                    } else {
                        html +=         '<small class="text-muted"><b>Offline</b></small>';
                    }
                    html +=         '</div>';
                    if(value.unread_message_count > 0) {
                        html +=     '<span class="text-info"><b>' + value.unread_message_count + '&nbsp;unread</b></span>';
                    }
                    html +=     '</li>';
                    html += '</button>';
                });
                $('#committeeDelegatesCount').html(count);
                $('#committeeDelegates').html(html);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }     
        })
    }

    function updateLastActiveOn(session_id) {
        $.ajax({
			url:"update-last-active-on.php",
            method: "POST",
            data: {session_id: session_id},
			success:function()
			{
			}
		})
    }

    function getMessagesByConversation(this_delegate_id, other_delegate_id) {
        if(other_delegate_id === "") {
            return;
        }
        else {
            $.ajax({
                url:"get-messages-by-conversation.php",
                method:"POST",
                data: {this_delegate_id: this_delegate_id, other_delegate_id: other_delegate_id},
                success:function(data){
                    var html = '';
                    if(jQuery.isEmptyObject(data)) {
                       html = '<p>No messages found.</p>';
                    }
                    else {
                        //var count = Object.keys(data).length;
                        $.each(data, function(key, value){
                            if(value.sender_id == other_delegate_id) {
                                html += '<div class="card col-sm-8 mb-3 float-left bg-light">';
                                html +=     '<div class="card-body text-left">' + value.message_content + '</div>';
                                html += '</div>';    
                                
                            } else {
                                html += '<div class="card col-sm-8 mb-3 float-right bg-primary">';
                                html +=     '<div class="card-body text-left text-white">' + value.message_content + '</div>';
                                html += '</div>';
                            }
                        });
                    }
                    $('#messagesArea').html(html);
                    //resetUnreadMessageCount(other_delegate_id);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }     
            }) 
        }
    }

    $(document).on('click', '.delegate', function(){
		if(other_delegate_id == $(this).attr('id')) {
            return;
        }

        other_delegate_id = $(this).attr('id');
        
        var other_delegate_representation = $(this).attr('data-delegaterepresentation')
        $('#otherDelegateRepresentation').html(other_delegate_representation);
        
        //$(".delegate").removeClass("active");
        //$("#" + other_delegate_id).addClass("active");
        $("textarea#compositionArea").val("");

        getMessagesByConversation(delegate_id, other_delegate_id);
	});

    $(document).on('click', '.send-message', function(){
		var message_content = $('#compositionArea').val();
		if(message_content != '')
		{
			$.ajax({
				url:"add-message.php",
				method:"POST",
				data:{committee_id: committee_id, sender_id: delegate_id, receiver_id: other_delegate_id, message_content: message_content},
				success:function(data)
				{
					$('#compositionArea').val('');
					getMessagesByConversation(delegate_id, other_delegate_id);
				}
			})
		}
        updateScroll();
	});
}); 