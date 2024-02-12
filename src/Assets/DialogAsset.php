<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Widgets\Assets;

use Yiisoft\Assets\AssetBundle;

use const DIRECTORY_SEPARATOR;

class DialogAsset extends AssetBundle
{
    public ?string $basePath = '@assets';
    public ?string $baseUrl = '@assetsUrl';
    public array $css = [
        'dialog/dialog.css',
    ];
    public array $js = [
        'dialog/dialog.js',
    ];
    public ?string $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';
}
