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

foreach ($domains as $port => $domain) { ?>
    <details>
        <?php $data = getComposerJson($domain); ?>
        <summary><?= (new CurlResponse("https://$domain"))->getStatusCodeSpan() ?> <strong><?= $domain ?></strong><?php if (isset($data['name'])): ?> (<?= $data['name']; ?>)<?php endif; ?></summary>
        <a href="https://<?= $domain ?>" target="_blank">https://<?= $domain ?></a>
        <br>
        <a href="http://<?= $domain ?>" target="_blank">http://<?= $domain ?></a>
        <div>
            <p>
                <strong>Composer description:</strong><br>
                <?= $data['name'] ?? null; ?><br>
                <?= $data['description'] ?? null; ?>
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

function getComposerJson($domain): array|false
{
    $url = "https://$domain/composer.json";

    $curlResponse = new CurlResponse($url);

    // Check for 404 (file not found)
    if ($curlResponse->getStatusCode() === 404) {
        echo '<span style="color:#F00;">File does not exist: ' . $url . '</span><br>';
        return false;
    }

    // Decode JSON data
    $data = json_decode($curlResponse->getResponse(), true); // The second parameter "true" makes it return an associative array

    // Check if JSON decoding was successful
    if ($data === null) {
        echo '<span style="color:#F00;">Error decoding JSON data from ' . $url . '</span><br>';
        return false;
    }

    return $data;
}

final class CurlResponse
{
    private int    $statusCode;
    private string $response;

    public function __construct(string $url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

        // Fetch JSON data from the URL
        $this->response = curl_exec($handle);

        $this->statusCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getStatusCodeSpan(): string
    {
        if ($this->statusCode === 0) return '';

        $color = match (substr($this->statusCode, 0, 1)) {
            '2'       => '#0F0',
            '4', '5'    => '#F00',
            default => '#777',
        };

        return '<span style="color: ' . $color . ';">' . $this->statusCode . '</span>';
    }

    public function getResponse(): string
    {
        return $this->response;
    }
}