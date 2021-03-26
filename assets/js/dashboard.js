$(document).ready(function(){

    getDelegatesInCommittee(delegate_id, committee_id);

    function getDelegatesInCommittee(delegate_id, committee_id)
    {
        $.ajax({
            url:"get-delegates-in-committee.php",
            method:"POST",
            //data: "delegate_id="+delegate_id+"&committee_id"+committee_id,
            data: {delegate_id: delegate_id, committee_id: committee_id},
            success:function(data){
                var html = '';
                $.each(data, function(key, value){
                    html += '<button class="delegate">';
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
                        html +=     '<span class="text-info"><b>8&nbsp;unread</b></span>';
                    }
                    html +=     '</li>';
                    html += '</button>';
                });
                $('#committeeDelegates').html(html);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }     
        })
    }	
}); 