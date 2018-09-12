/**
 * Created by lvntayn on 04/06/2017.
 */
 $(function() {
    if (WALL_ACTIVE) {
        $('.new-postgrup-box textarea, .panel-postgrup .postgrup-write-comment textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                fetchForOlderPostgrups();
            }
        });


        setInterval(function(){

            fetchForNewPostgrups();

        }, 40000);

    }

});

 $("#grupcreate").submit(function (event) {
  var data = new FormData($(this)[0]); 
  $.ajax({
    url: BASE_URL + '/postgrups/create',
    type: "POST",
    data: data,
    contentType: false,
    cache: false,
    processData: false,
    headers: {'X-CSRF-TOKEN': CSRF},
    success: function (response) {
        if (response.code == 200) {
            $('#exampleModal2').modal('hide');
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
//  $("#form-new-postgrup").submit(function (event) {
//   var data = new FormData($(this)[0]);
//   $.ajax({
//     url: BASE_URL+'/postgrups/new',
//     type: "POST",
//     timeout: 5000,
//     data: data,
//     contentType: false,
//     cache: false,
//     processData: false,
//     headers: {'X-CSRF-TOKEN': CSRF},
//     success: function(response){
//         if (response.code == 200){
//             cleanPostgrupForm();
//             $("#form-new-postgrup" + ' .loading-postgrup').hide();
//             $('.postgrup-list-top-loading').show();
//             fetchForNewPostgrups();
//         }else{
//             $('#errorMessageModal').modal('show');
//             $('#errorMessageModal #errors').html(response.message);
//             $("#form-new-postgrup" + ' .loading-postgrup').hide();
//         }
//     },
//     error: function(){
//         $('#errorMessageModal').modal('show');
//         $('#errorMessageModal #errors').html('Something went wrong!');
//         $("#form-new-postgrup" + ' .loading-post').hide();
//     }
// });

//   return false;
// });

function tambahanggota()
{
  var input_data = $('#getanggota').val();
  var grup = $('#grup').val();

  if (input_data.length === 0)
  {
    $('#suggestions').hide();
}
else
{

    var post_data = {
      'cari': input_data,
      'grup': grup
  };

  $.ajax({
      type: "POST",
      url: BASE_URL+'/postgrups/tambah/'+grup,
      data: post_data,
      headers: {'X-CSRF-TOKEN': CSRF},
      success: function (data) {
                // return success
                if (data.length > 0) {
                  $('#suggestions').show();
                  $('#autoSuggestionsList').addClass('auto_list');
                  $('#autoSuggestionsList').html(data);
              }
          }
      });

}
}
function uploadPostgrupImage(){
    var form_name = '#form-new-postgrup';
    $(form_name+' .image-input').click();
}

function previewPostgrupImage(input){

    var output = [];
    for (var i = 0, f; f = input.files[i]; i++) {
      output.push('<li><strong class="label label-primary">', escape(f.name), '</strong>',
          '</li>');
  }
  document.getElementById('listimage').innerHTML = '<ul>' + output.join('') + '</ul>';
}

function removePostGrupFile(){
    var form_name = '#form-new-postgrup';
    $('#list').hide();
    resetFile($(form_name + ' .file-input'));
}
function uploadPostgrupFile(){
    var form_name = '#form-new-postgrup';
    $(form_name+' .file-input').click();
}

function previewPostgrupFile(input){
    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = input.files[i]; i++) {
      output.push('<li><strong>', escape(f.name), '</strong>',
          '</li>');
  }
  document.getElementById('lista').innerHTML = '<ul>' + output.join('') + '</ul>';
}

function removePostgrupImage(){
    var form_name = '#form-new-postgrup';
    $('#listimage').hide();
    resetFile($(form_name + ' .image-input'));
}

function cleanPostgrupForm(){
    var form_name = '#form-new-postgrup';
    $(form_name + ' textarea').val('');
    $('#lista').val('');
    $('#listimage').val('');
    removePostgrupImage();
    removePostGrupFile();
}

function newPostgrup(){
    var form_name = '#form-new-postgrup';

    $(form_name + ' .loading-postgrup').show();

    var data = new FormData();
    data.append('data', JSON.stringify(makeSerializable(form_name).serializeJSON()));

    var ins = document.getElementById('imageupload').files.length;
    for (var x = 0; x < ins; x++) {
        data.append("image[]", document.getElementById('imageupload').files[x]);
    }

    var ini = document.getElementById('files').files.length;
    for (var x = 0; x < ini; x++) {
        data.append("files[]", document.getElementById('files').files[x]);
    }

    $.ajax({
        url: BASE_URL+'/postgrups/new',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                fetchForNewPostgrups();
                cleanPostgrupForm();
                $(form_name + ' .loading-postgrup').hide();
                $('.post-list-top-loading').show();
            }else{
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(response.message);
                $(form_name + ' .loading-postgrup').hide();
            }
        },
        error: function(){
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
            $(form_name + ' .loading-postgrup').hide();
        }
    });

}

var fetch_end = false;
var count_empty_query = 0;

function fetchPostgrup(wall_type, list_type, optional_id, limit, postgrup_min_id, postgrup_max_id, location){
    if (!fetch_end) {
        fetch_end = true;
        $.ajax({
            url: BASE_URL + '/postgrups/list',
            type: "GET",
            timeout: 5000,
            data: "wall_type=" + wall_type + "&list_type=" + list_type + "&optional_id=" + optional_id + "&limit=" + limit + "&postgrup_min_id=" + postgrup_min_id + "&postgrup_max_id=" + postgrup_max_id + "&div_location=" + location,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (render) {
                if (render != "") {
                    $('.postgrup-list .postgrup_data_filter_' + location).remove();
                    if (location == 'bottom') {
                        $('.postgrup-list').append(render);
                    } else if (location == 'top') {
                        $('.postgrup-list').prepend(render);
                    } else {
                        $('.postgrup-list').html(render);
                    }
                }else{
                    if (location == 'bottom') {
                        count_empty_query = count_empty_query + 1;
                    }
                }
                $('.postgrup-list-top-loading').hide();
                $('.postgrup-list-bottom-loading').hide();
                fetch_end = false;
            },
            error: function () {
                /*
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong when loading your wall!');*/
                $('.postgrup-list-top-loading').hide();
                $('.postgrup-list-bottom-loading').hide();
                fetch_end = false;
            }
        });
    } 
}

function fetchForNewPostgrups(){
    var wall_type = $('.postgrup-list .postgrup_data_filter_top input[name=wall_type]').val();
    var list_type = $('.postgrup-list .postgrup_data_filter_top input[name=list_type]').val();
    var optional_id = $('.postgrup-list .postgrup_data_filter_top input[name=optional_id]').val();
    var limit = 150000;
    var postgrup_min_id = -1;
    var postgrup_max_id = $('.postgrup-list .postgrup_data_filter_top input[name=postgrup_max_id]').val();
    if (postgrup_max_id > 0 || $('.panel-postgrup').length == 0) {
        fetchPostgrup(wall_type, list_type, optional_id, limit, postgrup_min_id, postgrup_max_id, 'top');
    }
} 

function fetchForOlderPostgrups(){
    var wall_type = $('.postgrup-list .postgrup_data_filter_bottom input[name=wall_type]').val();
    var list_type = $('.postgrup-list .postgrup_data_filter_bottom input[name=list_type]').val();
    var optional_id = $('.postgrup-list .postgrup_data_filter_bottom input[name=optional_id]').val();
    var limit = 5;
    var postgrup_min_id = $('.postgrup-list .postgrup_data_filter_bottom input[name=postgrup_min_id]').val();
    var postgrup_max_id = -1;
    if (postgrup_min_id > 1 && count_empty_query < 5) {
        $('.postgrup-list-bottom-loading').show();
        fetchPostgrup(wall_type, list_type, optional_id, limit, postgrup_min_id, postgrup_max_id, 'bottom');

    }
}


function deletePostgrup(id){

    BootstrapDialog.show({
        title: 'Postgrup Delete!',
        message: 'Are you sure to delete postgrup ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/postgrups/delete',
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
                            $('#panel-postgrup-'+id).html("Postgrup deleted!");
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


function likePostgrup(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL+'/postgrups/like',
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
                    $('#panel-postgrup-'+id+' .like-text span').html('Unlike!');
                    $('#panel-postgrup-'+id+' .like-text i').removeClass('fa-heart-o').addClass('fa-heart');
                }else{
                    $('#panel-postgrup-'+id+' .like-text span').html('Like!');
                    $('#panel-postgrup-'+id+' .like-text i').removeClass('fa-heart').addClass('fa-heart-o');
                }
                if (response.like_count > 1){
                    $('#panel-postgrup-'+id+' .all_likes span').html(response.like_count+' likes');
                }else{
                    $('#panel-postgrup-'+id+' .all_likes span').html(response.like_count+' like');
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

function submitCommentgrup(id){

    var data = new FormData();
    data.append('id', id);
    var comment = $('#panel-postgrup-'+id+' #form-new-comment-grup textarea').val();
    data.append('comment', comment);

    if (comment.trim() == ''){
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Please write comment!');
    }else {
        $.ajax({
            url: BASE_URL + '/postgrups/comment',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    $('#panel-postgrup-'+id+' #form-new-comment-grup textarea').val("");
                    $('#panel-postgrup-'+id+' .comments-title-grup').html(response.comments_title);
                    $('#panel-postgrup-'+id+' .postgrup-comments-grup').append(response.comment);
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


function removeCommentGrup(id, postgrup_id){

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
                    url: BASE_URL+'/postgrups/comments/delete',
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
                            $('#post-comments-grup-'+id+' .commet').html("<p><small>Comment deleted!</small></p>");
                            $('#panel-postgrup-'+postgrup_id+' .comments-title-grup').html(response.comments_title);
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



function showLikes(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL + '/postgrups/likes',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) { 
            if (response.code == 200) {
                $('#likeListModal .user_list').html(response.likes);
                $('#likeListModal').modal('show');
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
function uploadGroupCover(id){
    var div_name = '.cover';
    var form_name = '#form-upload-covergrup';
    $(form_name+' input').click();
    $(form_name+' input').change(function (){

        $(div_name+ ' .loading-cover').show();

        var data = new FormData();
        data.append('cover', JSON.stringify(makeSerializable(form_name).serializeJSON()));


        var file_inputs = document.querySelectorAll('.covergrup_input');
        $(file_inputs).each(function(index, input) {
            data.append('image', input.files[0]);
        });


        $.ajax({
            url: BASE_URL+'/upload/cover_grup/'+id,
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function(response){
                if (response.code == 200){
                    location.reload();
                    $(div_name+ ' .loading-cover').hide();
                    $(div_name).removeClass('no-cover');
                }else{
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html(response.message);
                    $(div_name+ ' .loading-cover').hide();
                }
            },
            error: function(){
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
                $(div_name+ ' .loading-cover').hide();
            }
        });
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
function kickanggota(id){
    BootstrapDialog.show({
        title: 'Keluarkan Anggota!',
        message: 'Yakin Keluarkan Anggota ?',
        buttons: [{
            label: "Kamu yakin ?",
            cssClass: 'btn-danger',
            action: function(dialog) {
                $.ajax({
                    url: BASE_URL+'/group/delete/member/'+id,
                    type: "POST",
                    timeout: 5000,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        if (response.code == 200){
                            location.reload();
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
function createdadmin(id){
    BootstrapDialog.show({
        title: 'Jadikan Admin!',
        message: 'Yakin Jadikan Admin ?',
        buttons: [{
            label: "Kamu yakin ?",
            cssClass: 'btn-danger',
            action: function(dialog) {
                $.ajax({
                    url: BASE_URL+'/group/addadmin/'+id,
                    type: "POST",
                    timeout: 5000,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        if (response.code == 200){
                            location.reload();
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