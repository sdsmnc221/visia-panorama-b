import { CUModal } from './cumodal';
import { formatBytes, CSVtoJSON, checkCSV, apiCSV } from '../services/helper';

class CUForm {
    constructor(el) {
        this.form = $(el);
        this.init();
    }

    init() {
        this.form.content = this.form.find('.form__content').first();
        this.initFormBtns();
        this.initFormController();
        this.initModal();
    }

    initFormBtns() {
        this.form.btns = {}; //Array.from(this.form.find('.form__btns button'));
        this.initAddBtn();
        this.initResetBtn();
        this.initSubmitBtn();
        this.initUploadBtn();
        this.initOtherFields();
    }

    initDropdownFields() {
        Array.from(this.form.find('.ui.dropdown').dropdown());   
    }

    initAddBtn() {
        const fieldsTemplate = this.form.find('.fields').first().wrap('').parent().html();
        this.form.btns.add = this.form.find('.add').first();
        this.form.btns.add.on('mouseover', e => {
            $(e.target).removeClass('disabled').addClass('primary');
        });
        this.form.btns.add.on('mouseout', e => {
            $(e.target).removeClass('primary');
        });
        this.form.btns.add.on('click', e => {
            e.preventDefault();
            this.form.content.append(fieldsTemplate);
            this.initFormController();
        });
    }

    initResetBtn() {
        const fieldsTemplate = this.form.content.html();
        this.form.btns.reset = this.form.find('.reset').first();
        this.form.btns.reset.on('mouseover', e => {
            $(e.target).removeClass('disabled').addClass('primary');
        });
        this.form.btns.reset.on('mouseout', e => {
            $(e.target).removeClass('primary');
        });
        this.form.btns.reset.on('click', e => {
            e.preventDefault();
            this.form.content.html(fieldsTemplate);
            this.initFormController();
        });
    }

    initSubmitBtn() {
        this.form.btns.submit = this.form.find('.submit').first();

        if (!window.location.href.includes('datasets')) {
            this.form.btns.submit.popup({
                position: 'bottom left',
                target: '.form__content',
                context: '.form__content',
                content: 'N\'oubliez pas de remplir tous les champs !',
            });
    
            this.form.btns.submit.on('click', e => {
                e.preventDefault();
                let btn = $(e.target);
                $.when(btn.hasClass('disabled'))
                    .done(isBtnDisabled => {
                        if (!isBtnDisabled) this.callAjax(true);
                    });
                // if (!btn.hasClass('disabled')) {
                //     this.callAjax();
                // }
            });
        } else {
            this.form.btns.submit.on('click', e => {
                e.preventDefault();
                let btn = $(e.target);
                $.when(btn.hasClass('disabled'))
                    .done(isBtnDisabled => {
                        if (!isBtnDisabled) this.callAjax();
                    });
            });
        }
    }

    initUploadBtn() {
        this.form.btns.upload = this.form.find('.upload').first();
        this.form.btns.upload.desc = this.form.find('.form__file__desc').first();
        this.form.btns.upload.desc.default = this.form.btns.upload.desc.html(); 
        this.form.btns.upload.input = this.form.find('#form__file').first();
        this.form.btns.upload.output = this.form.find('.form__file__data').first();
        this.form.btns.upload.output.def = this.form.btns.upload.output.html();
        this.form.btns.upload.toolbar = this.form.find('.form__file__toolbar').first();
        this.form.btns.upload.toolbar.def = this.form.btns.upload.toolbar.html();
        this.form.btns.upload.on('mouseover', e => {
            $(e.target).addClass('primary');
        });
        this.form.btns.upload.on('mouseout', e => {
            $(e.target).removeClass('primary');
        });
        this.form.btns.upload.input.on('click', e => {
            this.form.btns.upload.toolbar.removeClass('loading hide').html(this.form.btns.upload.toolbar.def);
            this.form.btns.upload.output.removeClass('loading').html(this.form.btns.upload.output.def);
        })
        this.form.btns.upload.input.on('change', e => {
            let file = e.target.files[0],
                fileReader = new FileReader();
            file.desc = `<p>${file.name}</p>
                         <p>${formatBytes(file.size, 3)}</p>`;
            fileReader.onload = () => {
                let data = fileReader.result;
                if (checkCSV(data)) {
                    this.form.btns.upload.output.find('.segment').addClass('loading');
                    this.form.btns.upload.toolbar.find('.segment').addClass('loading');
                    console.log(data);
                    apiCSV(data, this.form.btns.upload.output, this.form.btns.upload.toolbar);
                }
            };
            fileReader.readAsText(file);
            this.form.btns.upload.desc.html(file.desc);
        });
    }

    initOtherFields() {
        //
    }

    initFormController() {
        //Quick workaround for create dataset form, will return to this later
        if (!window.location.href.includes('datasets')) {
            if (form.type === 'create') $(this.form.btns.submit).addClass('disabled');
            this.form.content.fields = Array.from(this.form.find('.fields'));
            this.form.content.inputs = Array.from(this.form.content.find('input'));
            this.form.content.inputs.forEach(input=> {
                $(input).on('keyup', e => {
                    let input = $(e.target),
                        hasBlankField = this.form.content.inputs.some(i => $(i).val().trim() === '');
                    if (hasBlankField) {
                        $(this.form.btns.submit).addClass('disabled');
                    } else {
                        $(this.form.btns.submit).removeClass('disabled');
                    }
                }); 
            });
        } 
        this.initDropdownFields();
    }

    initModal() {
        this.form.modal = new CUModal(this.form.next('.modal.onSuccess'));
    }


    callAjax(isDataset = false) {
        if (!isDataset) {
            console.log('l');
            let url = `/${form.what}`;
            form.data = this.collectData();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: form,
                success: data => {
                    console.log(data);
                    this.form.modal.launchModal(data);
                },
                error: error => {
                    console.log(error);
                }
            });
        } else {
            let url = `/${form.what}`;
            form.data = this.collectData(true);
            console.log(url);
            console.log(form.data);
        }
    }

    collectData(isDataset = false) {
        if (!isDataset) {
            return _.flattenDeep(this.form.content.fields.map(field => {
                return _.zipObject(form.fields_data, Array.from($(field).find('input'))
                    .map(input => $(input).val().trim()));
            }))
        } else {
            return 'toto';
        }
    }
}

export { CUForm };