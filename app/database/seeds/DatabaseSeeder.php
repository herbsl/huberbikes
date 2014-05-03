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
		$this->call('TypeTableSeeder');
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


class TypeTableSeeder extends Seeder {
	public function run() {
		DB::table('types')->delete();
		
		Type::create(array(
			'name' => 'Größe',
		));
		Type::create(array(
			'name' => 'Farbe',
		));
		Type::create(array(
			'name' => 'Gänge',
		));
		Type::create(array(
			'name' => 'Rahmen',
		));
		Type::create(array(
			'name' => 'Gabel',
		));
		Type::create(array(
			'name' => 'Sattel',
		));
		Type::create(array(
			'name' => 'Sattelstütze',
		));
		Type::create(array(
			'name' => 'Vorbau',
		));
		Type::create(array(
			'name' => 'Lenker',
		));
		Type::create(array(
			'name' => 'Kurbel',
		));
		Type::create(array(
			'name' => 'Schaltwerk',
		));
		Type::create(array(
			'name' => 'Felge',
		));
		Type::create(array(
			'name' => 'Nabe',
		));
		Type::create(array(
			'name' => 'Reifen',
		));
		Type::create(array(
			'name' => 'Kassette',
		));
		Type::create(array(
			'name' => 'Gewicht',
		));
		Type::create(array(
			'name' => 'Laufrad',
		));
		Type::create(array(
			'name' => 'Bremsen',
		));
		Type::create(array(
			'name' => 'Kette',
		));
		Type::create(array(
			'name' => 'Steuersatz',
		));
		Type::create(array(
			'name' => 'Pedale',
		));
		Type::create(array(
			'name' => 'Kurbeln',
		));
		Type::create(array(
			'name' => 'Schalthebel',
		));
		Type::create(array(
			'name' => 'Umwerfer',
		));
		Type::create(array(
			'name' => 'Dämpfer',
		));
		Type::create(array(
			'name' => 'Gepäckträger',
		));
		Type::create(array(
			'name' => 'Tretlager',
		));
		Type::create(array(
			'name' => 'Scheinwerfer',
		));
		Type::create(array(
			'name' => 'Sonstiges',
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
