<? 
    use App\Providers\BNFServiceProvider;
    use App\Models\PanoramaDatum;
    dd( BNFServiceProvider::search_works_by_author(['pseudonym' => 'George Sand']));
    // dd('toto');
?>