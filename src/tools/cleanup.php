<?php declare(strict_types=1);
/**
 * @author Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2012 Nicolas CARPi
 * @see https://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */

namespace Elabftw\Services;

use function dirname;
use Elabftw\Exceptions\DatabaseErrorException;
use Elabftw\Exceptions\FilesystemErrorException;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

/**
 * This is used to find out if there are untracked files that should have been deleted
 * but were not deleted because of a bug fixed in 2.0.7
 */
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/config.php';

try {
    $uploadsDir = dirname(__DIR__, 2) . '/uploads';
    $UploadsCleaner = new UploadsCleaner(new Filesystem(new LocalFilesystemAdapter($uploadsDir)));
    $deleted = $UploadsCleaner->cleanup();
    printf("Deleted %d files\n", $deleted);
} catch (FilesystemErrorException | DatabaseErrorException $e) {
    echo $e->getMessage();
}
