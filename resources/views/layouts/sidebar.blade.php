<nav class="app__sidebar three wide column ui black sticky fixed secondary vertical pointing menu">
    <div class="item">
        <a href="/" title="{{config('app.name')}}">
            <img class="ui centered tiny image" src="{{ asset('/') }}img/common/logo.svg" alt="{{config('app.name')}}">
        </a>
        <div class="ui divider"></div>
    </div>

    <ul class="item ui list">
        <li class="{{ $is_active['dashboard'] ? 'active' : '' }} item">
            <a href="/" title="Dashboard">
                <i class="circular fitted inverted home icon"></i>Dashboard
            </a>
        </li>
        <div class="ui divider"></div>
        <li class="item">
            <span><i class="circular fitted inverted users icon"></i>Auteurs</span>
            <ul class="menu list">
                <li class="{{ $is_active['authors/all'] ? 'active' : '' }} item">
                    <a href="/authors" title="Tous les auteurs">
                        <i class="circular fitted inverted list ul icon"></i> Tous les auteurs
                    </a>
                </li>
            </ul>
        </li>
        <div class="ui divider"></div>

        <li class="item">
            <span><i class="circular fitted inverted database icon"></i>Jeux de données</span>
            <ul class="menu list">
                <li class="{{ $is_active['datasets/all'] ? 'active' : '' }} item">
                    <a href="/datasets/" title="Tous les jeux de données">
                        <i class="circular fitted inverted list ul icon"></i> Tous les jeux de données
                    </a>
                </li>
                <li class="ui dropdown item {{$is_active['datasets/create_update'] ? 'active' : '' }}">
                        <span><i class="circular fitted inverted upload icon"></i> Ajouter / Mettre à jour</span>
                        <ul class="menu list">
                            <li><a href="/datasets/create" title="Ajouter les jeux de données" class="item">
                                <i class="circular fitted inverted upload icon"></i> Ajouter des jeux de données
                            </a></li>
                            <li><a href="/datasets/update" title="Mettre à jour des jeux de données" class="item">
                                <i class="circular fitted inverted edit icon"></i> Mettre à jour les jeux de données
                            </a></li>
                        </ul>         
                </li>
            </ul>
        </a></li>
        <div class="ui divider"></div>

        <li class="item">
            <span><i class="circular fitted inverted database icon"></i>Catégories</span>
            <ul class="menu list">
                <li class="{{ $is_active['categories/all'] ? 'active' : '' }} item">
                    <a href="/categories" title="Toutes les catégories">
                        <i class="circular fitted inverted list ul icon"></i> Toutes les catégories
                    </a>
                </li>

                <li class="ui dropdown item {{$is_active['categories/cu'] ? 'active' : '' }}">
                        <span><i class="circular fitted inverted upload icon"></i> Ajouter / Mettre à jour</span>
                        <ul class="menu list">
                            <li><a href="/categories/cu/create" title="Ajouter des catégories" class="item">
                                <i class="circular fitted inverted upload icon"></i> Ajouter des catégories
                            </a></li>
                            <li><a href="/categories/cu/update" title="Mettre à jour les catégories" class="item">
                                <i class="circular fitted inverted edit icon"></i> Mettre à jour les catégories
                            </a></li>
                        </ul>         
                </li>
            </ul>
        </li>
    </ul>
</nav>


