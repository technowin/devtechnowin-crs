<div class="panel panel-default partialRow">
    <div class="panel-heading">
        <h3 class="panel-title">
            <div class="row">
                <div class="col-md-3">Partials 2</div>
                <div class="col-md-9"><a href="#" class="deleteRow btn btn-danger btn-sm" style="float:right;">delete</a></div>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        {{ Form::open(['action' => ['HomeController@index', 1]]) }}
        <div class="form-group">
            <label for="quantity">Quantity</label>
            {{ Form::number('quantity[]','',array('id'=>'quantity','class' => 'qty form-control','onkeyup' => 'calculateTotal();')) }}
        </div>
        <div class="form-group">
            <label for="rate">Rate</label>
            {{ Form::number('rate[]','',array('id'=>'rate','class' => 'qty form-control','step'=>'any','onkeyup' => 'calculateTotal();')) }}
        </div>
        <div class="form-group">
            <label for="tax">Rate</label>
            {{ Form::number('tax[]','',array('id'=>'tax','class' => 'qty form-control','step'=>'any','onkeyup'=> 'calculateTotal();')) }}
        </div>
        <div class="form-group">
            <label for="tax">Warranty/AMC Period <small>(in months)</small></label>
            {{ Form::number('warranty_amcperiod[]','',array('id'=>'warranty_amcperiod','class' => 'form-control','step'=>'any','onkeyup' => 'calculateTotal();')) }}
        </div>
        <div class="form-group">
            <label for="gross_rate">Gross Rate  <small>(in &#x20b9;)</small></label>
            {{ Form::number('gross_rate[]','',array('id'=>'expenses_sum','class' => 'form-control','step'=>'any')) }}
        </div>
        {{ Form::submit('submit',array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
</div>