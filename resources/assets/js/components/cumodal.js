class CUModal {
    constructor(el) {
        this.modal = $(el);
        this.init();
    }

    init() { 
        this.modal.header = this.modal.find('.modal__header').first();
        this.modal.content = this.modal.find('.modal__content').first();
        this.modal.btns = {
            go: this.modal.find('.go.button').first(),
            stay: this.modal.find('.stay.button').first()
        };
        this.modal.btns.stay.on('click', e => {
            this.modal.modal('hide');
        }); 
    }

    launchModal(data) {
        const dict = {
                  gM: ['authors', 'datasets'],
                  n: {
                    authors: ['auteur.trice', 'auteur.trice.s'],
                    categories: ['catégories', 'catégorie'],
                  },
                  v: ['ont', 'a'],
                  aS: [
                        ['créé', 'modifié'], 
                        ['créée', 'modifiée']
                  ],
              },
              itemsNb = data.stored_items.length,
              isMany = itemsNb > 1 ? 0 : 1,
              isM = dict.gM.includes(data.what) ? 0 : 1,
              isCreate = data.type ? 0 : 1;
        this.modal.header
            .text(`${isCreate === 0 ? 'Ajout réussi !' : 'Modification réussie !'}`);
        this.modal.content.
            html(`<strong>${itemsNb} ${dict.n[data.what.replace(/\/cu/g, '')][isMany]}</strong> 
                  ${dict.v[isMany]} été ${dict.aS[isM][isCreate]}${isMany === 0 ? 's' : ''} !`);
        this.modal
            .modal({context: '.app__content'})
            .modal('show');
        this.modal.btns.go.on('click', e => {
            window.location = window.location.href.replace(/create|update/g, 'all');
        });
    }

}

export { CUModal };