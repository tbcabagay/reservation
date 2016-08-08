<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Package;
use app\models\PackageItem;
use app\models\MenuCategory;
use app\models\MenuPackage;
use app\models\MenuItem;

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

    public function actionMenuCategory()
    {
        $categories = ['Appetizer', 'Salad', 'Soup', 'Main Course', 'Pasta', 'Dessert', 'Beverage'];
        foreach ($categories as $category) {
            $model = new MenuCategory();
            $model->setAttribute('category', $category);
            $model->save();
        }
    }

    public function actionMenuPackage()
    {
        $menuPackages = [
            ['Package 1', 650, 'person'],
            ['Package 2', 750, 'person'],
            ['Package 3', 850, 'person'],
            ['Package 4', 950, 'person'],
        ];
        foreach ($menuPackages as $menuPackage) {
            $model = new MenuPackage([
                'title' => $menuPackage[0],
                'amount' => $menuPackage[1],
                'unit' => $menuPackage[2],
            ]);
            $model->save();
        }
    }

    public function actionMenuItem()
    {
        $menuItems = [
            [1, 1, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [1, 2, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [1, 3, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [1, 3, 'Cheese Stick'],
            [1, 4, 'Tinapa Samosa', '(Flaked tinapa stuffed with vermicelli)'],
            [1, 4, 'Assorted Canape'],
        ];
        foreach ($menuItems as $menuItem) {
            $model = new MenuItem([
                'menu_category_id' => $menuItem[0],
                'menu_package_id' => $menuItem[1],
                'title' => $menuItem[2],
                'description' => isset($menuItem[3]) ? $menuItem[3] : null,
            ]);
            $model->save();
        }
    }
}