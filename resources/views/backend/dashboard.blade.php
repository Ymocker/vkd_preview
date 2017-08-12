@extends('backend.layouts.master')

@section('content')
    <h3 class="box-title">Изменить редактируемый номер.</h3>

    <div class="form-group form-group-lg">
        <div class="col-sm-2">
            {{ Form::select('current', $numbers, $admData['editNumberId'], ['class' => 'form-control', 'id' => 'current']) }}
        </div>
    </div>
@endsection

@section('before-scripts')
<script type="text/javascript">
    $("#current").change(function () {
        $.ajax({
            type: "POST",
            url: "changenumber",
            data: { "_token" : "{{ csrf_token() }}", numberId : $("#current option:selected").val(),
                number : $("#current :selected").html() }
        })
            .done(function(result) {
                $("#ed-number").text($("#current :selected").html());
                $("#status-number").text(result);
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {
                //alert( $("#current option:selected").val() );
            });
    });
</script>
@endsection