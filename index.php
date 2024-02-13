<?php

if (substr($_SERVER['HTTP_HOST'], -6) === '.local') {
    echo 'App cannot run on localhost';
    die;
}

$dirString = shell_exec('cd ../../ && ls');

$pattern = '/\b(?:https?:\/\/)?(?:[\w-]+\.)*\w[\w-]*(?:\.[a-z]{2,})+\b/';
preg_match_all($pattern, $dirString, $matches);
$urls = $matches[0];

?>

<?php foreach ($urls as $url): ?>
    <?php if (!str_contains($url, 'jeroendn.nl')) continue; ?>
    <details>
        <summary><strong><?= $url ?></strong> (<?= $composerName = shell_exec(sprintf("cd ../../%s/public_html/ && php -r 'echo json_decode(file_get_contents(\"composer.json\"))->name;'", $url)); ?>)</summary>
        <a href="https://<?= $url ?>" target="_blank">https://<?= $url ?></a>
	<br>
	<a href="http://<?= $url ?>" target="_blank">http://<?= $url ?></a>
        <div>
            <p>
                <strong>Composer description:</strong><br>
                <?= $composerName ?><br>
                <?= shell_exec(sprintf("cd ../../%s/public_html/ && php -r 'echo json_decode(file_get_contents(\"composer.json\"))->description;'", $url)); ?>
            </p>
            <?php
            $dirsString = shell_exec(sprintf('cd ../../%s/public_html/ && ls -A', $url));
            $dirs       = preg_split('/\s+/', $dirsString);
            ?>
            <p>
                <strong>Directories/Files</strong>
                <br>
                <?php foreach ($dirs as $dir): ?>
                    <?= $dir ?><br>
                <?php endforeach; ?>
            </p>
        </div>
    </details>
<?php endforeach; ?>