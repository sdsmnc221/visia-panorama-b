//Import Classes & Services.
import { CUForm } from './components/cuform';
import { Sidebar } from './components/sidebar';
import { Table } from './components/table';


//Once document is ready, init the app (the book).
window.onload = () => {
    build();
};

function build() {
    //_app's core
    class App {
        constructor(el) {
            this.app = el;
            this.init();
        }

        init() {
            this.app.sidebar = new Sidebar(this.app.querySelector('.app__sidebar'));
            if (this.app.querySelector('table')) this.app.table = new Table(this.app.querySelector('table'));
            if (this.app.querySelector('.form.cu')) this.app.cuform = new CUForm(this.app.querySelector('.form.cu'));
        }
    }

    const _app = new App(document.querySelector('.app'));
    return _app;
};

