@extends ('layouts.master')

@section('title')
    Dashboard
@stop

@section('breadcrumb')
    <span class="section">Back-Office</span>
    <i class="right chevron icon divider"></i>
    <a class="active section">Dashboard</a>
@stop

@section ('content')
    <section class="dashboard__overview ui one column grid">
        <div class="ui text menu column">
            <h2 class="item">Récap des données</h2>
        </div>

        <div class="column">
            <div class="ui stackable three column stretched grid">

                <div class="column">
                    <article class="ui piled segment two column grid">
                        <div class="column">
                            <div class="ui grey label name">
                                <i class="huge users icon"></i>
                            </div>
                        </div>
                        <div class="column dashboard__overview__data">
                            <h3 class="ui header center aligned">Auteurs</h3>
                            <p class="ui basic segment center aligned">150</p>
                            <p class="ui small basic grey label">
                                <i class="medium venus icon"></i> 23
                            </p>
                        </div>
                    </article>
                </div>

                <div class="column">
                    <article class="ui piled segment two column grid">
                        <div class="column">
                            <div class="ui grey label name">
                                <i class="huge users icon"></i>
                            </div>
                        </div>
                        <div class="column dashboard__overview__data">
                            <h3 class="ui header center aligned">Jeux de données</h3>
                            <p class="ui basic segment center aligned">150</p>
                        </div>
                    </article>
                </div>

                <div class="column">
                    <article class="ui piled segment two column grid">
                        <div class="column">
                            <div class="ui grey label name">
                                <i class="huge users icon"></i>
                            </div>
                        </div>
                        <div class="column dashboard__overview__data">
                            <h3 class="ui header center aligned">Catégories</h3>
                            <p class="ui basic segment center aligned">150</p>
                        </div>
                    </article>
                </div>
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