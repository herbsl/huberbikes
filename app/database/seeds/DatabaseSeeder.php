<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ManufacturersTableSeeder');
		//$this->call('BikesTableSeeder');
		$this->call('CategoriesTableSeeder');
		//$this->call('BikeCategoryTableSeeder');
	}
}


class ManufacturersTableSeeder extends Seeder {
	public function run() {
		DB::table('manufacturers')->delete();
		
		Manufacturer::create(array(
			'name' => 'Simplon'
		));
		Manufacturer::create(array(
			'name' => 'Merida'
		));
		Manufacturer::create(array(
			'name' => 'Focus'
		));
		Manufacturer::create(array(
			'name' => 'Victoria'
		));
		Manufacturer::create(array(
			'name' => 'Kalkhoff'
		));
	}
}


class BikesTableSeeder extends Seeder {
	public function run() {
		DB::table('bikes')->delete();
		
		Bike::create(array(
			'name' => 'Zion',
			'description' => 'Dieses Bike besticht mit durchdachten Lösungen',
			'price' => 1169.00,
			'manufacturer_id' => 1
		));

		Bike::create(array(
			'name' => 'Lexx XTE',
			'description' => 'Steile Auf- und Abfahrten, Wurzelpassagen oder Schlammwege. Mag alles außer gewöhnlich.',
			'price' => 2399.00,
			'price_offer' => 1999.00,
			'manufacturer_id' => 1
		));

		Bike::create(array(
			'name' => 'Superbud',
			'description' => 'Der Einsteiger von FOCUS in die Suspension-Welt ist ein echter Hingucker.',
			'price' => 749,
			'manufacturer_id' => 3
		));

		Bike::create(array(
			'name' => 'Thunder Expert',
			'description' => 'Verschiebe deine Grenzen!',
			'price' => 1350,
			'manufacturer_id' => 3
		));

		Bike::create(array(
			'name' => 'BIG.NINE TFS 900-D',
			'description' => '',
			'price' => 1099,
			'manufacturer_id' => 2
		));

		Bike::create(array(
			'name' => 'BIG.NINE TFS XT-D',
			'description' => '',
			'price' => 1149,
			'manufacturer_id' => 2
		));

		Bike::create(array(
			'name' => 'Black Raider 2.0',
			'description' => 'Limitierte Sonderedition',
			'price' => 1399,
			'manufacturer_id' => 3
		));
	}
}


class CategoriesTableSeeder extends Seeder {
	public function run() {
		DB::table('categories')->delete();
		
		Category::create(array(
			'name' => 'Mountain'
		));
		Category::create(array(
			'name' => 'Active'
		));
		Category::create(array(
			'name' => 'Elektro'
		));
		Category::create(array(
			'name' => 'Kinder'
		));
		Category::create(array(
			'name' => 'Jugendliche'
		));
		Category::create(array(
			'name' => 'Damen'
		));
		Category::create(array(
			'name' => 'Herren'
		));
	}
}


class BikeCategoryTableSeeder extends Seeder {
	public function run() {
		DB::table('bike_category')->delete();
		
		BikeCategory::create(array(
			'bike_id' => 1,
			'category_id' => 1
		));

		BikeCategory::create(array(
			'bike_id' => 1,
			'category_id' => 7
		));

		BikeCategory::create(array(
			'bike_id' => 2,
			'category_id' => 1
		));
	}
}
