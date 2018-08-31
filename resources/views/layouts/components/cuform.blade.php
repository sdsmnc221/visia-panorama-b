<?php
    use App\Providers\ComponentProviders\Form;
    use App\Providers\BNFServiceProvider;
    use App\Models\PanoramaStatsType;
    $form = new Form($DATA);
    $form_count = 0;
    // dd(BNFServiceProvider::search_author(['pseudonym' => 'Marie de France']));
?>

<script>
  let form = @json($form);
</script>

@if (!str_contains(request()->path(), 'datasets'))
    @switch(true)
        @case(str_contains(request()->path(), 'create'))
            <form class="ui form cu" method="POST" action="/create">
                <div class="item form__content">
                    <div class="equal width fields">
                        @foreach ($form->fields_data as $f)                    
                            <?php echo $form->render_field(['field' => $f]); ?>
                        @endforeach 
                    </div>
                </div>

                <div class="item form__btns">
                    <div class="ui right floated large middle aligned buttons">
                        <button class="ui button add" >
                            <i class="icon plus"></i>
                        </button>
                        <div class="or"></div>
                        <button class="ui button submit disabled primary" type="submit">
                            <i class="icon check"></i>
                        </button>
                    </div>
                </div>
            </form>
            @break

        @case(str_contains(request()->path(), 'update'))
            <form class="ui form cu" method="POST" action="/update">
                <div class="item form__content">
                    @foreach ($form->fields_values as $v)
                        <div class="equal width fields">
                            @foreach ($form->fields_data as $i=>$f)                    
                                @if ($i === 0)
                                    <?php echo $form->render_field(['field' => $f, 'value' => $v[$f], 'is_PK' => true]); ?>
                                @else
                                    <?php echo $form->render_field(['field' => $f, 'value' => $v[$f], 'is_PK' => false]);  ?>
                                @endif
                            @endforeach 
                        </div>
                    @endforeach
                </div>

                <div class="item form__btns">
                    <div class="ui right floated large middle aligned buttons">
                        <button class="ui button reset" >
                            <i class="icon undo"></i>
                        </button>
                        <div class="or"></div>
                        <button class="ui button submit primary" type="submit">
                            <i class="icon check"></i>
                        </button>
                    </div>
                </div>
            </form>
            @break

        @default
            @break
    @endswitch

@else 
    <?
        $categories = PanoramaStatsType::all();
    ?>
    @switch(true)
        @case(str_contains(request()->path(), 'create'))
            <form class="ui large form cu" method="POST" action="/create">
                <div class="item form__content">
                    <div class="fields">
                        <div class="eight wide field"> 
                            <label>Titre</label>
                            <input type="text" value="" name="name" required min="1">
                        </div>
                        <div class="eight wide field"> 
                            <label>Catégorie</label>
                            <div class="inline fields">
                                <div class="field">
                                    <input type="text" value="" name="name" disabled="" tabindex="-1" required min="1">
                                </div>
                                
                                <i class="right chevron icon"></i>

                                <div class="field">
                                    <div class="ui selection dropdown">
                                        <input type="hidden" name="category" value="" required>
                                        <i class="dropdown icon"></i>
                                        <div class="default text"></div>
                                        <div class="menu">
                                            @foreach ($categories as $c)
                                                <div class="item" data-cat="{{$c->category}}" data-value="{{$c->stats_type_id}}">{{$c->name}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>               
                    </div>

                    <div class="fields">
                        <div class="eight wide field"> 
                            <label>Description</label>
                            <input type="text" value="" name="description" required min="1">
                        </div>
                        <div class="eight wide field"> 
                            <label>Période</label>
                            <div class="inline fields">
                                <div class="field">
                                    <input type="number" value="" name="name" required min="1">
                                </div>
                                
                                <i class="right chevron icon"></i>

                                <div class="field">
                                    <input type="number" value="" name="name" required min="1">
                                </div>   
                            </div>
                        </div>               
                    </div>

                    <div class="fields">
                        <div class="eight wide field"> 
                            <label>Commentaire</label>
                            <input type="text" value="" name="comment" required min="1">
                        </div>
                        <div class="eight wide field"> 
                            <label>Import de données</label>
                            <div class="ui two column relaxed grid">
                                <div class="column form__btns">
                                    <label class="ui right labeled icon button upload" type="file" for="form__file">
                                        <input type="file" id="form__file" accept=".csv" required>
                                        <i class="upload icon"></i>
                                        Choisir un fichier...
                                    </label>
                                </div>

                                <div class="column">
                                    <div class="form__file__desc">Format accepté : CSV.</div> 
                                </div>
                                
                                
                            </div>
                        </div>               
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field form__file__toolbar">
                        <p class="ui secondary disabled segment">Toolbar</p>
                    </div>
                </div>

                <div class="fields">
                    <div class="sixteen wide field form__file__data">
                        <p class="ui secondary disabled segment">CSV</p>
                    </div>
                </div>

                <div class="item form__btns">
                    <div class="ui right floated large middle aligned buttons">
                        <button class="ui button reset" >
                            <i class="icon undo"></i>
                        </button>
                        <div class="or"></div>
                        <button class="ui button submit primary" type="submit">
                            <i class="icon check"></i>
                        </button>
                    </div>
                </div>
            </form>
            @break

        @case(str_contains(request()->path(), 'update'))
            <form class="ui form cu" method="POST" action="/update">
                <div class="item form__content">
                    @foreach ($form->fields_values as $v)
                        <div class="equal width fields">
                            @foreach ($form->fields_data as $i=>$f)                    
                                @if ($i === 0)
                                    <?php echo $form->render_field(['field' => $f, 'value' => $v[$f], 'is_PK' => true]); ?>
                                @else
                                    <?php echo $form->render_field(['field' => $f, 'value' => $v[$f], 'is_PK' => false]);  ?>
                                @endif
                            @endforeach 
                        </div>
                    @endforeach
                </div>

                <div class="item form__btns">
                    <div class="ui right floated large middle aligned buttons">
                        <button class="ui button reset" >
                            <i class="icon undo"></i>
                        </button>
                        <div class="or"></div>
                        <button class="ui button submit primary" type="submit">
                            <i class="icon check"></i>
                        </button>
                    </div>
                </div>
            </form>
            @break

        @default
            @break
    @endswitch

    @modal
    @endmodal
@endif