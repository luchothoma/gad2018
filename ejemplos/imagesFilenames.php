var imagesFilenames = <?php $out = array();
foreach (glob('images/pokemons_db/*.png') as $filename) {
    $p = pathinfo($filename);
    $out[] = $p['filename'];
}
echo json_encode($out); ?>;