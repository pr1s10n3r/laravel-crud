<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Mascarilla de alta eficacia',
            'description' => 'Estas mascarillas contienen un filtro de micropartículas, gracias al cual protegen al que la lleva puesta frent a la inhalación de determinados contaminantes en el ambiente, como agentes patógenos, químicos, antibióticos... aunque no protegen frente a gases ni vapores.',
            'price' => 12750,
            'image' => 'm_efi.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarillas quirúrgicas',
            'description' => 'Este otro tipo sirve para evitar la transmisión de agentes infecciosos por parte de la persona que la lleva puesta, por lo tanto, se recomienda su uso en personas diagnosticadas con coronavirus, para minimizar que contagien a las personas que puedan acercarse, aunque igual que las anteriores son una pieza no hermética.',
            'price' => 20000,
            'image' => 'm_qui.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarillas higiénicas no reutilizables',
            'description' => 'son las que se rigen por la especificación UNE 0064-1 y UNE 0064-2, la primera para adultos y la segunda para niños.',
            'price' => 4200,
            'image' => 'm_nreu.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarillas higiénicas reutilizables',
            'description' => 'son las que se rigen por la especificación UNE 0065 y existen tanto para adultos como para niños.',
            'price' => 5000,
            'image' => 'm_reu.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Gel Desinfectante',
            'description' => 'El alcohol en gel, también conocido como gel antiséptico, gel desinfectante, gel de alcohol,  o gel limpiador bactericida, es un producto antiséptico que se emplea como alternativa al agua y el jabón para lavarse las manos.',
            'price' => 9000,
            'image' => 'gel_desinfectante.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Gel Antibacterial',
            'description' => 'Estas mascarillas contienen un filtro de micropartículas, gracias al cual protegen al que la lleva puesta frent a la inhalación de determinados contaminantes en el ambiente, como agentes patógenos, químicos, antibióticos... aunque no protegen frente a gases ni vapores.',
            'price' => 12750,
            'image' => 'gel_antibacterial.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Gel 1 Litro',
            'description' => 'Alcohol en Gel Sanitizante. Presentación de 1 litro. NOM-018-STPS-2015, varias normas y certificados. Cumple con las normas exigidas por la OMS.',
            'price' => 7000,
            'image' => 'gel_litro.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarilla KN-95',
            'description' => 'Respirador anti-particulas importado. Certificado KN95.',
            'price' => 32000,
            'image' => 'm_kn95.jpg'
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarilla Y-1826',
            'description' => 'Tela SMS. 100% polipropileno. 3 capas de 35 grs. Repelente al agua. Hipoalergénica.',
            'price' => 12000,
            'image' => 'm_y1826.jpg',
        ]);

        DB::table('products')->insert([
            'name' => 'Mascarilla PUB-1826',
            'description' => 'Tela SMS. 100% polipropileno. 2 capas de 20 grs y 1 intermedia de 20 grs. Repelente al agua. Hipoalergénica.',
            'price' => 6000,
            'image' => 'm_pub1826.jpg'
        ]);
    }
}
