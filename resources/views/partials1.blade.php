
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Partials 1</h3>
    </div>
    <div class="panel-body">
        {{ Form::open(['action' => ['HomeController@index', 1]]) }}

        {{ Form::close() }}
    </div>
</div>

{{--@foreach(App\User::find(1)->get() as $value)--}}
{{--{{ $value->name }}--}}
{{--@endforeach--}}