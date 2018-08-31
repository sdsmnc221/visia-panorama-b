@section('title')
    {{implode(' / ', array_keys($DATA['breadcrumb']))}}
@stop

@section('breadcrumb')
    @foreach (array_keys($DATA['breadcrumb']) as $index=>$section)
        @if ($index !== sizeof($DATA['breadcrumb'])-1)
            <a href="{{$DATA['breadcrumb'][$section]}}" 
                title="{{$section}}" class="section">
                {{$section}}
            </a>
            <i class="right chevron icon divider"></i>
        @else
            <span class="active section">{{$section}}</span>
        @endif
    @endforeach
@stop


