

@section ('content')
    <div class="ui text menu">
        <h2 class="item">{{$DATA['name']}}</h2>
        
        @cubtn(['state' => $DATA['is_cu']])
        @endcubtn
    </div>
    @table(['DATA' => $DATA])
    @endtable
@stop