<input type="hidden" name="chat_friend_id" value="{{ $friend->id }}">
<div class="chat-info">
    <a href="{{ url('/'.$friend->username) }}" class="user-profile">
        <img class="img-circle" src="{{ $friend->getPhoto(50, 50) }}">
        <div class="detail">
            <strong>{{ $friend->name }}</strong>
            <p style="color: #92959E;">{{ '@'.$friend->username }}</p>
        </div>
    </a>
    <a class="btn btn-default btn-xs btn-remove" onclick="deleteChat({{ $friend->id }})" data-toggle="tooltip" data-placement="bottom" title="Hapus Pesan">
        <i class="fa fa-times"></i>
    </a>
    <div class="clearfix"></div>
</div>

<div class="message-list">
    @php($first_message_id = 0)
    @if($message_list->count() == 0)
        <div class="alert alert-info">
            Tidak ada pesan
        </div>
    @else
        @php($i=0)
        @foreach($message_list->get()->reverse() as $message)

            @include('messages.widgets.single_message')

            @if($i == 0)
                @php($first_message_id = $message->id)
            @endif
            @php($i++)
        @endforeach
    @endif
    <div class="first_message_div">
        <input type="hidden" name="first_message_id" value="{{ $first_message_id }}">
    </div>
</div>
<div class="message-write">
    <form id="form-message-write" action="javascript:void(0);" method="post" accept-charset="utf-8"  >
        <input type="hidden" name="user_id" value="{{ $friend->id }}">
        @if ($can_send_message)
            <input class="form-control" rows="1" id="pesan" placeholder="Pesan kamu.." autocomplete="off" style="height: 56px;">
        @else
        <div class="alert alert-danter">Anda tidak dapat mengirim pesan baru lagi.</div>
        @endif
    </form>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $("#form-message-write").submit(function (event) {

        var id = $('#form-message-write input').val();
        var message = $('#pesan').val();

        if (message.trim() != '') {
            var data = new FormData();
            data.append('id', id);
            data.append('message', message);


            $.ajax({
                url: BASE_URL + '/direct-messages/send',
                type: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function (response) {
                    if (response.code == 200) {
                        $('.dm .chat .message-list .alert').remove();
                        $('#pesan').val("");
                        $('.dm .chat .message-list').append(response.html);
                        $(".dm .chat .message-list").animate({ scrollTop: $('.dm .chat .message-list').prop("scrollHeight")}, 1000);
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
      return false;
  });
});
</script>