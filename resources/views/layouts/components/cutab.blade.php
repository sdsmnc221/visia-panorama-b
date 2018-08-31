<h2 class="ui secondary pointing menu">
    <a href="/{{$h->string_trim_till(request()->path(), '/')}}create"
        class="item {{$DATA['active_tab'] === 'create' ? 'active' : ''}}">
        Ajout
    </a>
    <a href="/{{$h->string_trim_till(request()->path(), '/')}}update" 
        class="item {{$DATA['active_tab'] === 'update' ? 'active' : ''}}">
        Modification
    </a>
</h2>