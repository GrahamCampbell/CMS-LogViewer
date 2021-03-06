@extends(Config::get('views.default', 'layouts.default'))

@section('title')
LogViewer
@stop

@section('top')
<div class="page-header">
<h1>LogViewer</h1>
</div>
@stop

@section('content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills">
                <li class="{{ $current === null || $current === 'all' ? 'active' : ''}}"><a href="{{ Request::root() }}/{{ $url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/all' }}">All</a></li>
                @foreach ($levels as $level)
                    <li class="{{ $current === $level ? 'active' : '' }}"><a href="{{ Request::root() }}/{{ $url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/'.$level }}">{{ ucfirst($level) }}</a></li>
                @endforeach
                <li class="pull-right">
                    <button data-toggle="modal" data-target="#delete_modal" id="btn-delete" type="button" class="btn btn-danger">Delete current log</button>
                </li>
            </ul>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3">
        @if($logs)
        <div class="panel-group" id="accordion">
            @foreach ($logs as $type => $files)
            <?php $count = count($files['logs']) ?>
                @foreach ($files['logs'] as $app => $file)
                    @if(!empty($file))
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    {{ ($count > 1 ? $app.' - '.$files['sapi'] : $files['sapi']) }}
                                </h4>
                            </div>
                            <div id="collapse-{{ lcfirst($files['sapi']) }}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav nav-list">
                                        @foreach ($file as $f)
                                             <li class="list-group-item">
                                                <a href="{{ Request::root() }}/{{ $url.'/'.$app.'/'.$type.'/'.$f }} ">{{ $f }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        @endif
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12" id="data">
                    <p class="lead"><i class="fa fa-refresh fa-spin fa-lg"></i> Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete this log! This process cannot be undone.</p>
                <p>Are you sure you wish to continue?</p>
            </div>
            <div class="modal-footer">
                {{ HTML::link($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/delete', 'Yes', array('class' => 'btn btn-success')) }}
                <button class="btn btn-danger" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
{{ Asset::styles('logviewer') }}
@endsection

@section('js')
<script>
var cmsLogViewerURL = '{{ $data_url }}';
</script>
{{ Asset::scripts('logviewer') }}
@endsection
