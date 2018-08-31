@extends ('layouts.master')
@include('layouts.content__common')

@section ('content')
    <div class="ui text menu">
        <h2 class="item">{{$DATA['name']}}</h2>
        
        @cubtn(['state' => $DATA['is_cu']])
        @endcubtn
    </div>
    

<?php
    use App\Providers\ComponentProviders\Table;
    use App\Providers\ComponentProviders\Toolbar;

    $expanded_cells = ['pseudonym', 'name', 'description', 'comment', 'details', 'category', 'src', 'img', 'date_begin', 'date_end'];
    $collapsed_cells = ['id', 'gender', 'is', 'year'];
    $center_cells = ['id', 'gender', 'date', 'is', 'year'];
    $table = new Table($DATA);
?>

@section ('ajax_data')
  <script>
    let ajax_data = @json($table->ajax_data);
  </script>
@show

@section ('toolbar')
  @if ($table->has_data && !$DATA['is_ajax']) 
    <? 
      $toolbar = new Toolbar($table, $DATA['filter_criteria']); 
    ?>
    <header class="toolbar ui menu">
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
                                    @foreach ($criterion['values'] as $value)
                                        <div class="item">
                                            <div class="ui child checkbox">
                                                {{$criterion['values']}}
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

</header>
  @endif
@show
 
@section ('table')
  @if ($table->has_data)  
    <table class="ui black fixed single line very compact selectable striped celled table">

      <thead>
        <tr>
          @if ($table->bulk_enable)
            <th class="collapsing collapsed center aligned">
              <div class="ui fitted slider checkbox">
                <input type="checkbox"> <label></label>
              </div>
            </th>
          @endif
          
          @foreach ($table->thead as $th)
            <th class="collapsing center aligned has-data 
                {{str_contains($th, $expanded_cells) ? 'expanded' : 'collapsed'}}"
                data-content="{{$th}}"> {{$th}} </th>
          @endforeach
        </tr>
      </thead>

      @foreach($table->pages as $index=>$page)
        <tbody class="ui tab {{$index === 0 ? 'active' : ''}}" data-tab="page-{{$index+1}}">
          @foreach($page as $datum)
            <tr>
              @if ($table->bulk_enable)
              <td class="collapsing center aligned">
                <div class="ui fitted slider checkbox">
                  <input type="checkbox"> <label></label>
                </div>
              </td>
              @endif

              @foreach ($table->thead as $key)
                @if ($datum->$key)
                  <td class="has-data {{str_contains($key, $center_cells) ? 'center aligned' : ''}}" 
                      data-content="{{$datum->$key}}">  
                      @switch($table->ajax_data['model'])
                        @case('PanoramaDataset')
                          @if ($key === 'name') 
                            <a href="{{URL::to('datasets/'.$datum->dataset_id)}}">{{$datum->$key}}</a>
                            @break
                          @endif
                        @default
                          {{$datum->$key}} 
                      @endswitch 
                  </td>
                @else
                  <td class="disable"></td>
                @endif
              @endforeach  
            </tr>  
          @endforeach
        </tbody>
      @endforeach
    </table>

  @else
    <table class="ui orange large padded fixed table">
      <tr>
        <td class="center aligned error">Vous avez tout cassé… Je ne vous félicite pas.</td>
      </tr>
    </table>  
  @endif
@show
 


@stop