@if ($state['c'] && $state['u'])
    <div class="item cu">
        <div class="ui large middle aligned buttons">
            <button class="ui button">
                <i class="icon upload"></i>
            </button>
            <div class="or"></div>
            <button class="ui button">
                <i class="icon edit"></i>
            </button>
        </div>
    </div>
@elseif ($state['c'] || $state['u'])
    <div class="item cu">
        <button class="ui large button">
            <i class="icon {{$state['c'] ? 'upload' : 'edit'}}"></i>
        </button>
    </div>
@endif
