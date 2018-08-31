@extends ('layouts.master')
@include('layouts.content__common')

@section ('content')
    <section class="dashboard__overview ui one column grid">
        <div class="ui text menu column">
            <h2 class="item">Récap des données</h2>
        </div>

        <div class="column">
            <div class="ui stackable three column stretched grid">

                @foreach ($DATA['overview'] as $data)
                    <div class="column">
                        <article class="ui piled segment two column grid">
                            <div class="column">
                                <div class="ui grey label name">
                                    <i class="huge {{$data['icon']}} icon"></i>
                                </div>
                                <div class="cu">
                                    <div class="ui tiny middle aligned buttons">
                                        <a href="{{$data['alias']}}/all" class="ui circular icon button" style="margin: 0 0.2rem !important">
                                            <i class="icon eye"></i>
                                        </a>
                                        <div class="or"></div>
                                        <a href="{{$data['alias']}}/cu/update" class="ui circular icon button" style="margin: 0 0.2rem !important">
                                        <i class="icon upload"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="column dashboard__overview__data">
                                <h3 class="ui header center aligned">{{$data['name']}}</h3>
                                <p class="ui basic segment center aligned">{{$data['count']}}</p>
                                @foreach ($data['labels'] as $label)
                                    <p title="{{$label['desc']}}" class="ui small basic grey label">
                                        <i class="medium {{$label['icon']}} icon"></i> {{$label['count']}}
                                    </p>
                                @endforeach
                            </div>
                        </article>
                    </div>
                @endforeach


                
            </div>
        </div>
    </section>

    <section class="dashboard__stats ui one column grid">
        <div class="ui text menu column">
            <h2 class="item">Lorem ipsum</h2>
        </div>

        <div class="column">
            <p class="ui grey secondary segment column">
            </p>
        </div>
    </section>
@stop