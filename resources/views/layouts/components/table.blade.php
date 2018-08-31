<?php
    use App\Providers\ComponentProviders\Table;

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
    @toolbar (['table' => $table, 'filter_criteria' => $DATA['filter_criteria']])
    @endtoolbar
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
            <th class="collapsing center aligned has-data" data-content="{{$th}}"> {{$th}} </th>
            <!-- <th class="collapsing center aligned has-data 
                {{str_contains($th, $expanded_cells) ? 'expanded' : 'collapsed'}}"
                data-content="{{$th}}"> {{$th}} </th> -->
          @endforeach
        </tr>
      </thead>

      @foreach($table->pages as $index=>$page)
        <tbody class="ui tab {{$index === 0 ? 'active' : ''}}" data-tab="page-{{$index+1}}">
          @foreach($page as $datum)
            @if (array_key_exists('status', $datum->toArray()))
              @if ($datum->get('status')['is_updated'])
                @switch ($datum->get('status')['updated_w'])
                  @case('id_author')
                  @case('id_isni')
                  @case('id_bnf')
                  @case('id_wikidata')
                    <tr class="positive">
                    @break
                  @case('pseudonym')
                    <tr class="warning">
                    @break
                  @case('api')
                    <tr class="negative">
                    @break
                  @default
                    @break
                @endswitch
              @else
                <tr class="none">
              @endif
            @else
              <tr>
            @endif
              @if ($table->bulk_enable)
              <td class="collapsing center aligned">
                <div class="ui fitted slider checkbox">
                  <input type="checkbox"> <label></label>
                </div>
              </td>
              @endif

              @foreach ($table->thead as $key)
                @if (array_key_exists('not_eloquent', $DATA))
                  <!-- CSV -->
                  <td class="has-data {{str_contains($key, $center_cells) ? 'center aligned' : ''}}" 
                        data-content="{{$datum->get($key)}}">  
                        {{$datum->get($key)}} 
                  </td>
                @else
                <!-- Non-CSV -->
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