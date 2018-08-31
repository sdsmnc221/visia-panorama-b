class Sidebar {
    constructor(el) {
        this.sidebar = $(el);
        this.init();
    }

    init() {
        this.sidebar.dropdowns = Array.from(this.sidebar.find('.ui.dropdown'));
        this.sidebar.dropdowns.forEach(menu => {
            $(menu).dropdown({
                on: 'hover'
            });
        });
    }
}

export { Sidebar };