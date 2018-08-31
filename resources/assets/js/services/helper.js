import { Toolbar } from "../components/toolbar";
import { Table } from "../components/table";

function formatBytes(a, b) {
    if (0 == a) return '0 Bytes';
    var c = 1024,
        d = b || 2,
        e = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        f = Math.floor(Math.log(a) / Math.log(c));
    return parseFloat((a / Math.pow(c, f)).toFixed(d)) + ' ' + e[f]
}

function checkCSV(csv) {
    const keys = [
                    'data_id',
                    'dataset_id_FK',
                    'id_author',
                    'year',
                    'details',
                    'src',
                    'id_bnf',
                    'id_wikidata',
                    'id_isni',
                    'gender',
                    'pseudonym',
                    'first_name',
                    'last_name',
                    'date_of_birth',
                    'date_of_death'
                ],
           keysCSV = Papa.parse(csv).data[0];
    return _.isEqual(keys, keysCSV);
}

function CSVtoJSON(csv) {
    let json = {keys: [], data: [], raw: null};
    json.raw = Papa.parse(csv).data;
    json.keys = json.raw[0];

    json.raw.slice(1).forEach(d => {
        let _d = {};
        json.keys.forEach((k, i) => {
            _d[k] = d[i];
        });
        json.data.push(_d);
    });
    console.log(json);
    return json;
}

function apiCSV(csv, outputDiv, toolbarDiv) {
    let url = `/datasets/csv`,
        json = CSVtoJSON(csv);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {string: csv},
        success: data => {
            console.log(data);
            toolbarDiv.html(data.toolbar);
            outputDiv.html(data.table);
            new Table(outputDiv, toolbarDiv);
        },
        error: error => {
            console.log(error);
            toolbarDiv.addClass('hide');
            outputDiv.html(`<table class="ui orange large padded fixed table">
                                <tr>
                                <td class="center aligned error">Vous avez tout cassé… Je ne vous félicite pas.</td>
                                </tr>
                            </table>`
                          );
        }
    });
}

export {formatBytes, CSVtoJSON, checkCSV, apiCSV};