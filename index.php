<?php

$domains = [
    'jeroendn.nl',
//    'alpha.jeroendn.nl',
    'beta.jeroendn.nl',
    'gamma.jeroendn.nl',
    'delta.jeroendn.nl',
    'epsilon.jeroendn.nl',
    'zeta.jeroendn.nl',
    'eta.jeroendn.nl',
    'theta.jeroendn.nl',
    'iota.jeroendn.nl',
    'kappa.jeroendn.nl',
    'lambda.jeroendn.nl',
    'mu.jeroendn.nl',
    'nu.jeroendn.nl',
    'xi.jeroendn.nl',
    'omnicron.jeroendn.nl',
    'pi.jeroendn.nl',
    'rho.jeroendn.nl',
    'sigma.jeroendn.nl',
    'tau.jeroendn.nl',
    'upsilon.jeroendn.nl',
    'phi.jeroendn.nl',
    'chi.jeroendn.nl',
    'psi.jeroendn.nl',
    'omega.jeroendn.nl',
];

foreach ($domains as $domain) {

    $url = "https://$domain/composer.json"; // Replace with the actual URL of your JSON file

    // Check if the file exists
    $header_response = @get_headers($url, 1);
    if (!isset($header_response[0]) || strpos($header_response[0], '404') !== false) {
        echo 'File does not exist: ' . $url . '<br>';
        continue;
    }

    // Fetch JSON data from the URL
    $jsonData = @file_get_contents($url);

    // Check if the data was fetched successfully
    if ($jsonData === false) {
        echo 'Error fetching data from ' . $url . '<br>';
        continue;
    }

    // Decode JSON data
    $data = json_decode($jsonData, true); // The second parameter "true" makes it return an associative array

    // Check if JSON decoding was successful
    if ($data === null) {
        echo 'Error decoding JSON data from ' . $url . '<br>';
        continue;
    }
    ?>
    <details>
        <summary><strong><?= $domain ?></strong> (<?= $composerName = $data['name']; ?>)</summary>
        <a href="https://<?= $domain ?>" target="_blank">https://<?= $domain ?></a>
        <br>
        <a href="http://<?= $domain ?>" target="_blank">http://<?= $domain ?></a>
        <div>
            <p>
                <strong>Composer description:</strong><br>
                <?= $composerName ?><br>
                <?= $data['description']; ?>
            </p>
        </div>
    </details>
    <?php
}