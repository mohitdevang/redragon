<?php

$json = @file_get_contents('https://restcountries.com/v3.1/all?fields=name,cca2,idd');
if (! $json) {
    fwrite(STDERR, "Failed to fetch countries\n");
    exit(1);
}
$raw = json_decode($json, true);
$out = [];
foreach ($raw as $c) {
    $name = $c['name']['common'] ?? '';
    $iso = $c['cca2'] ?? '';
    $root = $c['idd']['root'] ?? '';
    $suffix = $c['idd']['suffixes'][0] ?? '';
    $dial = preg_replace('/\D/', '', $root.$suffix);
    if ($name && $iso && $dial) {
        $out[] = [$iso, $name, $dial];
    }
}
usort($out, fn ($a, $b) => strcmp($a[1], $b[1]));
$dir = __DIR__.'/data';
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}
file_put_contents($dir.'/countries.php', "<?php\n\nreturn ".var_export($out, true).";\n");
echo 'Wrote '.count($out)." countries\n";
