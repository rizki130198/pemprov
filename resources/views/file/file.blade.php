@extends('layouts.app')

@section('content')
<style type="text/css">
  .col-md-offset-3{
    margin-left: 21%;
  }
  @media(min-width: 1200px){
    .col-md-6{
      width: 53%;
    }
  }
  @media(max-width: 768px){
    .col-md-offset-3{
      margin-left: auto;
    }
  }
  .icon {
    font-size: 23px;
    transition: 0.2s ease-in-out 0s;
  }
  .icon_type_folder {
    display: inline-block;
    margin: 1em;
    background-color: transparent;
    overflow: hidden;
  }
  .icon_type_folder:before {
    content: '';
    float: left;
    background-color: #7ba1ad;
    width: 1.5em;
    height: 0.45em;
    margin-left: 0.07em;
    margin-bottom: -0.07em;
    border-top-left-radius: 0.1em;
    border-top-right-radius: 0.1em;
    box-shadow: 1.25em 0.25em 0 0em #7ba1ad;
  }
  .icon_type_folder:after {
    content: '';
    float: left;
    clear: left;
    background-color: #a0d4e4;
    width: 3em;
    height: 2.25em;
    border-radius: 0.1em;
  }
  .icon_type_folder.icon_full:before {
    height: 0.55em;
  }
  .icon_type_folder.icon_full:after {
    height: 2.15em;
    box-shadow: 0 -0.12em 0 0 #fff;
  }
  .icon_type_file {
    width: 2.5em;
    height: 3em;
    line-height: 3em;
    text-align: center;
    border-radius: 0.25em;
    color: #fff;
    display: inline-block;
    margin: 0.9em 1.2em 0 1.3em;
    position: relative;
    overflow: hidden;
    box-shadow: 1.74em -2.1em 0 0 #a4a7ac inset;
  }
  .icon_type_file:first-line {
    font-size: 13px;
    font-weight: 700;
  }
  .icon_type_file:after {
    content: '';
    position: absolute;
    z-index: -1;
    border-width: 0;
    border-bottom: 2.6em solid #dadde1;
    border-right: 2.22em solid rgba(0,0,0,0);
    top: -34.5px;
    right: -4px;
  }
  .icon_ext_avi,
  .icon_ext_flv,
  .icon_ext_mkv,
  .icon_ext_mov,
  .icon_ext_mpeg,
  .icon_ext_mpg,
  .icon_ext_mp4,
  .icon_ext_m4v,
  .icon_ext_wmv {
    box-shadow: 1.74em -2.1em 0 0 #7e70ee inset;
  }
  .icon_ext_avi:after,
  .icon_ext_flv:after,
  .icon_ext_mkv:after,
  .icon_ext_mov:after,
  .icon_ext_mpeg:after,
  .icon_ext_mpg:after,
  .icon_ext_mp4:after,
  .icon_ext_m4v:after,
  .icon_ext_wmv:after {
    border-bottom-color: #5649c1;
  }
  .icon_ext_mp2,
  .icon_ext_mp3,
  .icon_ext_m3u,
  .icon_ext_wma,
  .icon_ext_xls,
  .icon_ext_xlsx {
    box-shadow: 1.74em -2.1em 0 0 #5bab6e inset;
  }
  .icon_ext_mp2:after,
  .icon_ext_mp3:after,
  .icon_ext_m3u:after,
  .icon_ext_wma:after,
  .icon_ext_xls:after,
  .icon_ext_xlsx:after {
    border-bottom-color: #448353;
  }
  .icon_ext_doc,
  .icon_ext_docx,
  .icon_ext_psd {
    box-shadow: 1.74em -2.1em 0 0 #03689b inset;
  }
  .icon_ext_doc:after,
  .icon_ext_docx:after,
  .icon_ext_psd:after {
    border-bottom-color: #2980b9;
  }
  .icon_ext_gif,
  .icon_ext_jpg,
  .icon_ext_jpeg,
  .icon_ext_pdf,
  .icon_ext_png {
    box-shadow: 1.74em -2.1em 0 0 #e15955 inset;
  }
  .icon_ext_gif:after,
  .icon_ext_jpg:after,
  .icon_ext_jpeg:after,
  .icon_ext_pdf:after,
  .icon_ext_png:after {
    border-bottom-color: #c6393f;
  }
  .icon_ext_deb,
  .icon_ext_dmg,
  .icon_ext_gz,
  .icon_ext_rar,
  .icon_ext_zip,
  .icon_ext_7z {
    box-shadow: 1.74em -2.1em 0 0 #867c75 inset;
  }
  .icon_ext_deb:after,
  .icon_ext_dmg:after,
  .icon_ext_gz:after,
  .icon_ext_rar:after,
  .icon_ext_zip:after,
  .icon_ext_7z:after {
    border-bottom-color: #685f58;
  }
  .icon_ext_html,
  .icon_ext_rtf,
  .icon_ext_xml,
  .icon_ext_xhtml {
    box-shadow: 1.74em -2.1em 0 0 #a94bb7 inset;
  }
  .icon_ext_html:after,
  .icon_ext_rtf:after,
  .icon_ext_xml:after,
  .icon_ext_xhtml:after {
    border-bottom-color: #d65de8;
  }
  .icon_ext_js {
    box-shadow: 1.74em -2.1em 0 0 #d0c54d inset;
  }
  .icon_ext_js:after {
    border-bottom-color: #a69f4e;
  }
  .icon_ext_css,
  .icon_ext_sass,
  .icon_ext_scss,
  .icon_ext_less,
  .icon_ext_styl,
  .icon_ext_stylus {
    box-shadow: 1.74em -2.1em 0 0 #44afa6 inset;
  }
  .icon_ext_css:after,
  .icon_ext_sass:after,
  .icon_ext_scss:after,
  .icon_ext_less:after,
  .icon_ext_styl:after,
  .icon_ext_stylus:after {
    border-bottom-color: #30837c;
  }

