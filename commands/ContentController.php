<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Package;
use app\models\PackageItem;

class ContentController extends Controller
{
    public function actionPackage()
    {
        $packages = ['Casitas Premiere', 'Casitas De Luxe'];
        foreach ($packages as $package) {
            $model = new Package();
            $model->title = $package;
            $model->save();
        }
    }

    public function actionPackageItem()
    {
        $packageItems = [
            [1, 'One Bedroom Casitas', 3, 4500, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu vulputate elit. Duis mauris eros, venenatis quis tortor vitae, pretium hendrerit dui. Sed eget fermentum dui, at iaculis lorem. Integer maximus libero nec nisi congue vestibulum. Quisque mollis diam vitae nulla gravida malesuada. Sed blandit rhoncus dictum. Suspendisse hendrerit aliquet felis et interdum. Morbi ut justo id arcu egestas cursus. Nulla fringilla iaculis elementum. Phasellus vulputate tortor nisl, vel viverra dolor fringilla a. Morbi volutpat metus quis ipsum mattis rutrum. Mauris semper ipsum est, lacinia hendrerit quam blandit a. Aliquam tempus vehicula quam, in auctor tellus.'],
            [1, 'Two Bedroom Casitas', 2, 9000, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu vulputate elit. Duis mauris eros, venenatis quis tortor vitae, pretium hendrerit dui. Sed eget fermentum dui, at iaculis lorem. Integer maximus libero nec nisi congue vestibulum. Quisque mollis diam vitae nulla gravida malesuada. Sed blandit rhoncus dictum. Suspendisse hendrerit aliquet felis et interdum. Morbi ut justo id arcu egestas cursus. Nulla fringilla iaculis elementum. Phasellus vulputate tortor nisl, vel viverra dolor fringilla a. Morbi volutpat metus quis ipsum mattis rutrum. Mauris semper ipsum est, lacinia hendrerit quam blandit a. Aliquam tempus vehicula quam, in auctor tellus.'],
            [2, 'Room Rate', 6, 8200, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu vulputate elit. Duis mauris eros, venenatis quis tortor vitae, pretium hendrerit dui. Sed eget fermentum dui, at iaculis lorem. Integer maximus libero nec nisi congue vestibulum. Quisque mollis diam vitae nulla gravida malesuada. Sed blandit rhoncus dictum. Suspendisse hendrerit aliquet felis et interdum. Morbi ut justo id arcu egestas cursus. Nulla fringilla iaculis elementum. Phasellus vulputate tortor nisl, vel viverra dolor fringilla a. Morbi volutpat metus quis ipsum mattis rutrum. Mauris semper ipsum est, lacinia hendrerit quam blandit a. Aliquam tempus vehicula quam, in auctor tellus.'],
        ];
        foreach ($packageItems as $packageItem) {
            $model = new PackageItem([
                'package_id' => $packageItem[0],
                'title' => $packageItem[1],
                'quantity' => $packageItem[2],
                'rate' => $packageItem[3],
                'content' => $packageItem[4],
            ]);
            $model->scenario = PackageItem::SCENARIO_ADD;
            $model->save();
        }
    }
}