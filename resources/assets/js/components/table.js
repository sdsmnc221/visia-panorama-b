import { Toolbar } from './toolbar';

class Table {
    constructor(el, customToolbar = false) {
        this.table = $(el);
        this.init(customToolbar);
    }

    init(customToolbar) {
        this.table.toolbar = customToolbar ? new Toolbar(customToolbar): new Toolbar(this.table.prev('.toolbar'));
        this.initCellTooltip();
    }

    initCellTooltip() {
        this.table.cells = this.table.find('.has-data');
        this.table.cells.popup();
    }
}

export { Table };