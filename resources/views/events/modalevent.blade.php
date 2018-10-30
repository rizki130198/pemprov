<div class="modal fade" id="modalevent" tabindex="-1" role="dialog" aria-labelledby="modaleventLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaleventLabel">Edit Acara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="javascript:void(0);" id="eventsupdate" method="post" accept-charset="utf-8">
        @foreach($editdata as $editevent)
        <div class="modal-body">
          <div class="form-group">
            <label for="inputevent">Nama Acara</label>
            <input type="text" name="nama_events" value="{{$editevent->nama_event}}" class="form-control" id="inputevent" placeholder="Nama Acara">
            <input type="hidden" name="id" value="{{$editevent->id_event}}" class="form-control" id="inputevent" placeholder="Nama Acara">
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="ket" id="keterangan" rows="3">{{$editevent->keterangan}}</textarea>
          </div>
          <div class="form-group">
            <label for="awal">Waktu Mulai Acara</label>
            <input type="text" class="form-control" value="{{date('H:i d/m/Y',strtotime($editevent->mulai))}}" name="awal" id="awaltanggal" placeholder="Waktu Mulai Acara">
          </div>
          <div class="form-group">
            <label for="akhir">Waktu Akhir Acara</label>
            <input type="text" class="form-control" name="akhir"  value="{{date('H:i d/m/Y',strtotime($editevent->akhir))}}" id="akhirtanggal" placeholder="Waktu AKhir Acara">
          </div>
        </div>
        @endforeach
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

  $("#awaltanggal").datetimepicker({ footer: true, modal: true });
  $("#akhirtanggal").datetimepicker({ footer: true, modal: true });
</script>