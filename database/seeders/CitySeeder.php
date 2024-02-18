<?php

namespace Database\Seeders;

use App\Common\Models\City;
use App\Common\Models\Region;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'code' => '0100',
                'name' => 'Riyadh',
                'region_code' => '0001'
            ],
            [
                'code' => '0101',
                'name' => 'Diriyah',
                'region_code' => '0001'
            ],
            [
                'code' => '0102',
                'name' => 'Al-Kharj',
                'region_code' => '0001'
            ],
            [
                'code' => '0103',
                'name' => 'Dawadmi',
                'region_code' => '0001'
            ],
            [
                'code' => '0104',
                'name' => 'Al Majma\'ah',
                'region_code' => '0001'
            ],
            [
                'code' => '0105',
                'name' => 'Al-Quway\'iyah',
                'region_code' => '0001'
            ],
            [
                'code' => '0106',
                'name' => 'Wadi ad-Dawasir',
                'region_code' => '0001'
            ],
            [
                'code' => '0107',
                'name' => 'Al Aflaj',
                'region_code' => '0001'
            ],
            [
                'code' => '0108',
                'name' => 'Al Zulfi',
                'region_code' => '0001'
            ],
            [
                'code' => '0109',
                'name' => 'Shaqra',
                'region_code' => '0001'
            ],
            [
                'code' => '0110',
                'name' => 'Hotat Bani Tamim',
                'region_code' => '0001'
            ],
            [
                'code' => '0111',
                'name' => 'Afif',
                'region_code' => '0001'
            ],
            [
                'code' => '0112',
                'name' => 'As Sulayyil',
                'region_code' => '0001'
            ],
            [
                'code' => '0113',
                'name' => 'Dhurma',
                'region_code' => '0001'
            ],
            [
                'code' => '0114',
                'name' => 'Al-Muzahmiyya',
                'region_code' => '0001'
            ],
            [
                'code' => '0115',
                'name' => 'Rumah',
                'region_code' => '0001'
            ],
            [
                'code' => '0116',
                'name' => 'Thadig',
                'region_code' => '0001'
            ],
            [
                'code' => '0117',
                'name' => 'Huraymila',
                'region_code' => '0001'
            ],
            [
                'code' => '0118',
                'name' => 'Al Hariq',
                'region_code' => '0001'
            ],
            [
                'code' => '0119',
                'name' => 'Al-Ghat',
                'region_code' => '0001'
            ],
            [
                'code' => '0120',
                'name' => 'Marat',
                'region_code' => '0001'
            ],
            [
                'code' => '0121',
                'name' => 'Ad-Dilam',
                'region_code' => '0001'
            ],
            [
                'code' => '0122',
                'name' => 'Ar-Rein',
                'region_code' => '0001'
            ],
            [
                'code' => '0123',
                'name' => 'Mecca',
                'region_code' => '0002'
            ],
            [
                'code' => '0124',
                'name' => 'Jeddah',
                'region_code' => '0002'
            ],
            [
                'code' => '0125',
                'name' => 'Ta\'if',
                'region_code' => '0002'
            ],
            [
                'code' => '0126',
                'name' => 'Al Qunfudhah',
                'region_code' => '0002'
            ],
            [
                'code' => '0127',
                'name' => 'Al Lith',
                'region_code' => '0002'
            ],
            [
                'code' => '0128',
                'name' => 'Rabigh',
                'region_code' => '0002'
            ],
            [
                'code' => '0129',
                'name' => 'Al Jumum',
                'region_code' => '0002'
            ],
            [
                'code' => '0130',
                'name' => 'Khulays',
                'region_code' => '0002'
            ],
            [
                'code' => '0131',
                'name' => 'Al Kamil',
                'region_code' => '0002'
            ],
            [
                'code' => '0132',
                'name' => 'Al Khurmah',
                'region_code' => '0002'
            ],
            [
                'code' => '0133',
                'name' => 'Ranyah',
                'region_code' => '0002'
            ],
            [
                'code' => '0134',
                'name' => 'Turubah',
                'region_code' => '0002'
            ],
            [
                'code' => '0135',
                'name' => 'Maysan',
                'region_code' => '0002'
            ],
            [
                'code' => '0136',
                'name' => 'Al Muwayh',
                'region_code' => '0002'
            ],
            [
                'code' => '0137',
                'name' => 'Adhem',
                'region_code' => '0002'
            ],
            [
                'code' => '0138',
                'name' => 'Al-Ardiyat',
                'region_code' => '0002'
            ],
            [
                'code' => '0139',
                'name' => 'Bahrah',
                'region_code' => '0002'
            ],
            [
                'code' => '0140',
                'name' => 'Medina',
                'region_code' => '0003'
            ],
            [
                'code' => '0141',
                'name' => 'Yanbu',
                'region_code' => '0003'
            ],
            [
                'code' => '0142',
                'name' => 'Al-\'Ula',
                'region_code' => '0003'
            ],
            [
                'code' => '0143',
                'name' => 'Al Mahd',
                'region_code' => '0003'
            ],
            [
                'code' => '0144',
                'name' => 'Badr',
                'region_code' => '0003'
            ],
            [
                'code' => '0145',
                'name' => 'Khaybar',
                'region_code' => '0003'
            ],
            [
                'code' => '0146',
                'name' => 'Al Hinakiyah',
                'region_code' => '0003'
            ],
            [
                'code' => '0147',
                'name' => 'Al-Eis',
                'region_code' => '0003'
            ],
            [
                'code' => '0148',
                'name' => 'Wadi Al-Fara',
                'region_code' => '0003'
            ],
            [
                'code' => '0149',
                'name' => 'Buraidah',
                'region_code' => '0004'
            ],
            [
                'code' => '0150',
                'name' => 'Unaizah',
                'region_code' => '0004'
            ],
            [
                'code' => '0151',
                'name' => 'Ar Rass',
                'region_code' => '0004'
            ],
            [
                'code' => '0152',
                'name' => 'Al Mithnab',
                'region_code' => '0004'
            ],
            [
                'code' => '0153',
                'name' => 'Al Bukayriyah',
                'region_code' => '0004'
            ],
            [
                'code' => '0154',
                'name' => 'Al Badayea',
                'region_code' => '0004'
            ],
            [
                'code' => '0155',
                'name' => 'Asyah',
                'region_code' => '0004'
            ],
            [
                'code' => '0156',
                'name' => 'Al Nabhaniyah',
                'region_code' => '0004'
            ],
            [
                'code' => '0157',
                'name' => 'Uyun AlJiwa',
                'region_code' => '0004'
            ],
            [
                'code' => '0158',
                'name' => 'Riyadh Al Khabra',
                'region_code' => '0004'
            ],
            [
                'code' => '0159',
                'name' => 'Al Shimasiyah',
                'region_code' => '0004'
            ],
            [
                'code' => '0160',
                'name' => 'Aqlat Al-Soqour',
                'region_code' => '0004'
            ],
            [
                'code' => '0161',
                'name' => 'Dharya',
                'region_code' => '0004'
            ],
            [
                'code' => '0162',
                'name' => 'Dammam',
                'region_code' => '0005'
            ],
            [
                'code' => '0163',
                'name' => 'Al Ahsa',
                'region_code' => '0005'
            ],
            [
                'code' => '0164',
                'name' => 'Hafar al-Batin',
                'region_code' => '0005'
            ],
            [
                'code' => '0165',
                'name' => 'Jubail',
                'region_code' => '0005'
            ],
            [
                'code' => '0166',
                'name' => 'Qatif',
                'region_code' => '0005'
            ],
            [
                'code' => '0167',
                'name' => 'Khobar',
                'region_code' => '0005'
            ],
            [
                'code' => '0168',
                'name' => 'Khafji',
                'region_code' => '0005'
            ],
            [
                'code' => '0169',
                'name' => 'Ras Tanura',
                'region_code' => '0005'
            ],
            [
                'code' => '0170',
                'name' => 'Abqaiq',
                'region_code' => '0005'
            ],
            [
                'code' => '0171',
                'name' => 'Al Nairyah',
                'region_code' => '0005'
            ],
            [
                'code' => '0172',
                'name' => 'Qaryat al-Ulya',
                'region_code' => '0005'
            ],
            [
                'code' => '0173',
                'name' => 'Al-Adayd',
                'region_code' => '0005'
            ],
            [
                'code' => '0174',
                'name' => 'Al-Bayda',
                'region_code' => '0005'
            ],
            [
                'code' => '0175',
                'name' => 'Abha',
                'region_code' => '0006'
            ],
            [
                'code' => '0176',
                'name' => 'Khamis Mushait',
                'region_code' => '0006'
            ],
            [
                'code' => '0177',
                'name' => 'Bisha',
                'region_code' => '0006'
            ],
            [
                'code' => '0178',
                'name' => 'Al-Namas',
                'region_code' => '0006'
            ],
            [
                'code' => '0179',
                'name' => 'Muhayil',
                'region_code' => '0006'
            ],
            [
                'code' => '0180',
                'name' => 'Sarat Abidah',
                'region_code' => '0006'
            ],
            [
                'code' => '0181',
                'name' => 'Tathlith',
                'region_code' => '0006'
            ],
            [
                'code' => '0182',
                'name' => 'Rijal Almaa',
                'region_code' => '0006'
            ],
            [
                'code' => '0183',
                'name' => 'Ahad Rafidah',
                'region_code' => '0006'
            ],
            [
                'code' => '0184',
                'name' => 'Dhahran Al Janub',
                'region_code' => '0006'
            ],
            [
                'code' => '0185',
                'name' => 'Balqarn',
                'region_code' => '0006'
            ],
            [
                'code' => '0186',
                'name' => 'Al Majaridah',
                'region_code' => '0006'
            ],
            [
                'code' => '0187',
                'name' => 'Tanoma',
                'region_code' => '0006'
            ],
            [
                'code' => '0188',
                'name' => 'Tareeb',
                'region_code' => '0006'
            ],
            [
                'code' => '0189',
                'name' => 'Bariq',
                'region_code' => '0006'
            ],
            [
                'code' => '0190',
                'name' => 'Al-Barak',
                'region_code' => '0006'
            ],
            [
                'code' => '0191',
                'name' => 'Al-Harejah',
                'region_code' => '0006'
            ],
            [
                'code' => '0192',
                'name' => 'Al-Amwah',
                'region_code' => '0006'
            ],
            [
                'code' => '0193',
                'name' => 'Tabuk',
                'region_code' => '0007'
            ],
            [
                'code' => '0194',
                'name' => 'Al Wajh',
                'region_code' => '0007'
            ],
            [
                'code' => '0195',
                'name' => 'Duba',
                'region_code' => '0007'
            ],
            [
                'code' => '0196',
                'name' => 'Tayma',
                'region_code' => '0007'
            ],
            [
                'code' => '0197',
                'name' => 'Umluj',
                'region_code' => '0007'
            ],
            [
                'code' => '0198',
                'name' => 'Haql',
                'region_code' => '0007'
            ],
            [
                'code' => '0199',
                'name' => 'Al-Bidaa',
                'region_code' => '0007'
            ],
            [
                'code' => '0200',
                'name' => 'Ha\'il',
                'region_code' => '0008'
            ],
            [
                'code' => '0201',
                'name' => 'Baqaa',
                'region_code' => '0008'
            ],
            [
                'code' => '0202',
                'name' => 'Al-Ghazala',
                'region_code' => '0008'
            ],
            [
                'code' => '0203',
                'name' => 'Al Shinan',
                'region_code' => '0008'
            ],
            [
                'code' => '0204',
                'name' => 'Al Salimy',
                'region_code' => '0008'
            ],
            [
                'code' => '0205',
                'name' => 'Al Hait',
                'region_code' => '0008'
            ],
            [
                'code' => '0206',
                'name' => 'Sumiraa',
                'region_code' => '0008'
            ],
            [
                'code' => '0207',
                'name' => 'Al Shamly',
                'region_code' => '0008'
            ],
            [
                'code' => '0208',
                'name' => 'Mawqaq',
                'region_code' => '0008'
            ],
            [
                'code' => '0209',
                'name' => 'Arar',
                'region_code' => '0009'
            ],
            [
                'code' => '0210',
                'name' => 'Rafha',
                'region_code' => '0009'
            ],
            [
                'code' => '0211',
                'name' => 'Turaif',
                'region_code' => '0009'
            ],
            [
                'code' => '0212',
                'name' => 'Al-Uwyklyah',
                'region_code' => '0009'
            ],
            [
                'code' => '0213',
                'name' => 'Jizan',
                'region_code' => '0010'
            ],
            [
                'code' => '0214',
                'name' => 'Sabya',
                'region_code' => '0010'
            ],
            [
                'code' => '0215',
                'name' => 'Abu `Arish',
                'region_code' => '0010'
            ],
            [
                'code' => '0216',
                'name' => 'Samtah',
                'region_code' => '0010'
            ],
            [
                'code' => '0217',
                'name' => 'Al Harth',
                'region_code' => '0010'
            ],
            [
                'code' => '0218',
                'name' => 'Damad',
                'region_code' => '0010'
            ],
            [
                'code' => '0219',
                'name' => 'Al Reeth',
                'region_code' => '0010'
            ],
            [
                'code' => '0220',
                'name' => 'Baish',
                'region_code' => '0010'
            ],
            [
                'code' => '0221',
                'name' => 'Farasan',
                'region_code' => '0010'
            ],
            [
                'code' => '0222',
                'name' => 'Al Dayer',
                'region_code' => '0010'
            ],
            [
                'code' => '0223',
                'name' => 'Ahad al Masarihah',
                'region_code' => '0010'
            ],
            [
                'code' => '0224',
                'name' => 'Al Edabi',
                'region_code' => '0010'
            ],
            [
                'code' => '0225',
                'name' => 'Al Aridhah',
                'region_code' => '0010'
            ],
            [
                'code' => '0226',
                'name' => 'Al Darb',
                'region_code' => '0010'
            ],
            [
                'code' => '0227',
                'name' => 'Horoub',
                'region_code' => '0010'
            ],
            [
                'code' => '0228',
                'name' => 'Fifa',
                'region_code' => '0010'
            ],
            [
                'code' => '0229',
                'name' => 'At Tuwal',
                'region_code' => '0010'
            ],
            [
                'code' => '0230',
                'name' => 'Najran',
                'region_code' => '0011'
            ],
            [
                'code' => '0231',
                'name' => 'Sharurah',
                'region_code' => '0011'
            ],
            [
                'code' => '0232',
                'name' => 'Hubuna',
                'region_code' => '0011'
            ],
            [
                'code' => '0233',
                'name' => 'Badr Al Janub',
                'region_code' => '0011'
            ],
            [
                'code' => '0234',
                'name' => 'Yadamah',
                'region_code' => '0011'
            ],
            [
                'code' => '0235',
                'name' => 'Thar',
                'region_code' => '0011'
            ],
            [
                'code' => '0236',
                'name' => 'Khubash',
                'region_code' => '0011'
            ],
            [
                'code' => '0237',
                'name' => 'Al Bahah',
                'region_code' => '0012'
            ],
            [
                'code' => '0238',
                'name' => 'Baljurashi',
                'region_code' => '0012'
            ],
            [
                'code' => '0239',
                'name' => 'Al Mandaq',
                'region_code' => '0012'
            ],
            [
                'code' => '0240',
                'name' => 'Al Makhwah',
                'region_code' => '0012'
            ],
            [
                'code' => '0241',
                'name' => 'Al Aqiq',
                'region_code' => '0012'
            ],
            [
                'code' => '0242',
                'name' => 'Qilwah',
                'region_code' => '0012'
            ],
            [
                'code' => '0243',
                'name' => 'Al Qara',
                'region_code' => '0012'
            ],
            [
                'code' => '0244',
                'name' => 'Bani Hassan',
                'region_code' => '0012'
            ],
            [
                'code' => '0245',
                'name' => 'Ghamid Al-Zinad',
                'region_code' => '0012'
            ],
            [
                'code' => '0246',
                'name' => 'Al Hajrah',
                'region_code' => '0012'
            ],
            [
                'code' => '0247',
                'name' => 'Sakakah',
                'region_code' => '0013'
            ],
            [
                'code' => '0248',
                'name' => 'Qurayyat',
                'region_code' => '0013'
            ],
            [
                'code' => '0249',
                'name' => 'Dumat al-Jandal',
                'region_code' => '0013'
            ],
            [
                'code' => '0250',
                'name' => 'Tabarjal',
                'region_code' => '0013'
            ]
        ];

        foreach ($entries as $entry) {
            $region = Region::where('code', $entry['region_code'])->first();
            if (null !== $region) {
                $entry['region_id'] = $region->id;
                unset($entry['region_code']);
                City::firstOrCreate([
                    'name' => $entry['name']
                ], $entry);
            }
        }
    }
}
