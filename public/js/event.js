$("#eventscreate").submit(function (event) {
  var data = new FormData($(this)[0]);
  $.ajax({
    url: BASE_URL + '/events/create',
    type: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    headers: {'X-CSRF-TOKEN': CSRF},
    success: function (response) {
        if (response.code == 200) {
            $('#exampleModal').modal('hide');
            location.reload();
        } else {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Ada Kesalahan!');
        }
    },
    error: function () {
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Ada Kesalahan!');
    }
});
  return false;
});

function submitCommentEvents(id){

    var data = new FormData();
    data.append('id', id);
    var comment = $('#panel-post-event-'+id+' #form-new-comment-event textarea').val();
    data.append('komentar', comment);

    if (comment.trim() == ''){
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Please write comment!');
    }else {
        $.ajax({
            url: BASE_URL + '/events/comment',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    $('#panel-post-event-'+id+' #form-new-comment-event textarea').val("");
                    $('#panel-post-event-'+id+' .comments-title-event').html(response.comments_title);
                    $('#panel-post-event-'+id+' .post-comments-event').append(response.comment);
                } else {
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html('Something went wrong!');
                }
            },
            error: function () {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        });
    }
}

function deleteEvent(id){

    BootstrapDialog.show({
        title: 'Post Delete!',
        message: 'Are you sure to delete post ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/events/delete',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('#panel-post-event-'+id).html(" ");
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}
function removeCommentevent(id, post_id){

    BootstrapDialog.show({
        title: 'Comment Delete!',
        message: 'Are you sure to delete comment ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/events/comments/delete',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('#post-comment-'+id+'').html("<p><small>Comment deleted!</small></p>");
                             $('#panel-post-event-'+post_id+' .comments-title-event').html(response.comments_title);
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}


$("#awal").datetimepicker({ footer: true, modal: true });
$("#akhir").datetimepicker({ footer: true, modal: true });