class Toolbar {
    constructor(el) {
        this.toolbar = $(el);
        this.init();
    }

    init() {
        this.initPagination();
        this.initFilter();
        this.initCSVFilter();
    }

    initPagination() {
        this.toolbar.pagination = this.toolbar.find('.pagination .ui.dropdown');
        this.toolbar.pagination.dropdown();

        this.toolbar.currentPage = this.toolbar.find('.current-page')[0];
        this.toolbar.menu = $(this.toolbar.currentPage).siblings('.menu');
        this.toolbar.pageNbs = this.toolbar.find('.item[data-tab^="page"]');
        this.toolbar.pageNbs.tab();
        this.toolbar.pageNbs.on('click', e => {
            $(this.toolbar.currentPage).html($(e.target).text());
        })
    }

    initFilter() {
        this.toolbar.filter.btn = this.toolbar.find('.filter');
        this.toolbar.filter.btn.popup({
            inline: true,
            hoverable: true
        });

        this.toolbar.filter.node = this.toolbar.filter.btn.parent();
        this.toolbar.filter.node.on('mouseover', e => {
            let btn = this.toolbar.filter.btn;
            btn.addClass('positive');
        });
        this.toolbar.filter.node.on('mouseout', e => {
            let btn = this.toolbar.filter.btn;
            btn.removeClass('positive');
        });

        this.toolbar.filter.criteria = Array.from(this.toolbar.find('.filter + .popup .grid .column'))
            .map(criterion => {
                return {
                    group: criterion,
                    master: $(criterion).find('.master'),
                    children: Array.from($(criterion).find('.child'))
                };
            });
        this.toolbar.filter.criteria.forEach((criterion, index) => {
            //Master checkbox's behaviours
            $(criterion.master).checkbox({
                //On checked : check all children checkboxes
                onChecked: () => {
                    criterion.children.forEach(child => {
                        $(child).checkbox('check');
                    })
                },
                //On unchecked : uncheck all children checkboxes
                onUnchecked: () => {
                    criterion.children.forEach(child => {
                        $(child).checkbox('uncheck');
                    })
                }
            });

            //Children checkboxes' behaviours
            criterion.children.forEach(child => {
                $(child).checkbox({
                    // Fire on load to set parent value
                    fireOnInit : true,
                    // Change parent state on each child checkbox change
                    onChange: e => {
                        let criteria = this.toolbar.filter.criteria[index],
                            allChecked = true,
                            allUnchecked = true;
                        // check to see if all other siblings are checked or unchecked
                        criteria.children.forEach(child => {
                            if ($(child).checkbox('is checked')) {
                                allUnchecked = false;
                            } else {
                                allChecked = false;
                            }
                        });
                        // set parent checkbox state, but dont trigger its onChange callback
                        if (allChecked) {
                            $(criteria.master).checkbox('set checked');
                        } else if (allUnchecked) {
                            $(criteria.master).checkbox('set unchecked');
                        } else {
                            $(criteria.master).checkbox('set indeterminate');
                        }
                    }
                });
            })
        });
        
        //AJAX
        this.toolbar.filter.btn.on('click', e => {
            e.preventDefault();
            this.toolbar.filter.criteria.forEach((criterion, index) => {
                ajax_data.filter_criteria[index].values = [];
                criterion.children.forEach(child => {
                    if ($(child).checkbox('is checked')) {
                        let _n = $(child).find('label').first().text(),
                            _v = $(child).find('input').first().attr('name'),
                            _value = {};
                        _value[_n] = _v;
                        ajax_data.filter_criteria[index].values.push(_value);
                    }
                });
            });
            let _data = {data: ajax_data},
                url = window.location.href;
            url += url.charAt(url.length-1) === '/' ? 'filter' : '/filter';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: _data,
                success: data => {
                    if (data.table) {
                        //Update table
                        let table = new DOMParser().parseFromString(data.table, 'text/html');
                        table = $(table).find('table');

                        //Bulk enable post-treatment ???
                        if (!_data.data.is_bulk) {
                            [...table.find('th'), ...table.find('td')]
                                .filter(col =>$ (col).find('input[type="checkbox"]').length > 0)
                                .forEach(col => $(col).remove());
                        }

                        $('table').html(table.html());

                        //Update pagination
                        this.updatePagination();
                    } else {
                        console.log(data);
                    }
                }
            });
        })
        
    }

    initCSVFilter() {
        this.toolbar.csv = {};
        this.toolbar.csv.btns = {
            all: $('.button.csv__all'),
            positive: $('.button.csv__positive'),
            warning: $('.button.csv__warning'),
            negative: $('.button.csv__negative'),
            none: $('.button.csv__none'),
            logs: $('.button.csv__logs'),
        }

        this.toolbar.csv.data = {};
        this.toolbar.csv.logs = {};

        this.toolbar.csv.data.positive = Array.from($('table tr.positive'));
        this.toolbar.csv.data.warning = Array.from($('table tr.warning'));
        this.toolbar.csv.data.negative = Array.from($('table tr.negative'));
        this.toolbar.csv.data.none = Array.from($('table tr.none'));
    
        for (let type in this.toolbar.csv.btns) {
            this.toolbar.csv.btns[type].on('click', e => {
                e.preventDefault();
                this.csvFilter(type);
            });
        }
        
        console.log(this.toolbar.csv);

    }

    csvFilter(type) {
        if (_.values(_.pick(this.toolbar.csv.btns, ['positive', 'warning', 'negative']))
                .every(btn => !$(btn).hasClass('basic'))) {
            this.toolbar.csv.btns.all.removeClass('blue');
        } else {
            this.toolbar.csv.btns.all.addClass('blue');
        }
        
        switch(type) {
            case 'all':
                for (let type in _.pick(this.toolbar.csv.btns, ['positive', 'warning', 'negative'])) {
                    this.toolbar.csv.btns[type].removeClass('basic');
                    Array.from($('table tr')).forEach(tr => $(tr).removeClass('hide'));
                }
                break;
            case 'logs':
                break;
            default: 
                if (this.toolbar.csv.btns[type].hasClass('basic')) {
                    this.toolbar.csv.btns[type].removeClass('basic');
                    this.toolbar.csv.data[type].forEach(tr => $(tr).removeClass('hide'));
                } else {
                    this.toolbar.csv.btns[type].addClass('basic');
                    this.toolbar.csv.data[type].forEach(tr => $(tr).addClass('hide'));
                }
                break;
        }
    }



    updatePagination() {
        //Counting pages
        this.toolbar.pageNbs = Array.from($('table tbody')).length;
        //Update HTML
        $(this.toolbar.currentPage).html('1');
        let template = '';
        for (let i = 1; i <= this.toolbar.pageNbs; i++) {
            template += `<a class="${i === 1 ? 'active' : ''} item" data-tab="page-${i}"> ${i} </a>`; 
        }
        $(this.toolbar.menu).html(template);
        //Update behaviours
        this.toolbar.pageNbs = this.toolbar.find('.item[data-tab^="page"]');
        this.toolbar.pageNbs.tab();
        this.toolbar.pageNbs.on('click', e => {
            $(this.toolbar.currentPage).html($(e.target).text());
        })
    }
}

export { Toolbar }