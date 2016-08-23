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
use app\models\Spa;
use kartik\markdown\Markdown;

class ContentController extends Controller
{
    public function actionIndex()
    {
        $this->actionPackage();
        $this->actionPackageItem();
        $this->actionMenuCategory();
        $this->actionMenuPackage();
        $this->actionMenuItem();
        $this->actionSpa();
    }

    public function actionPackage()
    {
        $result = true;
        $premiere = '1. ALL CASITAS PREMIERE ARE **NON-SMOKING**.
2. CHILDREN 4 YEARS OLD AND BELOW AND NOT EXCEEDING 4FT. IN HEIGHT IS FREE (ACCOMMODATION WITHOUT EXTRA BED) MAXIMUM OF 2.';
        $deLuxe = '1. ALL CASITAS DE LUXE ROOMS ARE **NON-SMOKING**.
2. CHILDREN 4 YEARS OLD AND BELOW AND NOT EXCEEDING 4FT. IN HEIGHT IS FREE (ACCOMMODATION WITHOUT EXTRA BED) MAXIMUM OF 2.
3. EXTRA PERSON - PHP1,500.00 WITH BREAKFAST.
- *All rates are inclusive of Government taxes and 5% service charge*.
- *Check in time - 1:00PM*.
- *Check out time - 11AM*.
- *Bringing of food and drinks is not allowed*.
- *Pets are not allowed inside the resort*.
- *Check in guest is allowed to use the pool until 7:00PM*.
- *RATE ARE SUBJECT TO CHANGE WITHOUT PRIOR NOTICE*.';
        $packages = [
            ['Casitas Premiere', $premiere],
            ['Casitas De Luxe', $deLuxe],
        ];
        foreach ($packages as $package) {
            $model = new Package();
            $model->title = $package[0];
            $model->agreement = $package[1];
            $model->save();
        }
        if ($result) {
            echo 'Package ' . count($packages) . " records successfully saved\n";
        }
    }

