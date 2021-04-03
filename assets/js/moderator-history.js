$(document).ready(function(){

    getVerifiedMessages(committee_id);

    function getVerifiedMessages(committee_id)
    {
        $.ajax({
            url:"get-verified-messages.php",
            method:"POST",
            data: {committee_id: committee_id},
            success:function(data){
                var html = '';
                // var count = Object.keys(data).length;
                $.each(data, function(key, value){
                    html += '<div class="card mb-3">';
                    if(value.is_verified == 1) {
                        html += '<div class="card-header text-white bg-success">';
                    }
                    else if(value.is_verified == 0) {
                        html += '<div class="card-header text-white bg-danger">';
                    }
                    else {
                        html += '<div class="card-header text-white" style="background-color:#5b92e5;">';
                    }
                    html +=         '<div class = "row">';
                    html +=             '<div class="col"><b>To: </b><strong>' + value.receiver_representation + '</strong></div>';
                    html +=             '<div class="col"><b>From: </b><strong>'+ value.sender_representation +'</strong></div>';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="card-body">';
                    html +=         '<p class="card-text">' + value.message_content + '</p>';
                    html +=         '<div class="row">';
                    html +=             '<button class="btn btn-primary col mx-2 verification" tabindex="1" id="undo" data-messageid="'+ value.message_id +'" >Undo</button>';
                    html +=             '<button class="btn btn-success col mx-2 verification" tabindex="1" id="approve" data-messageid="'+ value.message_id +'" >Approve</button>';
                    html +=             '<button class="btn btn-danger col mx-2 verification" tabindex="2" id="deny" data-messageid="'+ value.message_id +'" >Deny</button>';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="card-footer bg-white border-0 text-muted">';
                    html +=         '<p class="text-center m-0">' + value.created_on +'</p>'
                    html +=     '</div>';
                    html += '</div>';
                });

                $('#messagesArea').html(html);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }     
        })
    }

    $(document).on('click', '.verification', function(){
		
        var is_verified = null;

        if('approve' == $(this).attr('id')) {
            is_verified = 1;
        }
        else if('deny' == $(this).attr('id')) {
            is_verified = 0;
        }
        else if('undo' == $(this).attr('id')) {
            is_verified = 'null';
        }
        else {
        }
        
        var message_id = $(this).attr('data-messageid');

        $.ajax({
            url:"verify-message.php",
            method:"POST",
            data:{message_id: message_id, is_verified: is_verified},
            success:function(data)
            {
                getVerifiedMessages(committee_id);
            }
        })
	});

}); 