</style>
<div class="h-20 res-post"></div>
<div class="col-md-12 res-home">
  <div class="row">
    <div class="col-md-3" style="padding-left: 0;position: fixed;width: 20%;">
      @include('widgets.sidebar')
    </div>
        <!-- <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
            <div class="hidden-sm hidden-xs">
                @include('news.widgets.news')
                @include('widgets.suggested_people')
            </div>
          </div> -->
          <div class="col-md-9 col-md-offset-3 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3 style="margin:0;">Upload File <small style="color: red;">* .doc, .docx, .psd, .xls, .xlsx, .jpg, .jpeg, .png, .pdf, .rar, .zip</small></h3>
                <hr>
                <form action="javascript:void(0);" id="Formuploadfile" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                  <label>File</label>
                  <div class="controls-kwitansi">
                    <div class="forms-kwitansi row">
                      <div class="entry-kwitansi">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-5">
                              <div class="well" style="padding: 5px;">
                                <input type="file" name="myfile[]" multiple>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-info add-more-kwitansi">Tambah</button>
                              </span>
                            </div>  
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary pull-right">Kirim</button>
                </form>
              </div>
            </div> 
            <div id="datafile">
              <h3 style="margin:0;">Files <small>({{$file->count()}})</small></h3>
              <p style="width: 100%;border-bottom: dashed 2px #d1d1d1;padding-top: 15px;"></p>
              <div class="row">
                @foreach($file as $data)
                <?php 
                $hasil = explode(',', $data->jenis_file);
                $filenya = explode(',', $data->filenya);
                $encrypt = explode(',', $data->encrypt);
                for ($i=0; $i < count($hasil) ; $i++) {  ?>
                  <a href="{{url('/downloads/files/'.$encrypt[$i])}}">
                    <div class="col-md-2 col-xs-4"> 
                      <center><div class="icon icon_type_file icon_ext_{{$hasil[$i]}}">{{$hasil[$i]}}</div></center>
                      <p align="center" style="color: #555;">{{substr($filenya[$i],0,10)}}</p>
                    </div>
                  </a>
                <?php } ?>
                @endforeach
              </div>      
            </div>    
          </div>
        </div>
      </div>    
      @endsection

      @section('footer')
      <script src="{{ asset('js/file.js') }}"></script>
      <script type="text/javascript">
       showFile();
       $(document).on('click', '.add-more-kwitansi', function(e){
        e.preventDefault();

        var controlForm = $('.controls-kwitansi .forms-kwitansi:first'),
        currentEntry = $(this).parents('.entry-kwitansi:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry-kwitansi:not(:last) .add-more-kwitansi')
        .removeClass('add-more-kwitansi').addClass('btn-remove')
        .removeClass('btn-info').addClass('btn-danger')
        .html('Hapus');
      }).on('click', '.btn-remove', function(e){
        $(this).parents('.entry-kwitansi:first').remove();

        e.preventDefault();
        return false;
      });
    </script>
    @endsection