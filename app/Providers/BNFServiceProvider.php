<?php 
namespace App\Providers;

class BNFServiceProvider {   
    public static function search_author($DATA) {
        $template = 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>
                     PREFIX isni: <http://isni.org/ontology#>
                     PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
                     SELECT ?author ?name ?concept $isni ?birth ?death
                     WHERE {
                        ?author foaf:name "%s".
                        ?author foaf:name ?name.
                        ?concept foaf:focus ?author.
                        ?concept skos:exactMatch $isni FILTER regex(?isni, "isni|wikidata", "i")
                    OPTIONAL {?author bio:birth ?birth.}
                    OPTIONAL {?author bio:death ?death.}
                    } 	
                    ORDER BY (?isni)';
        $url = sprintf(
                'http://data.bnf.fr/sparql?default-graph-uri=&query=%s%s', 
                preg_replace('/\++/', '+', urlencode(sprintf($template, $DATA['pseudonym']))),
                '&format=application%2Fsparql-results%2Bjson&timeout=0&should-sponge=&debug=on'
                
            );
        $response = collect(json_decode(file_get_contents($url), true));
        $response = collect($response->pull('results.bindings'));
        $response = $response
            ->transform(function($item, $key) {
                $item = collect($item)->transform(function($e, $k) {
                    return $e['value'];
                });
                $item['pseudonym'] = $item['name'];
                $item['id_author'] = '';
                $item['gender'] = '';
                $item['first_name'] = '';
                $item['last_name'] = '';
                $item['date_of_birth'] = '';
                $item['date_of_death'] = '';
                $item['img'] = '';
                $item['img_src'] = '';
                $item['id_bnf'] = str_replace_first('http://data.bnf.fr/ark:/12148/', '', $item['concept']);
                if (str_contains($item['isni'], 'wikidata')) {
                    $item['id_wikidata'] = str_replace_first('http://wikidata.org/entity/', '', $item['isni']);
                } else if (str_contains($item['isni'], 'isni')) {
                    $item['id_isni'] = str_replace_first('http://isni.org/isni/', '', $item['isni']);
                } else {
                    $item['id_wikidata'] = '';
                    $item['id_isni'] = '';
                }
                unset($item['author']);
                unset($item['concept']);
                unset($item['isni']);
                unset($item['name']);
                return $item;
            })
            ->reduce(function($carry, $item) {
                return $item->merge($carry);
            });
            
        
        return $response;
    }

    public static function search_works_by_author($DATA) {
        $template ='DEFINE input:same-as "yes" 
                    PREFIX dcterms: <http://purl.org/dc/terms/> 
                    PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
                    PREFIX rdarelationships: <http://rdvocab.info/RDARelationshipsWEMI/> 
                    PREFIX bnf-onto: <http://data.bnf.fr/ontology/bnf-onto/>
                    PREFIX dc: <http://purl.org/dc/elements/1.1/>
                    SELECT ?bnfId ?writer ?expression ?title ?manifestation ?gallica ?date
                    WHERE {
                    ?bnfId foaf:name "%s".
                    ?bnfId foaf:name ?writer.
                    ?expression dcterms:contributor ?bnfId.
                    ?manifestation dcterms:title ?title.
                    ?manifestation dcterms:date ?date.
                    ?manifestation rdarelationships:expressionManifested ?expression.
                    ?manifestation rdarelationships:electronicReproduction ?gallica.
                    } 
                    ORDER BY ASC(?date)
                    ';
        $url = sprintf(
            'http://data.bnf.fr/sparql?default-graph-uri=&query=%s%s', 
            preg_replace('/\+=/', '+', urlencode(sprintf($template, $DATA['pseudonym']))),
            '&format=application%2Fsparql-results%2Bjson&timeout=0&should-sponge=&debug=on');
        
        $response = collect(json_decode(file_get_contents($url), true));
        $response = collect($response->pull('results.bindings'));
        $response = $response
                    ->transform(function($item, $key) {
                        $item = collect($item)->transform(function($e, $k) {
                            return $e['value'];
                        });

                        $item['url'] = $item['gallica'];
                        $item['img'] = $item['gallica'].'/thumbnail';
                        unset($item['bnfId']);
                        unset($item['writer']);
                        unset($item['expression']);
                        unset($item['manifestation']);

                        return $item;
                    });
        $response = ['all' => $response];

        return ($response);
    }

    public static function search_author_img($DATA) {
        $template = 'SELECT distinct ?author ?img
                    WHERE { 
                    { ?wikiData rdfs:label "%s"@fr.}
                    { ?wikiData wdt:P18 ?img .} 
                    ?wikiData rdfs:label ?author filter (lang(?author) = "fr"). 
                    } 
                    ORDER BY DESC(?img)';
        $url = sprintf(
            'https://query.wikidata.org/sparql?format=json&query=%s', 
            preg_replace('/\+=/', '+', urlencode(sprintf($template, $DATA['pseudonym'], urlencode($DATA['pseudonym'])))));

        $response = collect(json_decode(file_get_contents($url), true));
        $response = collect($response->pull('results.bindings'));
        $img = ['url' => collect($response->first())->pull('img.value'), 'src' => ''];
        $img['src'] = $img['url'] ? 'Wikidata' : '';

        return $img;

    }
}
?>