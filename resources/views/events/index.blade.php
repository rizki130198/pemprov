@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0;position: fixed;width: 20%;">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-8 col-md-offset-3 col-xs-12">
            <div class="content-page-title">
                <i class="fa fa-users"></i> Acara
                @if(Auth::user()->role=='admin')
                <div class="pull-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Buat Acara</button>
                </div>
                @endif
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Acara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="javascript:void(0);" id="eventscreate" method="post" accept-charset="utf-8">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="inputevent">Nama Acara</label>
                        <input type="text" name="nama_events" class="form-control" id="inputevent" placeholder="Nama Acara">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="ket" id="keterangan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="awal">Waktu Mulai Acara</label>
                        <input type="text" class="form-control" name="awal" id="awal" placeholder="Waktu Mulai Acara">
                    </div>
                    <div class="form-group">
                        <label for="akhir">Waktu Akhir Acara</label>
                        <input type="text" class="form-control" name="akhir" id="akhir" placeholder="Waktu AKhir Acara">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
    .panel-primary h5{
        color: #888;
        /*font-size: .9em;*/
    }
    .event-primary h2 {
        margin-top:0;
        margin-bottom: 0;
    }

    .nopadding {
        padding: 0 !important
    }
    time {
        display: inline-block;
        width: 100%;
        color: rgb(255, 255, 255);

        padding: 5px;
        text-align: center;
        text-transform: uppercase;
    }

    time.pink {
        background-color: rgb(197, 44, 102);
    }
    time.purple {
        background-color: rgb(165, 82, 167)
    }

    time.dkblue
    {
        background-color: #336699;
    }
    time.pink { background-color: #fc5ab8}
    time.purple { background-color: #af31f2}
    .time {
        background-color: rgb(165, 82, 167);
    }
    time > span {
        display: none;
    }
    time > .day {
        display: block;
        font-size: 3em;
        font-weight: 100;
        line-height: 1;
    }
    time > .month {
        display: block;
        font-size: 24pt;
        font-weight: 900;
        line-height: 1;
    }
    .nopadding {padding:0 !important;margin:0!important;}
    .panel-primary > .panel-footer {
        color: #fff!important ;
        background-color: #337ab7;
        border-color: #337ab7;
    }
    .panel-primary > .panel-footer p,.panel-primary a {color:#FFF}
    #pinBoot {
      position: relative;
      max-width: 100%;
      width: 100%;
      overflow-x: hidden;
  }
  .white-panel {
      position: absolute;
      background: white;
      box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
  }
</style>
<div class="">
    @if($data->count() == 0)

    <div class="alert-message alert-message-default">
        <h4>Belum ada Acara</h4>
    </div>

    @else
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif
    <section id="pinBoot">
        @foreach($data as $dataevent)
        <article class="white-panel">
            <div class="panel-default event-primary panel-google-plus" id="panel-post-event-{{ $dataevent->id_events }}">
                <div class="panel-heading" style="margin-top:0;background-color: #444753 !important;background:none;color: #fff;">
                    @if ($dataevent->id_users == Auth::user()->id)
                        <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteEvent('{{$dataevent->id_events}}')" style="float: right;margin-top: 5px;" data-toggle="tooltip" data-placement="right" title="Hapus Event"><i class="glyphicon glyphicon-trash"></i></a>
                    @endif
                    <h2>{{ $dataevent->nama_event }}</h2>
                    <a href="{{ url('/'.$dataevent->username) }}" style="color: #fff;"><span>{{ $dataevent->name }}</span></a>
                    <span style="color: #92959E;margin-left: 10px;"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $dataevent->tanggal->diffForHumans() }}</span>

                </div>
                <div class="panel-body nopadding">
                    <!-- <img src="https://placehold.it/400x150" alt="event image" class="img-responsive"/> -->
                    <div class="row nopadding">
                        <div class="col-sm-6 nopadding">
                            <time class="start pink">
                                Mulai <span class="day">{{ date('d/M/y', strtotime($dataevent->mulai))}}</span>
                                <span class="month">{{ date('h:i', strtotime($dataevent->mulai))}}</span>
                            </time>
                        </div>
                        <div class="col-sm-6 nopadding">
                            <time class="end purple">
                                Selesai <span class="day">{{ date('d/M/y', strtotime($dataevent->akhir))}}</span>
                                <span class ="month">{{ date('h:i', strtotime($dataevent->akhir))}}</span>
                            </time>
                        </div>
                    </div>
                </div>
                <div class="panel-footer panel-primary">
                    <h4 style="margin-bottom: 20px;">{{ $dataevent->keterangan }}</h4>
                    <div class="comments-title-event">
                        @include('events.widgets.comments_title')
                    </div>
                    <div class="post-comments-event">
                        @foreach($dataevent->comments()->limit(NULL)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

                        @include('events.widgets.single_comment')

                        @endforeach
                    </div>
                    <div class="input-placeholder" style="margin-left: 0;margin-top: 0;">Masukan komentar...</div>
                </div>
                <div class="panel-google-plus-comment" style="border: solid 1px #ddd;">
                    <img class="img-circle" src="{{ $user->getPhoto(40,40) }}" alt="User Image" />
                    <div class="panel-google-plus-textarea">
                        <form id="form-new-comment-event">
                            <textarea rows="4" style="width: 100%;resize: none;"></textarea>
                            <a href="javascript:void(0)" class="btn btn-warning" onclick="submitCommentEvents({{ $dataevent->id_events }})">Bagikan komentar</a>
                        </form>
                        <button type="reset" style="margin-top: -34px;margin-right: 0;float: right;" class="btn btn-default">Batal</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </article>
        @endforeach
    </section>
</div>
@endif
</div>
</div>
</div>
@endsection

@section('footer')
<script type="text/javascript">
    $(document).ready(function() {
        $('#pinBoot').pinterest_grid({
            no_columns: 2,
            padding_x: 20,
            padding_y: 20,
            margin_bottom: 50,
            single_column_breakpoint: 700
        });
    });

    ;(function ($, window, document, undefined) {
        var pluginName = 'pinterest_grid',
        defaults = {
            padding_x: 10,
            padding_y: 10,
            no_columns: 3,
            margin_bottom: 50,
            single_column_breakpoint: 700
        },
        columns,
        $article,
        article_width;

        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, defaults, options) ;
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function () {
            var self = this,
            resize_finish;

            $(window).resize(function() {
                clearTimeout(resize_finish);
                resize_finish = setTimeout( function () {
                    self.make_layout_change(self);
                }, 11);
            });

            self.make_layout_change(self);

            setTimeout(function() {
                $(window).resize();
            }, 500);
        };

        Plugin.prototype.calculate = function (single_column_mode) {
            var self = this,
            tallest = 0,
            row = 0,
            $container = $(this.element),
            container_width = $container.width();
            $article = $(this.element).children();

            if(single_column_mode === true) {
                article_width = $container.width() - self.options.padding_x;
            } else {
                article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
            }

            $article.each(function() {
                $(this).css('width', article_width);
            });

            columns = self.options.no_columns;

            $article.each(function(index) {
                var current_column,
                left_out = 0,
                top = 0,
                $this = $(this),
                prevAll = $this.prevAll(),
                tallest = 0;

                if(single_column_mode === false) {
                    current_column = (index % columns);
                } else {
                    current_column = 0;
                }

                for(var t = 0; t < columns; t++) {
                    $this.removeClass('c'+t);
                }

                if(index % columns === 0) {
                    row++;
                }

                $this.addClass('c' + current_column);
                $this.addClass('r' + row);

                prevAll.each(function(index) {
                    if($(this).hasClass('c' + current_column)) {
                        top += $(this).outerHeight() + self.options.padding_y;
                    }
                });

                if(single_column_mode === true) {
                    left_out = 0;
                } else {
                    left_out = (index % columns) * (article_width + self.options.padding_x);
                }

                $this.css({
                    'left': left_out,
                    'top' : top
                });
            });

            this.tallest($container);
            $(window).resize();
        };

        Plugin.prototype.tallest = function (_container) {
            var column_heights = [],
            largest = 0;

            for(var z = 0; z < columns; z++) {
                var temp_height = 0;
                _container.find('.c'+z).each(function() {
                    temp_height += $(this).outerHeight();
                });
                column_heights[z] = temp_height;
            }

            largest = Math.max.apply(Math, column_heights);
            _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
        };

        Plugin.prototype.make_layout_change = function (_self) {
            if($(window).width() < _self.options.single_column_breakpoint) {
                _self.calculate(true);
            } else {
                _self.calculate(false);
            }
        };

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName,
                        new Plugin(this, options));
                }
            });
        }

    })(jQuery, window, document);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete_form').on('submit', function(){
            if (confirm("Yakin hapus Event?")) {
                return true;
            }else{
                return false;
            }
        });
    });
</script>
@endsection