<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-06 20:54:35
 */

namespace Diepxuan\Catalog\OAuth\KeyStore;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileKeyStore extends KeyStore
{
    public string $disk = 'local';

    public string $path = 'magento_oauth_keys';

    public function get(string $connection): array
    {
        $content = Storage::disk($this->disk)->get($this->path . '/' . $connection . '.json') ?? '';

        return json_decode($content, true) ?? [];
    }

    public function set(string $connection, array $data): void
    {
        $storage = Storage::disk($this->disk);

        File::ensureDirectoryExists($storage->path($this->path));

        if ($encoded = json_encode($data)) {
            Storage::disk($this->disk)->put($this->path . '/' . $connection . '.json', $encoded, 'private');
        }
    }
}
