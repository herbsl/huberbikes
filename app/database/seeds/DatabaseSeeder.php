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
		$this->call('CategoriesTableSeeder');
		$this->call('TypeTableSeeder');
		$this->call('CustomersTableSeeder');
		$this->call('UsersTableSeeder');		
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
	}
}


class CategoriesTableSeeder extends Seeder {
	public function run() {
		DB::table('categories')->delete();
		
		Category::create(array(
			'name' => 'Mountainbikes'
		));
		Category::create(array(
			'name' => 'Active Lifestyle'
		));
		Category::create(array(
			'name' => 'E-Bikes'
		));
	}
}


class CustomersTableSeeder extends Seeder {
	public function run() {
		DB::table('customers')->delete();
		
		Customer::create(array(
			'name' => 'Herren'
		));
		Customer::create(array(
			'name' => 'Damen'
		));
		Customer::create(array(
			'name' => 'Jugendliche'
		));
		Customer::create(array(
			'name' => 'Kinder'
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


class UsersTableSeeder extends Seeder {
	public function run() {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'lina@a-land.de',
            'password' => Hash::make('Pipp@0201')
        ));
    }
}
