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
		Manufacturer::create(array(
			'name' => 'UMF'
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
		Category::create(array(
			'name' => 'Rennräder'
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
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Farbe',
			'keywords' => 'Farben, Farbe(n)'
		));
		Type::create(array(
			'name' => 'Gänge',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Rahmen',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Gabel',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Sattel',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Sattelstütze',
			'keywords' => 'Sattel-Stütze'
		));
		Type::create(array(
			'name' => 'Vorbau',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Lenker',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Lenkervorbau',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Kurbel',
			'keywords' => 'Kurbeln, Kurbel(n), Kurbelgarnitur, Kurbelsatz'
		));
		Type::create(array(
			'name' => 'Schaltwerk',
			'keywords' => 'Schaltung'
		));
		Type::create(array(
			'name' => 'Felge',
			'keywords' => 'Felgen, Felge(n)'
		));
		Type::create(array(
			'name' => 'Nabe',
			'keywords' => 'Naben, Nabe(n), Nabensatz, Nabe VR, Nabe HR'
		));
		Type::create(array(
			'name' => 'Reifen',
			'keywords' => 'Bereifung'
		));
		Type::create(array(
			'name' => 'Kassette',
			'keywords' => 'Ritzel, Zahnkranz'
		));
		Type::create(array(
			'name' => 'Gewicht',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Laufrad',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Bremse',
			'keywords' => 'Bremsen, Bremse(n), Bremsanlage, Bremse vorne, Bremse hinten'
		));
		Type::create(array(
			'name' => 'Kette',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Steuersatz',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Pedale',
			'keywords' => 'Pedalen, Pedale(n)'
		));
		Type::create(array(
			'name' => 'Schalthebel',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Umwerfer',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Dämpfer',
			'keywords' => 'Federbein'
		));
		Type::create(array(
			'name' => 'Gepäckträger',
			'keywords' => 'Träger'
		));
		Type::create(array(
			'name' => 'Schutzblech',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Antrieb',
			'keywords' => 'Motor, System'
		));
		Type::create(array(
			'name' => 'Motorleistung',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Batterie',
			'keywords' => 'Akku, Akkudaten'
		));
		Type::create(array(
			'name' => 'Reichweite (optimal)',
			'keywords' => 'Reichweite, Optimal'
		));
		Type::create(array(
			'name' => 'Tretlager',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Übersetzung',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Scheinwerfer',
			'keywords' => 'Beleuchtung, Lichtanlage'
		));
		Type::create(array(
			'name' => 'Rücklicht',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Innenlager',
			'keywords' => ''
		));
		Type::create(array(
			'name' => 'Sonstiges',
			'keywords' => ''
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
