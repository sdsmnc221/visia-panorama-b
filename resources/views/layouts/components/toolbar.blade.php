<?
    use App\Providers\ComponentProviders\Toolbar;
    $toolbar = new Toolbar($table, $filter_criteria);
?>

<header class="toolbar ui menu">

    @if (!$table->is_csv)
    <!-- Filter !-->
    <div class="item">
        <form class="ui form" method="POST" action="/filter">
            <button type="submit" class="ui filter labeled basic icon button">
                <i class="filter icon"></i> Filtrer
            </button>
            <div class="ui fluid popup bottom left transition hidden" 
                style="min-width: {{$toolbar->m_filter['criteria_nb'] * $toolbar->m_filter['col_w']}}px !important;">
                <div class="ui {{$toolbar->m_filter['col_nb_lt']}} column relaxed divided grid">
                    @foreach ($toolbar->m_filter['criteria'] as $criterion)
                        <div class="column">
                            <div class="ui master checkbox header">
                                <input type="checkbox" name="{{$criterion['db_name']}}">
                                <label>{{$criterion['name']}}</label>
                            </div>
                            <div class="ui list">
                                @if (array_key_exists('values', $criterion))
                                    @foreach ($criterion['values'] as $value=>$name)
                                        <div class="item">
                                            <div class="ui child checkbox">
                                                <input type="checkbox" name="{{$name}}">
                                                <label>{{$value}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    <!-- Search !-->
    <div class="item">
        <div class="ui icon input">
            <i class="search icon"></i>
            <input type="text" placeholder="Rechercher">
        </div>
    </div>
    @endif

    @if ($table->is_csv)
    <!-- Logs ! -->
    <div class="item">
        <button class="ui blue basic button csv csv__logs">Logs</button>
    </div>

    <!-- CSV Filter ! -->
    <div class="item">
        <button class="ui blue button csv csv__all">Toutes les données</button>
        <span>mises à jour avec :</span>
        <button class="ui green button csv csv__positive">les IDs</button>
        <button class="ui yellow button csv csv__warning">le pseudonyme</button>
        <button class="ui red button csv csv__negative">l'API</button>
        <button class="ui grey button csv csv__none">rien</button>
    </div>
    @endif

    <!-- Pagination !-->
    <div class="right item">
        <div class="ui pagination menu">
            <a class="icon item previous">
                <i class="left chevron icon"></i>
            </a>
            <div class="ui menu">
                <div class="ui scrolling dropdown item">
                    <span class="current-page">1</span> <i class="dropdown icon"></i>
                    <div class="menu">
                        @for($index = 1; $index <= $toolbar->m_pagination['pages']; $index++)
                        <a class="{{$index === 1 ? 'active' : ''}} item" data-tab="page-{{$index}}"> {{$index}} </a>
                        @endfor
                    </div>
                </div>
            </div>
            <a class="icon item next">
                <i class="right chevron icon"></i>
            </a>
        </div>
    </div>
</header>

  