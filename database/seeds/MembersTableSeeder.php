<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Member;

class MembersTableSeeder extends Seeder {

    public function run() {

        Member::create([
            'id' => 1,
            'charter' => '',
            'name' => 'Manuel',
            'last' => 'Robles Oretega',
            'bautizmoDate' => '2007-10-28',
            'birthdate' => '1976-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 2,
            'charter' => '',
            'name' => 'Maria Magdalena',
            'last' => 'Toruño Bolivar',
            'bautizmoDate' => '2014-07-12',
            'birthdate' => '1964-00-00',
            'phone' => '2777-4530',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 3,
            'charter' => '',
            'name' => 'Darwin',
            'last' => 'Coronado Moraga',
            'bautizmoDate' => '2013-04-13',
            'birthdate' => '2004-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 4,
            'charter' => '',
            'name' => 'Shyrley Tatiana',
            'last' => 'Mendez Lopez',
            'bautizmoDate' => '2013-04-13',
            'birthdate' => '2003-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 5,
            'charter' => '',
            'name' => 'Arellys',
            'last' => 'Alvarado Olivar',
            'bautizmoDate' => '2011-08-27',
            'birthdate' => '1992-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 6,
            'charter' => '',
            'name' => 'Lorenzo',
            'last' => 'Segura Mata',
            'bautizmoDate' => '2011-03-26',
            'birthdate' => '1992-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 7,
            'charter' => '',
            'name' => 'Etelvida',
            'last' => 'Gamboa Quesada',
            'bautizmoDate' => '2011-03-26',
            'birthdate' => '0000-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 8,
            'charter' => '',
            'name' => 'Johana de los Angeles',
            'last' => 'Moraga Herrera',
            'bautizmoDate' => '2011-03-25',
            'birthdate' => '0000-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 9,
            'charter' => '',
            'name' => 'Erasmo',
            'last' => 'Alvarado Olivar',
            'bautizmoDate' => '2010-12-25',
            'birthdate' => '1988-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 10,
            'charter' => '',
            'name' => 'Cinthia Pamela',
            'last' => 'Moraga Herrera',
            'bautizmoDate' => '2010-12-25',
            'birthdate' => '1985-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 11,
            'charter' => '',
            'name' => 'Guillermo',
            'last' => 'Vargas Pereira',
            'bautizmoDate' => '2009-09-12',
            'birthdate' => '1932-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 12,
            'charter' => '',
            'name' => 'Albertina',
            'last' => 'Mendoza Romero',
            'bautizmoDate' => '2009-09-12',
            'birthdate' => '1932-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 13,
            'charter' => '',
            'name' => 'Xiomara',
            'last' => 'Mendez Acosta',
            'bautizmoDate' => '2009-06-13',
            'birthdate' => '1976-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 14,
            'charter' => '',
            'name' => 'Maricela',
            'last' => 'Robles Toruño',
            'bautizmoDate' => '2007-06-30',
            'birthdate' => '1991-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 15,
            'charter' => '',
            'name' => 'Rosibel',
            'last' => 'Mata Aguero',
            'bautizmoDate' => '2008-05-24',
            'birthdate' => '1973-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 16,
            'charter' => '',
            'name' => 'Rosibel',
            'last' => 'Mata Aguero',
            'bautizmoDate' => '2008-05-24',
            'birthdate' => '1973-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 17,
            'charter' => '',
            'name' => 'Dayana',
            'last' => 'Espinoza Mata',
            'bautizmoDate' => '2008-05-24',
            'birthdate' => '1997-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 18,
            'charter' => '',
            'name' => 'Eysell',
            'last' => 'Acosta Sosa',
            'bautizmoDate' => '2002-11-23',
            'birthdate' => '1987-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 19,
            'charter' => '',
            'name' => 'Heysell',
            'last' => 'Lopez Torres',
            'bautizmoDate' => '0000-00-00',
            'birthdate' => '0000-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 20,
            'charter' => '',
            'name' => 'Evelin',
            'last' => 'Acosta Orosco',
            'bautizmoDate' => '2002-11-23',
            'birthdate' => '1985-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 21,
            'charter' => '',
            'name' => 'Roddy',
            'last' => 'Robles Navas',
            'bautizmoDate' => '0000-00-00',
            'birthdate' => '0000-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 22,
            'charter' => '',
            'name' => 'Juliet',
            'last' => 'Jimenez Arraya',
            'bautizmoDate' => '2005-11-26',
            'birthdate' => '1997-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 23,
            'charter' => '',
            'name' => 'Mileidy',
            'last' => 'Arraya López',
            'bautizmoDate' => '2011-11-26',
            'birthdate' => '1981-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 24,
            'charter' => '',
            'name' => 'Flor',
            'last' => 'Chevez Chavarria',
            'bautizmoDate' => '2006-01-07',
            'birthdate' => '1942-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 25,
            'charter' => '',
            'name' => 'Juliana',
            'last' => 'Herrera Trejos',
            'bautizmoDate' => '0000-00-00',
            'birthdate' => '1983-00-00',
            'phone' => '0000-0000',
            'cell' => '0000-0000',
            'email' => 'user@mail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
        Member::create([
            'id' => 26,
            'charter' => '',
            'name' => 'Anwar',
            'last' => 'Sarmiento Ramos',
            'bautizmoDate' => '2014-12-31',
            'birthdate' => '1982-09-22',
            'phone' => '2777-4435',
            'cell' => '8304-5030',
            'email' => 'anwarsadatsarmiento@hotmail.com',
            'token' => bcrypt('1'),
            'church_id' => 1
        ]);
    }

}
