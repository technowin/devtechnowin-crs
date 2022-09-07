<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Partials Demo</h3>
    </div>
    <div class="panel-body">
        {{ Form::open(['action' => ['HomeController@index', 1]]) }}
        {{ Form::text('name','',array('class'=>'form-control')) }}
        {{ Form::close() }}
    </div>
</div>