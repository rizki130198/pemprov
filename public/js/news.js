function uploadnewsImage(){
    var form_name = '#form-news';
    $(form_name+' .image-input-news').click();
}

function previewnewsImage(input){

  //   var output = [];
  //   for (var i = 0, f; f = input.files[i]; i++) {
  //     output.push('<li><strong class="label label-primary">', escape(f.name), '</strong>',
  //         '</li>');
  // }
  // document.getElementById('listimagenews').innerHTML = '<ul>' + output.join('') + '</ul>';
    var form_name = '#form-news';
    $(form_name + ' .loading-news').show();
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(form_name + ' .image-area img').attr('src', e.target.result);
            $(form_name + ' .image-area').show();
        };

        reader.readAsDataURL(input.files[0]);
    }
    $(form_name + ' .loading-post').hide();
}
function removenewsImage(){
    var form_name = '#form-news';
    $('#listimagenews').hide();
    resetFile($(form_name + ' .image-input-news'));
    resetFile($('#listimagenews'));
}

function cleannewsForm(){
    var form_name = '#form-news';
    $(form_name + ' textarea').val('');
    $('#listimagenews').html('');
    removenewsImage();
}

function newnews(){
    var form_name = '#form-news';

    $(form_name + ' .loading-news').show();

    var data = new FormData();
    data.append('data', JSON.stringify(makeSerializable(form_name).serializeJSON()));

    var ins = document.getElementById('uploadimagenews').files.length;
    for (var x = 0; x < ins; x++) {
        data.append("image", document.getElementById('uploadimagenews').files[x]);
    }

    $.ajax({
        url: BASE_URL+'/news/new',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                location.reaload();
                cleannewsForm();
                $(form_name + ' .loading-news').hide();
                $('.post-list-top-loading').show();
            }else{
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(response.message);
                $(form_name + ' .loading-news').hide();
            }
        },
        error: function(){
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
            $(form_name + ' .loading-news').hide();
        }
    });

}

function deletenews(id){

    BootstrapDialog.show({
        title: 'news Delete!',
        message: 'Are you sure to delete news ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/news/delete',
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
                            $('#panel-news-gabung-'+id).html("news deleted!");
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

function likenews(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL+'/news/like',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                if (response.type == 'like'){
                    $('#panel-news-'+id+' .like-text span').html('Unlike!');
                    $('#panel-news-'+id+' .like-text i').removeClass('fa-heart-o').addClass('fa-heart');
                }else{
                    $('#panel-news-'+id+' .like-text span').html('Like!');
                    $('#panel-news-'+id+' .like-text i').removeClass('fa-heart').addClass('fa-heart-o');
                }
                if (response.like_count > 1){
                    $('#panel-news-'+id+' .all_likes span').html(response.like_count+' likes');
                }else{
                    $('#panel-news-'+id+' .all_likes span').html(response.like_count+' like');
                }
            }else{
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function(){
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });
}

function commentnews(id){

    var data = new FormData();
    data.append('id', id);
    var comment = $('#news_comment textarea').val();
    data.append('comment', comment);

    if (comment.trim() == ''){
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Please write comment!');
    }else {
        $.ajax({
            url: BASE_URL + '/news/comment',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    $('#panel-news-'+id+' #news_comment textarea').val("");
                    $('#panel-news-'+id+' .comments-nama-news').html(response.nama);
                    $('#panel-news-'+id+' .news-comments').append(response.comment);
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

function removeCommentNews(id,idnews){

    BootstrapDialog.show({
        title: 'Comment Delete!',
        message: 'Are you sure to delete comment ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);
                data.append('idnews',idnews)


                $.ajax({
                    url: BASE_URL+'/news/deletcomment',
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
                            $('#panel-komentar-news-'+id).html("<p><small>Comment deleted!</small></p>");
                            $('#hitung-komentar').html(response.count+ " Komentar");
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
function hapusgrup(id){
    BootstrapDialog.show({
        title: 'Hapus Grup!',
        message: 'Yakin Hapus Grup ?',
        buttons: [{
            label: "Kamu yakin ?",
            cssClass: 'btn-danger',
            action: function(dialog) {
                $.ajax({
                    url: BASE_URL+'/group/delete/'+id,
                    type: "POST",
                    timeout: 5000,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        if (response.code == 200){
                            window.location.replace(BASE_URL+'/groups');
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html(response.message);
                        }
                    },
                    error: function(){
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
function editnews(id) {
    $.ajax({
        url: BASE_URL+'/group/editpost/modal',
        type: 'post',
        setTimeout: 5000,
        headers: {'X-CSRF-TOKEN': CSRF},
        data: {idpostgrup: id},
        success: function(response) {
            $(".modalpostgrup").html(response.html);
            $("#modalpostgrup").modal('show');
        }
    });
}