    public function actionPackageItem()
    {
        $result = true;
        $packageItems = [
            [1, 'One Bedroom Casitas', 3, 4500, 3, 10, 1000, 200, '- Complimentary Breakfast for 2 Persons.
- Complimentary 1 - 1 Hour Massage.
- 10% Off on Food &amp; Beverage and Spa services.
- Room is good for 2 Persons.'],
            [1, 'Two Bedroom Casitas', 2, 9000, 5, 10, 1000, 200, '- Complimentary Breakfast for 4 Persons.
- Complimentary 2 - 1 Hour Massage.
- 10% Off on Food &amp; Beverage and Spa services.
- Room is good for 4 Persons.'],
            [2, 'Room Rate', 6, 8200, 10, 10, 1500, 200, '- Minimum Capacity of 6 Persons.
- Complimentary Breakfast for 4 Persons.
- Flat Screen TV, Cable Channels &amp; Lanai.
**ROOM LAYOUT:**
- Casitas F &amp; G - Ground Floor. 1 Queen Bed &amp; 1 Single Bed with One Toilet &amp; Bath.
- Casitas H, I, J &amp; K - Ground Floor. 3 Singles Beds Two Toilet &amp; Bath.
- All Casitas De Luxe has a Loft that can accommodate 6-8 Persons.'],
        ];
        foreach ($packageItems as $packageItem) {
            $model = new PackageItem([
                'package_id' => $packageItem[0],
                'title' => $packageItem[1],
                'quantity' => $packageItem[2],
                'rate' => $packageItem[3],
                'max_person_per_room' => $packageItem[4],
                'discount_rate' => $packageItem[5],
                'penalty_per_excess_person' => $packageItem[6],
                'penalty_per_excess_hour' => $packageItem[7],
                'content' => $packageItem[8],
            ]);
            $model->scenario = PackageItem::SCENARIO_COMMAND;
            $model->save();
        }
        if ($result) {
            echo 'Package Item ' . count($packageItems) . " records successfully saved\n";
        }
    }

    public function actionMenuCategory()
    {
        $result = true;
        $categories = ['Appetizer', 'Salad', 'Soup', 'Main Course', 'Pasta', 'Dessert', 'Beverage'];
        foreach ($categories as $category) {
            $model = new MenuCategory();
            $model->setAttribute('category', $category);
            $result = $result && $model->save();
        }
        if ($result) {
            echo 'Menu Category ' . count($categories) . " records successfully saved\n";
        }
    }

    public function actionMenuPackage()
    {
        $result = true;
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
            $result = $result && $model->save();
        }
        if ($result) {
            echo 'Menu Package ' . count($menuPackages) . " records successfully saved\n";
        }
    }

    public function actionMenuItem()
    {
        $result = true;
        $menuItems = [
            [1, 1, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [2, 1, 'Fruits and Greens Salad', '(Peach dressing and balsamic vinaigrette dressing)'],
            [3, 1, 'Sopa de Ajo', '(Spanish garlic soup with croutons)'],
            [4, 1, 'Pan Seared Fish Fillet with Mushroom Cream Sauce'],
            [4, 1, 'Chicken Chorizo', '(Chicken fillet stuffed with chorizo, onion and garlic)'],
            [4, 1, 'Pork Medallion', '(Roast pork loin with peach demi-glace sauce)'],
            [4, 1, 'Plain Rice'],
            [5, 1, 'Spaghetti Marinara with Meatballs'],
            [6, 1, 'Bread Butter Pudding'],
            [7, 1, '*Ice Tea'],
            [1, 2, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [2, 2, 'Fruits and Greens Salad', '(Peach dressing and balsamic vinaigrette dressing)'],
            [3, 2, 'Mix Mushroom Soup'],
            [4, 2, 'Pan Seared Fish Fillet with Red Sauce and Caramelized Onion'],
            [4, 2, 'Rotisserie Chicken', '(Roast whole chicken with lemon gravy sauce)'],
            [4, 2, 'Slow Roast Pork Belly', '(Roast pork belly with orange marmalade de glace sauce)'],
            [4, 2, 'Mix Vegetables'],
            [4, 2, 'Plain Rice'],
            [5, 2, 'Pasta Arabiata', '(Red sauce pasta tossed in olive, basil, bacon bits, and Parmesan cheese)'],
            [6, 2, 'Bread Butter Pudding'],
            [7, 2, '*Ice Tea'],
            [1, 3, 'Assorted Canape', '(Pork, Chicken and shrimp canape)'],
            [1, 3, 'Cheese Stick'],
            [2, 3, 'Fruits and Greens Salad', '(Peach dressing and balsamic vinaigrette dressing)'],
            [3, 3, 'Bacon Corn Chowder Soup'],
            [4, 3, 'Pan Seared Fish Fillet with Teriyaki Sauce'],
            [4, 3, 'Roast Whole Chicken', '(Roasted chicken with Thai basil cream)'],
            [4, 3, 'Baby Back Ribs', '(Smoked honey barbecue glazed ribs)'],
            [4, 3, 'Pot Roast Beef', '(Beef brisket marinated in red wine with mushroom cream sauce)'],
            [4, 3, 'Mix Vegetables'],
            [4, 3, 'Plain Rice'],
            [6, 3, 'Bread Butter Pudding'],
            [6, 3, 'Sanctuario Flan'],
            [7, 3, '*Ice Tea'],
            [1, 4, 'Tinapa Samosa', '(Flaked tinapa stuffed with vermicelli)'],
            [1, 4, 'Assorted Canape'],
            [2, 4, 'Fruits and Greens Salad', '(Peach dressing and balsamic vinaigrette dressing)'],
            [3, 4, 'Seafood Chower Soup'],
            [4, 4, 'Pan Seared Fish Fillet with Garlic Parsley Broth'],
            [4, 4, 'Rosemary Chicken', '(Roasted chicken with Thai rosemary cream)'],
            [4, 4, 'Roast Pork Belly', '(With barbecue sauce)'],
            [4, 4, 'Pot Roast Beef', '(Beef brisket marinated in red wine with mushroom cream sauce)'],
            [4, 4, 'Mix Vegetables'],
            [4, 4, 'Plain Rice'],
            [5, 4, 'Penne Pasta', '(Red sauce pasta tossed with shrimp)'],
            [6, 4, 'Bread Butter Pudding'],
            [6, 4, 'Creme Brulee'],
            [7, 4, '*Ice Tea'],
        ];
        foreach ($menuItems as $menuItem) {
            $model = new MenuItem([
                'menu_category_id' => $menuItem[0],
                'menu_package_id' => $menuItem[1],
                'title' => $menuItem[2],
                'description' => isset($menuItem[3]) ? $menuItem[3] : null,
            ]);
            $result = $result && $model->save(false);
        }
        if ($result) {
            echo 'Menu Item ' . count($menuItems) . " records successfully saved\n";
        }
    }

    public function actionSpa()
    {
        $result = true;
        $spas = [
            ['Body Massage', 450, 'Choices are: Swedish and Shiatsu'],
            ['Body Scrub', 750],
            ['Foot Reflexology', 300],
            ['Manicure/Pedicure', 300],
            ['Foot Spa', 300],
            ['Spa Pedicure', 400],
        ];
        foreach ($spas as $spa) {
            $model = new Spa([
                'title' => $spa[0],
                'amount' => $spa[1],
                'description' => isset($spa[2]) ? $spa[2] : null,
                'photo' => 'http://placehold.it/360x360',
            ]);
            $model->scenario = Spa::SCENARIO_COMMAND;
            $result = $result && $model->save();
        }
        if ($result) {
            echo 'Spa ' . count($spas) . " records successfully saved\n";
        }
    }
}