<?php
/**
 * Simple app to list an overview of currently hosted apps.
 */

// Indexes refer to the internal Docker port
$domains = [
    9000 => 'jeroendn.nl',
    9001 => 'alpha.jeroendn.nl',
    9002 => 'beta.jeroendn.nl',
    9003 => 'gamma.jeroendn.nl',
    9004 => 'delta.jeroendn.nl',
    9005 => 'epsilon.jeroendn.nl',
    9006 => 'zeta.jeroendn.nl',
    9007 => 'eta.jeroendn.nl',
    9008 => 'theta.jeroendn.nl',
    9009 => 'iota.jeroendn.nl',
    9010 => 'kappa.jeroendn.nl',
    9011 => 'lambda.jeroendn.nl',
    9012 => 'mu.jeroendn.nl',
    9013 => 'nu.jeroendn.nl',
    9014 => 'xi.jeroendn.nl',
    9015 => 'omnicron.jeroendn.nl',
    9016 => 'pi.jeroendn.nl',
    9017 => 'rho.jeroendn.nl',
    9018 => 'sigma.jeroendn.nl',
    9019 => 'tau.jeroendn.nl',
    9020 => 'upsilon.jeroendn.nl',
    9021 => 'phi.jeroendn.nl',
    9022 => 'chi.jeroendn.nl',
    9023 => 'psi.jeroendn.nl',
    9024 => 'omega.jeroendn.nl',
];

foreach ($domains as $port => $domain) {

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
        <div>
            <p>
                <strong>Port:</strong><br>
                <?= $port ?><br>
            </p>
        </div>
    </details>
    <?php
}