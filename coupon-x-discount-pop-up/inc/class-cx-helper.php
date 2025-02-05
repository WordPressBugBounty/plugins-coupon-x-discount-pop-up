<?php
/**
 * Coupon X Fonts
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Helper functions
 */
class Cx_Helper
{


    /**
     * Predefined fonts.
     *
     * @return array of fonts
     */
    public static function couponx_fonts()
    {
        return [
            'Default'      => [
                'System stack',
                'Arial',
                'Tahoma',
                'Verdana',
                'Helvetica',
                'Times New Roman',
                'Trebuchet MS',
                'Georgia',
            ],
            'Google Fonts' => [
                'ABeeZee',
                'Abel',
                'Abhaya Libre',
                'Abril Fatface',
                'Aclonica',
                'Acme',
                'Actor',
                'Adamina',
                'Advent Pro',
                'Aguafina Script',
                'Akronim',
                'Aladin',
                'Aldrich',
                'Alef',
                'Alef Hebrew',
            // Hack for Google Early Access.
                'Alegreya',
                'Alegreya SC',
                'Alegreya Sans',
                'Alegreya Sans SC',
                'Alex Brush',
                'Alfa Slab One',
                'Alice',
                'Alike',
                'Alike Angular',
                'Allan',
                'Allerta',
                'Allerta Stencil',
                'Allura',
                'Almendra',
                'Almendra Display',
                'Almendra SC',
                'Amarante',
                'Amaranth',
                'Amatic SC',
                'Amethysta',
                'Amiko',
                'Amiri',
                'Amita',
                'Anaheim',
                'Andada',
                'Andika',
                'Angkor',
                'Annie Use Your Telescope',
                'Anonymous Pro',
                'Antic',
                'Antic Didone',
                'Antic Slab',
                'Anton',
                'Arapey',
                'Arbutus',
                'Arbutus Slab',
                'Architects Daughter',
                'Archivo',
                'Archivo Black',
                'Archivo Narrow',
                'Aref Ruqaa',
                'Arima Madurai',
                'Arimo',
                'Arizonia',
                'Armata',
                'Arsenal',
                'Artifika',
                'Arvo',
                'Arya',
                'Asap',
                'Asap Condensed',
                'Asar',
                'Asset',
                'Assistant',
                'Astloch',
                'Asul',
                'Athiti',
                'Atma',
                'Atomic Age',
                'Aubrey',
                'Audiowide',
                'Autour One',
                'Average',
                'Average Sans',
                'Averia Gruesa Libre',
                'Averia Libre',
                'Averia Sans Libre',
                'Averia Serif Libre',
                'Bad Script',
                'Bahiana',
                'Bai Jamjuree',
                'Baloo',
                'Baloo Bhai',
                'Baloo Bhaijaan',
                'Baloo Bhaina',
                'Baloo Chettan',
                'Baloo Da',
                'Baloo Paaji',
                'Baloo Tamma',
                'Baloo Tammudu',
                'Baloo Thambi',
                'Balthazar',
                'Bangers',
                'Barlow',
                'Barlow Condensed',
                'Barlow Semi Condensed',
                'Barrio',
                'Basic',
                'Battambang',
                'Baumans',
                'Bayon',
                'Belgrano',
                'Bellefair',
                'Belleza',
                'BenchNine',
                'Bentham',
                'Berkshire Swash',
                'Bevan',
                'Bigelow Rules',
                'Bigshot One',
                'Bilbo',
                'Bilbo Swash Caps',
                'BioRhyme',
                'BioRhyme Expanded',
                'Biryani',
                'Bitter',
                'Black And White Picture',
                'Black Han Sans',
                'Black Ops One',
                'Bokor',
                'Bonbon',
                'Boogaloo',
                'Bowlby One',
                'Bowlby One SC',
                'Brawler',
                'Bree Serif',
                'Bubblegum Sans',
                'Bubbler One',
                'Buda',
                'Buenard',
                'Bungee',
                'Bungee Hairline',
                'Bungee Inline',
                'Bungee Outline',
                'Bungee Shade',
                'Butcherman',
                'Butterfly Kids',
                'Cabin',
                'Cabin Condensed',
                'Cabin Sketch',
                'Caesar Dressing',
                'Cagliostro',
                'Cairo',
                'Calligraffitti',
                'Cambay',
                'Cambo',
                'Candal',
                'Cantarell',
                'Cantata One',
                'Cantora One',
                'Capriola',
                'Cardo',
                'Carme',
                'Carrois Gothic',
                'Carrois Gothic SC',
                'Carter One',
                'Catamaran',
                'Caudex',
                'Caveat',
                'Caveat Brush',
                'Cedarville Cursive',
                'Ceviche One',
                'Chakra Petch',
                'Changa',
                'Changa One',
                'Chango',
                'Charmonman',
                'Chathura',
                'Chau Philomene One',
                'Chela One',
                'Chelsea Market',
                'Chenla',
                'Cherry Cream Soda',
                'Cherry Swash',
                'Chewy',
                'Chicle',
                'Chivo',
                'Chonburi',
                'Cinzel',
                'Cinzel Decorative',
                'Clicker Script',
                'Coda',
                'Coda Caption',
                'Codystar',
                'Coiny',
                'Combo',
                'Comfortaa',
                'Coming Soon',
                'Concert One',
                'Condiment',
                'Content',
                'Contrail One',
                'Convergence',
                'Cookie',
                'Copse',
                'Corben',
                'Cormorant',
                'Cormorant Garamond',
                'Cormorant Infant',
                'Cormorant SC',
                'Cormorant Unicase',
                'Cormorant Upright',
                'Courgette',
                'Cousine',
                'Coustard',
                'Covered By Your Grace',
                'Crafty Girls',
                'Creepster',
                'Crete Round',
                'Crimson Text',
                'Croissant One',
                'Crushed',
                'Cuprum',
                'Cute Font',
                'Cutive',
                'Cutive Mono',
                'Damion',
                'Dancing Script',
                'Dangrek',
                'David Libre',
                'Dawning of a New Day',
                'Days One',
                'Dekko',
                'Delius',
                'Delius Swash Caps',
                'Delius Unicase',
                'Della Respira',
                'Denk One',
                'Devonshire',
                'Dhurjati',
                'Didact Gothic',
                'Diplomata',
                'Diplomata SC',
                'Do Hyeon',
                'Dokdo',
                'Domine',
                'Donegal One',
                'Doppio One',
                'Dorsa',
                'Dosis',
                'Dr Sugiyama',
                'Droid Arabic Kufi',
            // Hack for Google Early Access.
                'Droid Arabic Naskh',
            // Hack for Google Early Access.
                'Duru Sans',
                'Dynalight',
                'EB Garamond',
                'Eagle Lake',
                'East Sea Dokdo',
                'Eater',
                'Economica',
                'Eczar',
                'El Messiri',
                'Electrolize',
                'Elsie',
                'Elsie Swash Caps',
                'Emblema One',
                'Emilys Candy',
                'Encode Sans',
                'Encode Sans Condensed',
                'Encode Sans Expanded',
                'Encode Sans Semi Condensed',
                'Encode Sans Semi Expanded',
                'Engagement',
                'Englebert',
                'Enriqueta',
                'Erica One',
                'Esteban',
                'Euphoria Script',
                'Ewert',
                'Exo',
                'Exo 2',
                'Expletus Sans',
                'Fahkwang',
                'Fanwood Text',
                'Farsan',
                'Fascinate',
                'Fascinate Inline',
                'Faster One',
                'Fasthand',
                'Fauna One',
                'Faustina',
                'Federant',
                'Federo',
                'Felipa',
                'Fenix',
                'Finger Paint',
                'Fira Mono',
                'Fira Sans',
                'Fira Sans Condensed',
                'Fira Sans Extra Condensed',
                'Fjalla One',
                'Fjord One',
                'Flamenco',
                'Flavors',
                'Fondamento',
                'Fontdiner Swanky',
                'Forum',
                'Francois One',
                'Frank Ruhl Libre',
                'Freckle Face',
                'Fredericka the Great',
                'Fredoka One',
                'Freehand',
                'Fresca',
                'Frijole',
                'Fruktur',
                'Fugaz One',
                'GFS Didot',
                'GFS Neohellenic',
                'Gabriela',
                'Gaegu',
                'Gafata',
                'Galada',
                'Galdeano',
                'Galindo',
                'Gamja Flower',
                'Gentium Basic',
                'Gentium Book Basic',
                'Geo',
                'Geostar',
                'Geostar Fill',
                'Germania One',
                'Gidugu',
                'Gilda Display',
                'Give You Glory',
                'Glass Antiqua',
                'Glegoo',
                'Gloria Hallelujah',
                'Goblin One',
                'Gochi Hand',
                'Gorditas',
                'Gothic A1',
                'Goudy Bookletter 1911',
                'Graduate',
                'Grand Hotel',
                'Gravitas One',
                'Great Vibes',
                'Griffy',
                'Gruppo',
                'Gudea',
                'Gugi',
                'Gurajada',
                'Habibi',
                'Halant',
                'Hammersmith One',
                'Hanalei',
                'Hanalei Fill',
                'Handlee',
                'Hanuman',
                'Happy Monkey',
                'Harmattan',
                'Headland One',
                'Heebo',
                'Henny Penny',
                'Herr Von Muellerhoff',
                'Hi Melody',
                'Hind',
                'Hind Guntur',
                'Hind Madurai',
                'Hind Siliguri',
                'Hind Vadodara',
                'Holtwood One SC',
                'Homemade Apple',
                'Homenaje',
                'IBM Plex Mono',
                'IBM Plex Sans',
                'IBM Plex Sans Condensed',
                'IBM Plex Serif',
                'IM Fell DW Pica',
                'IM Fell DW Pica SC',
                'IM Fell Double Pica',
                'IM Fell Double Pica SC',
                'IM Fell English',
                'IM Fell English SC',
                'IM Fell French Canon',
                'IM Fell French Canon SC',
                'IM Fell Great Primer',
                'IM Fell Great Primer SC',
                'Iceberg',
                'Iceland',
                'Imprima',
                'Inconsolata',
                'Inder',
                'Indie Flower',
                'Inika',
                'Inknut Antiqua',
                'Irish Grover',
                'Istok Web',
                'Italiana',
                'Italianno',
                'Itim',
                'Jacques Francois',
                'Jacques Francois Shadow',
                'Jaldi',
                'Jim Nightshade',
                'Jockey One',
                'Jolly Lodger',
                'Jomhuria',
                'Josefin Sans',
                'Josefin Slab',
                'Joti One',
                'Jua',
                'Judson',
                'Julee',
                'Julius Sans One',
                'Junge',
                'Jura',
                'Just Another Hand',
                'Just Me Again Down Here',
                'K2D',
                'Kadwa',
                'Kalam',
                'Kameron',
                'Kanit',
                'Kantumruy',
                'Karla',
                'Karma',
                'Katibeh',
                'Kaushan Script',
                'Kavivanar',
                'Kavoon',
                'Kdam Thmor',
                'Keania One',
                'Kelly Slab',
                'Kenia',
                'Khand',
                'Khmer',
                'Khula',
                'Kirang Haerang',
                'Kite One',
                'Knewave',
                'KoHo',
                'Kodchasan',
                'Kosugi',
                'Kosugi Maru',
                'Kotta One',
                'Koulen',
                'Kranky',
                'Kreon',
                'Kristi',
                'Krona One',
                'Krub',
                'Kumar One',
                'Kumar One Outline',
                'Kurale',
                'La Belle Aurore',
                'Laila',
                'Lakki Reddy',
                'Lalezar',
                'Lancelot',
                'Lateef',
                'Lato',
                'League Script',
                'Leckerli One',
                'Ledger',
                'Lekton',
                'Lemon',
                'Lemonada',
                'Libre Barcode 128',
                'Libre Barcode 128 Text',
                'Libre Barcode 39',
                'Libre Barcode 39 Extended',
                'Libre Barcode 39 Extended Text',
                'Libre Barcode 39 Text',
                'Libre Baskerville',
                'Libre Franklin',
                'Life Savers',
                'Lilita One',
                'Lily Script One',
                'Limelight',
                'Linden Hill',
                'Lobster',
                'Lobster Two',
                'Londrina Outline',
                'Londrina Shadow',
                'Londrina Sketch',
                'Londrina Solid',
                'Lora',
                'Love Ya Like A Sister',
                'Loved by the King',
                'Lovers Quarrel',
                'Luckiest Guy',
                'Lusitana',
                'Lustria',
                'M PLUS 1p',
                'M PLUS Rounded 1c',
                'Macondo',
                'Macondo Swash Caps',
                'Mada',
                'Magra',
                'Maiden Orange',
                'Maitree',
                'Mako',
                'Mali',
                'Mallanna',
                'Mandali',
                'Manuale',
                'Marcellus',
                'Marcellus SC',
                'Marck Script',
                'Margarine',
                'Markazi Text',
                'Marko One',
                'Marmelad',
                'Martel',
                'Martel Sans',
                'Marvel',
                'Mate',
                'Mate SC',
                'Maven Pro',
                'McLaren',
                'Meddon',
                'MedievalSharp',
                'Medula One',
                'Meera Inimai',
                'Megrim',
                'Meie Script',
                'Merienda',
                'Merienda One',
                'Merriweather',
                'Merriweather Sans',
                'Metal',
                'Metal Mania',
                'Metamorphous',
                'Metrophobic',
                'Michroma',
                'Milonga',
                'Miltonian',
                'Miltonian Tattoo',
                'Mina',
                'Miniver',
                'Miriam Libre',
                'Mirza',
                'Miss Fajardose',
                'Mitr',
                'Modak',
                'Modern Antiqua',
                'Mogra',
                'Molengo',
                'Molle',
                'Monda',
                'Monofett',
                'Monoton',
                'Monsieur La Doulaise',
                'Montaga',
                'Montez',
                'Montserrat',
                'Montserrat Alternates',
                'Montserrat Subrayada',
                'Moul',
                'Moulpali',
                'Mountains of Christmas',
                'Mouse Memoirs',
                'Mr Bedfort',
                'Mr Dafoe',
                'Mr De Haviland',
                'Mrs Saint Delafield',
                'Mrs Sheppards',
                'Mukta',
                'Mukta Mahee',
                'Mukta Malar',
                'Mukta Vaani',
                'Muli',
                'Mystery Quest',
                'NTR',
                'Nanum Brush Script',
                'Nanum Gothic',
                'Nanum Gothic Coding',
                'Nanum Myeongjo',
                'Nanum Pen Script',
                'Neucha',
                'Neuton',
                'New Rocker',
                'News Cycle',
                'Niconne',
                'Niramit',
                'Nixie One',
                'Nobile',
                'Nokora',
                'Norican',
                'Nosifer',
                'Notable',
                'Nothing You Could Do',
                'Noticia Text',
                'Noto Kufi Arabic',
            // Hack for Google Early Access.
                'Noto Naskh Arabic',
            // Hack for Google Early Access.
                'Noto Sans',
                'Noto Sans Hebrew',
            // Hack for Google Early Access.
                'Noto Sans JP',
                'Noto Sans KR',
                'Noto Serif',
                'Noto Serif JP',
                'Noto Serif KR',
                'Nova Cut',
                'Nova Flat',
                'Nova Mono',
                'Nova Oval',
                'Nova Round',
                'Nova Script',
                'Nova Slim',
                'Nova Square',
                'Numans',
                'Nunito',
                'Nunito Sans',
                'Odor Mean Chey',
                'Offside',
                'Old Standard TT',
                'Oldenburg',
                'Oleo Script',
                'Oleo Script Swash Caps',
                'Open Sans',
                'Open Sans Condensed',
                'Open Sans Hebrew',
            // Hack for Google Early Access.
                'Open Sans Hebrew Condensed',
            // Hack for Google Early Access.
                'Oranienbaum',
                'Orbitron',
                'Oregano',
                'Orienta',
                'Original Surfer',
                'Oswald',
                'Over the Rainbow',
                'Overlock',
                'Overlock SC',
                'Overpass',
                'Overpass Mono',
                'Ovo',
                'Oxygen',
                'Oxygen Mono',
                'PT Mono',
                'PT Sans',
                'PT Sans Caption',
                'PT Sans Narrow',
                'PT Serif',
                'PT Serif Caption',
                'Pacifico',
                'Padauk',
                'Palanquin',
                'Palanquin Dark',
                'Pangolin',
                'Paprika',
                'Parisienne',
                'Passero One',
                'Passion One',
                'Pathway Gothic One',
                'Patrick Hand',
                'Patrick Hand SC',
                'Pattaya',
                'Patua One',
                'Pavanam',
                'Paytone One',
                'Peddana',
                'Peralta',
                'Permanent Marker',
                'Petit Formal Script',
                'Petrona',
                'Philosopher',
                'Piedra',
                'Pinyon Script',
                'Pirata One',
                'Plaster',
                'Play',
                'Playball',
                'Playfair Display',
                'Playfair Display SC',
                'Podkova',
                'Poiret One',
                'Poller One',
                'Poly',
                'Pompiere',
                'Pontano Sans',
                'Poor Story',
                'Poppins',
                'Port Lligat Sans',
                'Port Lligat Slab',
                'Pragati Narrow',
                'Prata',
                'Preahvihear',
                'Press Start 2P',
                'Pridi',
                'Princess Sofia',
                'Prociono',
                'Prompt',
                'Prosto One',
                'Proza Libre',
                'Puritan',
                'Purple Purse',
                'Quando',
                'Quantico',
                'Quattrocento',
                'Quattrocento Sans',
                'Questrial',
                'Quicksand',
                'Quintessential',
                'Qwigley',
                'Racing Sans One',
                'Radley',
                'Rajdhani',
                'Rakkas',
                'Raleway',
                'Raleway Dots',
                'Ramabhadra',
                'Ramaraja',
                'Rambla',
                'Rammetto One',
                'Ranchers',
                'Rancho',
                'Ranga',
                'Rasa',
                'Rationale',
                'Ravi Prakash',
                'Redressed',
                'Reem Kufi',
                'Reenie Beanie',
                'Revalia',
                'Rhodium Libre',
                'Ribeye',
                'Ribeye Marrow',
                'Righteous',
                'Risque',
                'Roboto',
                'Roboto Condensed',
                'Roboto Mono',
                'Roboto Slab',
                'Rochester',
                'Rock Salt',
                'Rokkitt',
                'Romanesco',
                'Ropa Sans',
                'Rosario',
                'Rosarivo',
                'Rouge Script',
                'Rozha One',
                'Rubik',
                'Rubik Mono One',
                'Ruda',
                'Rufina',
                'Ruge Boogie',
                'Ruluko',
                'Rum Raisin',
                'Ruslan Display',
                'Russo One',
                'Ruthie',
                'Rye',
                'Sacramento',
                'Sahitya',
                'Sail',
                'Saira',
                'Saira Condensed',
                'Saira Extra Condensed',
                'Saira Semi Condensed',
                'Salsa',
                'Sanchez',
                'Sancreek',
                'Sansita',
                'Sarala',
                'Sarina',
                'Sarpanch',
                'Satisfy',
                'Sawarabi Gothic',
                'Sawarabi Mincho',
                'Scada',
                'Scheherazade',
                'Schoolbell',
                'Scope One',
                'Seaweed Script',
                'Secular One',
                'Sedgwick Ave',
                'Sedgwick Ave Display',
                'Sevillana',
                'Seymour One',
                'Shadows Into Light',
                'Shadows Into Light Two',
                'Shanti',
                'Share',
                'Share Tech',
                'Share Tech Mono',
                'Shojumaru',
                'Short Stack',
                'Shrikhand',
                'Siemreap',
                'Sigmar One',
                'Signika',
                'Signika Negative',
                'Simonetta',
                'Sintony',
                'Sirin Stencil',
                'Six Caps',
                'Skranji',
                'Slabo 13px',
                'Slabo 27px',
                'Slackey',
                'Smokum',
                'Smythe',
                'Sniglet',
                'Snippet',
                'Snowburst One',
                'Sofadi One',
                'Sofia',
                'Song Myung',
                'Sonsie One',
                'Sorts Mill Goudy',
                'Source Code Pro',
                'Source Sans Pro',
                'Source Serif Pro',
                'Space Mono',
                'Special Elite',
                'Spectral',
                'Spectral SC',
                'Spicy Rice',
                'Spinnaker',
                'Spirax',
                'Squada One',
                'Sree Krushnadevaraya',
                'Sriracha',
                'Srisakdi',
                'Stalemate',
                'Stalinist One',
                'Stardos Stencil',
                'Stint Ultra Condensed',
                'Stint Ultra Expanded',
                'Stoke',
                'Strait',
                'Stylish',
                'Sue Ellen Francisco',
                'Suez One',
                'Sumana',
                'Sunflower',
                'Sunshiney',
                'Supermercado One',
                'Sura',
                'Suranna',
                'Suravaram',
                'Suwannaphum',
                'Swanky and Moo Moo',
                'Syncopate',
                'Tajawal',
                'Tangerine',
                'Taprom',
                'Tauri',
                'Taviraj',
                'Teko',
                'Telex',
                'Tenali Ramakrishna',
                'Tenor Sans',
                'Text Me One',
                'The Girl Next Door',
                'Tienne',
                'Tillana',
                'Timmana',
                'Tinos',
                'Titan One',
                'Titillium Web',
                'Trade Winds',
                'Trirong',
                'Trocchi',
                'Trochut',
                'Trykker',
                'Tulpen One',
                'Ubuntu',
                'Ubuntu Condensed',
                'Ubuntu Mono',
                'Ultra',
                'Uncial Antiqua',
                'Underdog',
                'Unica One',
                'UnifrakturCook',
                'UnifrakturMaguntia',
                'Unkempt',
                'Unlock',
                'Unna',
                'VT323',
                'Vampiro One',
                'Varela',
                'Varela Round',
                'Vast Shadow',
                'Vesper Libre',
                'Vibur',
                'Vidaloka',
                'Viga',
                'Voces',
                'Volkhov',
                'Vollkorn',
                'Vollkorn SC',
                'Voltaire',
                'Waiting for the Sunrise',
                'Wallpoet',
                'Walter Turncoat',
                'Warnes',
                'Wellfleet',
                'Wendy One',
                'Wire One',
                'Work Sans',
                'Yanone Kaffeesatz',
                'Yantramanav',
                'Yatra One',
                'Yellowtail',
                'Yeon Sung',
                'Yeseva One',
                'Yesteryear',
                'Yrsa',
                'Zeyada',
                'Zilla Slab',
                'Zilla Slab Highlight',
            ],
        ];

    }//end couponx_fonts()


    /**
     * Predefined tab icons.
     *
     * @return $tab_icon array of svgs
     */
    public static function coupon_tab_icon()
    {

        $tab_icon['tab-icon-1'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M22.4667 0.799988C22.316 0.799988 22.1709 0.814703 22.0428 0.839672C20.1332 1.16267 17.4596 3.18907 16.2334 5.41378C15.0071 3.18907 12.3359 1.16379 10.4398 0.843072C10.297 0.814703 10.1508 0.799988 10.0001 0.799988C8.74998 0.799988 7.73338 1.81659 7.73338 3.06667C7.73338 3.58915 7.91586 4.10027 8.24678 4.50375C8.25121 4.50819 8.25518 4.5131 8.25928 4.51819L8.26606 4.52643C9.72806 6.38055 14.0982 7.24414 15.6667 7.50143V27.9999H16.8V7.50137C18.3686 7.24409 22.7375 6.38049 24.1995 4.52638C24.2063 4.51958 24.2131 4.51167 24.2188 4.50486C24.5509 4.10138 24.7333 3.59027 24.7333 3.06667C24.7333 1.81659 23.7167 0.799988 22.4667 0.799988ZM9.13529 3.79767L9.13515 3.79749C9.12271 3.78166 9.11032 3.7659 9.09678 3.75235C8.94606 3.55404 8.86669 3.31827 8.86669 3.06667C8.86669 2.44218 9.37557 1.93335 10 1.93335C10.0748 1.93335 10.1485 1.94015 10.2357 1.95715C11.9357 2.24387 14.4993 4.29975 15.4218 6.30686C13.4477 5.94418 10.1179 5.09418 9.13529 3.79767ZM23.3699 3.75118C23.3563 3.7659 23.3439 3.78067 23.3314 3.79767C22.3511 5.09195 19.0191 5.94306 17.046 6.30686C17.9674 4.29975 20.5344 2.24498 22.2457 1.95487C22.3171 1.94015 22.3919 1.93335 22.4667 1.93335C23.0923 1.93335 23.6 2.44224 23.6 3.06667C23.6 3.31827 23.5207 3.55398 23.3699 3.75118ZM14.5334 27.4332V13.2666H4.33339V27.4333C4.33339 27.746 4.58728 27.9999 4.90008 27.9999H14.6377C14.5742 27.822 14.5334 27.6327 14.5334 27.4332ZM3.7667 6.46665H8.83157C10.4829 7.49345 12.7744 8.10545 14.5334 8.44885V12.1333H3.7667C3.4539 12.1333 3.20001 11.8794 3.20001 11.5666V7.03334C3.20001 6.72054 3.4539 6.46665 3.7667 6.46665ZM28.7 6.46665H23.6352C21.9817 7.49345 19.6923 8.10545 17.9334 8.44885V12.1333H28.7C29.0128 12.1333 29.2667 11.8794 29.2667 11.5666V7.03334C29.2667 6.72049 29.0128 6.46665 28.7 6.46665ZM17.9333 27.4333V13.2666H28.1333V27.4333C28.1333 27.7461 27.8794 28 27.5666 28H17.829C17.8925 27.822 17.9333 27.6328 17.9333 27.4333Z"/></svg>';

        $tab_icon['tab-icon-2'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M29.3633 16.3938C29.241 16.1435 29.241 15.8565 29.3633 15.6063L30.4972 13.2868C31.1284 11.9954 30.6283 10.4561 29.3585 9.78236L27.0779 8.57232C26.8319 8.44181 26.6632 8.20954 26.615 7.93529L26.169 5.39235C25.9206 3.97651 24.611 3.02509 23.1879 3.22643L20.6317 3.58802C20.3558 3.62697 20.083 3.53826 19.8828 3.34465L18.0273 1.54964C16.9941 0.550133 15.3756 0.550074 14.3425 1.54964L12.4869 3.34482C12.2867 3.5385 12.0139 3.62703 11.738 3.5882L9.18178 3.22661C7.75828 3.02515 6.44908 3.97668 6.20071 5.39252L5.75469 7.93535C5.70654 8.20966 5.53786 8.44187 5.29187 8.57244L3.0113 9.78248C1.74152 10.4561 1.24136 11.9955 1.87262 13.287L3.00638 15.6064C3.12869 15.8567 3.12869 16.1437 3.00638 16.3939L1.87256 18.7133C1.2413 20.0047 1.74146 21.544 3.01124 22.2177L5.29181 23.4278C5.53786 23.5583 5.70654 23.7905 5.75469 24.0648L6.20071 26.6077C6.42681 27.8966 7.532 28.8006 8.8022 28.8004C8.9273 28.8004 9.05424 28.7916 9.18184 28.7736L11.7381 28.412C12.0138 28.3729 12.2868 28.4618 12.487 28.6554L14.3425 30.4504C14.8592 30.9502 15.5219 31.2 16.1849 31.2C16.8477 31.1999 17.5108 30.9501 18.0272 30.4504L19.8828 28.6554C20.083 28.4618 20.3559 28.3733 20.6317 28.412L23.1879 28.7736C24.6116 28.975 25.9206 28.0235 26.169 26.6077L26.6151 24.0649C26.6632 23.7905 26.8319 23.5583 27.0779 23.4278L29.3585 22.2177C30.6283 21.5441 31.1284 20.0047 30.4972 18.7132L29.3633 16.3938ZM12.6782 8.11003C14.4506 8.11003 15.8926 9.55205 15.8926 11.3245C15.8926 13.0969 14.4506 14.539 12.6782 14.539C10.9057 14.539 9.46369 13.0969 9.46369 11.3245C9.46369 9.55205 10.9057 8.11003 12.6782 8.11003ZM11.019 22.4056C10.8478 22.5768 10.6234 22.6624 10.3991 22.6624C10.1748 22.6624 9.95038 22.5768 9.77926 22.4056C9.43691 22.0632 9.43691 21.5081 9.77926 21.1658L21.3507 9.59439C21.693 9.25203 22.2481 9.25203 22.5905 9.59439C22.9328 9.93674 22.9328 10.4918 22.5905 10.8342L11.019 22.4056ZM19.6914 23.8901C17.919 23.8901 16.477 22.448 16.477 20.6756C16.477 18.9031 17.919 17.4611 19.6914 17.4611C21.4639 17.4611 22.9059 18.9031 22.9059 20.6756C22.9059 22.448 21.4639 23.8901 19.6914 23.8901ZM19.6915 19.2145C18.8858 19.2145 18.2303 19.87 18.2303 20.6756C18.2303 21.4813 18.8858 22.1367 19.6915 22.1367C20.4971 22.1367 21.1525 21.4813 21.1525 20.6756C21.1525 19.87 20.4971 19.2145 19.6915 19.2145ZM11.2171 11.3244C11.2171 10.5188 11.8725 9.86336 12.6782 9.86336C13.4838 9.86336 14.1392 10.5189 14.1393 11.3244C14.1393 12.1302 13.4838 12.7856 12.6782 12.7856C11.8725 12.7856 11.2171 12.1301 11.2171 11.3244Z"/></svg>';

        $tab_icon['tab-icon-3'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M29.3333 5.59998H2.66667C1.19393 5.59998 0 6.79391 0 8.26664V21.334C0 22.8064 1.1936 24 2.666 24H5.586C5.88127 23.9451 6.1444 23.9304 6.36273 23.9338C6.69233 23.9389 6.94193 23.6442 6.89447 23.318C6.725 22.1526 6.85413 20.9562 7.2838 19.8384L10.6065 11.1926C11.0215 10.1128 12.4133 9.81718 13.2314 10.6352C15.1723 12.5762 15.7361 15.4642 14.6678 17.9926L12.4425 23.259C12.2939 23.6106 12.5521 24 12.9338 24H29.3333C30.8061 24 32 22.806 32 21.3333V8.26664C32 6.79391 30.8061 5.59998 29.3333 5.59998ZM9.73333 11.6666C9.73333 11.9612 9.49453 12.2 9.2 12.2C8.90547 12.2 8.66667 11.9612 8.66667 11.6666V9.06664C8.66667 8.77211 8.90547 8.53331 9.2 8.53331C9.49453 8.53331 9.73333 8.77211 9.73333 9.06664V11.6666ZM18.3333 12.3888C18.3333 11.8068 18.8069 11.3333 19.3889 11.3333C19.9709 11.3333 20.4444 11.8068 20.4444 12.3888C20.4444 12.9708 19.9709 13.4444 19.3889 13.4444C18.8069 13.4444 18.3333 12.9708 18.3333 12.3888ZM18.8377 18.1623C18.6293 17.954 18.6293 17.6164 18.8377 17.408L24.0599 12.1858C24.2682 11.9776 24.6059 11.9777 24.8141 12.1858C25.0224 12.3942 25.0224 12.7318 24.8141 12.9401L19.5919 18.1623C19.3836 18.3706 19.046 18.3705 18.8377 18.1623ZM24.6111 18.6666C24.0291 18.6666 23.5556 18.1931 23.5556 17.6111C23.5556 17.0291 24.0291 16.5555 24.6111 16.5555C25.1931 16.5555 25.6667 17.0291 25.6667 17.6111C25.6667 18.1931 25.1931 18.6666 24.6111 18.6666ZM13.3667 30.6666C11.8043 30.6666 10.5333 29.3956 10.5333 27.8333C10.5333 26.271 11.8043 25 13.3667 25C14.929 25 16.2 26.271 16.2 27.8333C16.2 29.3956 14.929 30.6666 13.3667 30.6666ZM13.3667 26.0666C12.3925 26.0666 11.6 26.8592 11.6 27.8333C11.6 28.8074 12.3925 29.6 13.3667 29.6C14.3408 29.6 15.1333 28.8074 15.1333 27.8333C15.1333 26.8592 14.3408 26.0666 13.3667 26.0666ZM12.4773 11.3893C12.2008 11.1143 11.7387 11.2189 11.602 11.5753L8.27933 20.2213C7.75667 21.5813 7.758 23.0786 8.28267 24.438L8.92467 26.1026L8.77533 26.4566C8.29067 25.5886 7.36267 25 6.3 25C4.738 25 3.46667 26.2713 3.46667 27.8333C3.46667 29.3953 4.738 30.6666 6.3 30.6666C7.596 30.6666 8.692 29.7913 9.02733 28.6013L13.6853 17.5773C14.584 15.4506 14.1093 13.022 12.4773 11.3893ZM6.3 29.6C5.326 29.6 4.53333 28.8073 4.53333 27.8333C4.53333 26.8593 5.326 26.0666 6.3 26.0666C7.274 26.0666 8.06667 26.8593 8.06667 27.8333C8.06667 28.8073 7.274 29.6 6.3 29.6Z"/></svg>';

        $tab_icon['tab-icon-4'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M23.4298 5.65783H28.6278C29.1643 5.65783 29.5992 6.09274 29.5992 6.62919V11.4862C29.5992 12.0227 29.1643 12.4576 28.6278 12.4576H3.37144C2.83493 12.4576 2.40002 12.0227 2.40002 11.4862V6.62919C2.40002 6.09268 2.83493 5.65777 3.37144 5.65777H8.56941C8.28363 5.07875 8.17389 4.42863 8.25369 3.78785C8.54147 2.03648 10.0734 0.763286 11.8479 0.800795H13.5711C14.4863 0.80108 15.3623 1.17179 15.9996 1.82862C16.6369 1.17184 17.513 0.801137 18.4281 0.800852H20.1514C21.9251 0.764311 23.4559 2.03728 23.7436 3.7879C23.824 4.42846 23.7149 5.07857 23.4298 5.65783ZM11.6283 5.65783H15.0282V4.20073C15.0282 3.39597 14.3758 2.74363 13.5711 2.74363H11.6283C10.8235 2.74363 10.1712 3.39602 10.1712 4.20073C10.1712 5.00543 10.8236 5.65783 11.6283 5.65783ZM16.971 5.65783H20.3709C21.1756 5.65783 21.828 5.00549 21.828 4.20073C21.828 3.39597 21.1756 2.74363 20.3709 2.74363H18.4281C17.6233 2.74363 16.971 3.39602 16.971 4.20073V5.65783ZM3.37142 27.0286V13.429H28.6278V27.0286C28.6278 27.5651 28.1929 28 27.6564 28H4.34284C3.80633 28 3.37142 27.5651 3.37142 27.0286Z"/></svg>';

        $tab_icon['tab-icon-5'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M25.2766 9.39691V29.173C25.2766 30.291 24.367 31.2 23.2496 31.2H8.42704C7.30901 31.2 6.40002 30.291 6.40002 29.173L6.40002 9.39691C6.40002 8.81731 6.64897 8.26431 7.08224 7.87981L14.4935 1.30975C15.26 0.630067 16.4166 0.630067 17.1831 1.30975L24.5944 7.87981C25.0277 8.26425 25.2766 8.81724 25.2766 9.39691ZM15.8383 9.28289C17.6199 9.28289 18.4695 7.09751 17.183 5.88814C15.9754 4.75346 13.9813 5.54057 13.8785 7.19487C13.8067 8.35052 14.7281 9.28289 15.8383 9.28289ZM13.3573 19.5868C13.9103 19.5868 14.3602 19.1369 14.3602 18.5839C14.3602 18.0309 13.9103 17.581 13.3573 17.581C12.8043 17.581 12.3544 18.0309 12.3544 18.5839C12.3544 19.1369 12.8043 19.5868 13.3573 19.5868ZM13.5503 24.0696L18.5123 19.1076C18.7102 18.9098 18.7102 18.5889 18.5123 18.391C18.3143 18.1931 17.9935 18.1931 17.7956 18.391L12.8336 23.353C12.5134 23.6732 12.7446 24.2181 13.192 24.2181C13.3216 24.218 13.4513 24.1685 13.5503 24.0696ZM19.3222 23.5459C19.3222 22.9929 18.8723 22.5429 18.3193 22.5429C17.7663 22.5429 17.3163 22.9929 17.3163 23.5459C17.3163 24.0989 17.7663 24.5488 18.3193 24.5488C18.8723 24.5488 19.3222 24.0989 19.3222 23.5459Z"/></svg>';

        $tab_icon['tab-icon-6'] = '<svg class="tab-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M31.2001 16.8C31.2001 17.7116 30.657 18.4792 30.1771 19.1565L30.1697 19.1669C29.8582 19.6077 29.5639 20.0241 29.4621 20.4077C29.352 20.8166 29.3981 21.34 29.447 21.8946L29.4485 21.9118C29.5253 22.7629 29.6044 23.6436 29.1653 24.4019C28.7187 25.1725 27.8739 25.5622 27.1292 25.9054C26.6232 26.1386 26.147 26.3588 25.8526 26.6525C25.5582 26.9463 25.3381 27.4238 25.1055 27.9291L25.1048 27.9307C24.7611 28.6756 24.3714 29.5202 23.6014 29.9652C22.9903 30.319 22.0922 30.3363 21.1113 30.2491C20.5559 30.199 19.9733 30.1637 19.6071 30.2614C19.2236 30.364 18.807 30.6585 18.3648 30.9711L18.3565 30.977C17.6799 31.4563 16.9117 32 16 32C15.0884 32 14.3202 31.4563 13.6437 30.9771L13.6358 30.9716C13.1935 30.6588 12.7767 30.3642 12.3931 30.2615C12.027 30.1638 11.4431 30.1991 10.8877 30.2492C9.9055 30.3345 9.01114 30.3191 8.39761 29.9647C7.6289 29.5198 7.23929 28.6754 6.89562 27.9307L6.89466 27.9286C6.66214 27.4233 6.44192 26.9464 6.14754 26.652C5.85401 26.3591 5.37966 26.1399 4.87659 25.9075L4.87222 25.9055C4.1263 25.5622 3.28145 25.1726 2.83489 24.4019C2.39575 23.643 2.4749 22.7629 2.55161 21.9119L2.55302 21.896C2.60203 21.3409 2.64829 20.8169 2.53801 20.4071C2.43619 20.0243 2.14206 19.608 1.83067 19.1673L1.82302 19.1565C1.34309 18.4792 0.800049 17.7116 0.800049 16.8C0.800049 15.8883 1.34309 15.1208 1.82296 14.4435L1.8306 14.4327C2.14199 13.992 2.43613 13.5757 2.53796 13.1923C2.64815 12.7834 2.60198 12.2599 2.55307 11.7053L2.55155 11.6881C2.47484 10.8371 2.39569 9.95635 2.83483 9.19808C3.28139 8.42745 4.12624 8.03777 4.87092 7.69452C5.37685 7.46136 5.8531 7.24119 6.14748 6.94741C6.44186 6.65362 6.66202 6.17613 6.8946 5.67084L6.89533 5.66926C7.23899 4.92437 7.62866 4.07975 8.39874 3.63476C9.00983 3.28035 9.90663 3.26123 10.8888 3.35089C11.4442 3.4004 12.0268 3.43627 12.393 3.33854C12.7765 3.23592 13.1931 2.94144 13.6353 2.6288L13.6436 2.62295C14.3202 2.14361 15.0884 1.59998 16 1.59998C16.9117 1.59998 17.6799 2.14361 18.3565 2.62295L18.3643 2.62848C18.8067 2.94123 19.2235 3.23583 19.6071 3.33854C19.9732 3.43627 20.5571 3.40034 21.1113 3.35089C22.0959 3.26307 22.9878 3.27975 23.6025 3.63541C24.3713 4.08036 24.761 4.92484 25.1046 5.66955L25.1054 5.67138C25.338 6.17666 25.5582 6.65356 25.8526 6.94794C26.1461 7.24088 26.6205 7.46004 27.1235 7.69245L27.1279 7.69446C27.8738 8.03771 28.7187 8.42739 29.1652 9.19802C29.6043 9.95695 29.5252 10.8371 29.4485 11.6881L29.4471 11.704C29.3981 12.2591 29.3518 12.783 29.4621 13.1929C29.5639 13.5757 29.858 13.992 30.1694 14.4327L30.1771 14.4435C30.657 15.1208 31.2001 15.8883 31.2001 16.8ZM11.97 25.3085L12.8655 24.413C13.6065 23.672 13.6065 22.4672 12.8654 21.7264C12.5067 21.3676 12.0292 21.1697 11.522 21.1697H11.5208C11.0124 21.1703 10.5362 21.3676 10.1787 21.7264C9.93133 21.9725 9.5293 21.975 9.28189 21.7264C9.16189 21.6064 9.09634 21.4474 9.09634 21.2786C9.09634 21.1091 9.16189 20.9508 9.28189 20.8308L10.1774 19.9346C10.4249 19.6872 10.4249 19.2858 10.1774 19.039C9.93008 18.7916 9.5293 18.7916 9.28189 19.039L8.38633 19.9346C8.02759 20.2932 7.82969 20.7707 7.82969 21.2785C7.82969 21.7857 8.02759 22.2631 8.38633 22.6219C9.12727 23.3635 10.3358 23.3616 11.0743 22.6213C11.1943 22.5019 11.3526 22.4363 11.5209 22.4363H11.5221C11.6916 22.4363 11.8499 22.5025 11.9699 22.6219C12.2173 22.8686 12.2173 23.2707 11.9699 23.5174L11.0744 24.413C10.8269 24.6603 10.8269 25.0611 11.0744 25.3085C11.1981 25.4322 11.3601 25.4941 11.5222 25.4941C11.6842 25.4941 11.8463 25.4322 11.97 25.3085ZM16.4479 19.9345C16.6952 20.1819 17.096 20.1819 17.3434 19.9345C17.5908 19.6871 17.5908 19.2863 17.3434 19.0389L14.6567 16.3522C13.917 15.6113 12.7097 15.6113 11.97 16.3522C11.6112 16.711 11.4133 17.1884 11.4133 17.6956C11.4133 18.2034 11.6112 18.6809 11.97 19.0389L13.7607 20.8301L13.7611 20.8307L13.7617 20.8311L14.6567 21.7263C14.7804 21.8499 14.9425 21.9118 15.1045 21.9118C15.2665 21.9118 15.4286 21.8499 15.5523 21.7263C15.7997 21.4789 15.7997 21.0781 15.5523 20.8307L15.1045 20.3828L16.0002 19.4868L16.4479 19.9345ZM19.1345 18.1433L20.9257 16.3522C21.1731 16.1048 21.1731 15.704 20.9257 15.4566C20.6783 15.2092 20.2775 15.2092 20.0301 15.4566L18.6868 16.8L15.5522 13.6655C15.3048 13.4181 14.904 13.4181 14.6566 13.6655C14.4092 13.9129 14.4092 14.3136 14.6566 14.5611L18.2389 18.1433C18.3626 18.267 18.5247 18.3289 18.6867 18.3289C18.8487 18.3289 19.0108 18.267 19.1345 18.1433ZM22.7181 14.5611L24.5093 12.7693C24.7566 12.5219 24.7566 12.1211 24.5092 11.8737C24.2618 11.6263 23.8611 11.6263 23.6136 11.8737L22.2703 13.2176L21.3738 12.3214L22.2703 11.4259C22.5177 11.1791 22.5176 10.7777 22.2703 10.5303C22.0229 10.2829 21.6222 10.2829 21.3747 10.5303L20.4782 11.426L19.5823 10.5303L20.9257 9.18697C21.1731 8.93962 21.1731 8.53884 20.9257 8.29142C20.6783 8.044 20.2775 8.044 20.0301 8.29142L18.239 10.0826C18.1202 10.2013 18.0534 10.3621 18.0534 10.5304C18.0534 10.6987 18.1202 10.8594 18.239 10.9782L20.0298 12.7687C20.0298 12.7687 20.0298 12.7688 20.0298 12.769C20.0299 12.7691 20.0299 12.7692 20.0301 12.7693L20.031 12.7699L21.8225 14.5611C21.9412 14.6798 22.102 14.7466 22.2703 14.7466C22.4386 14.7466 22.5993 14.6798 22.7181 14.5611ZM12.6799 17.6956C12.6799 17.5268 12.7455 17.3678 12.8655 17.2478C13.1129 17.0004 13.5136 17.0004 13.7611 17.2478L15.1045 18.5912L14.209 19.487L12.8655 18.1428C12.7455 18.024 12.6799 17.8651 12.6799 17.6956Z"/></svg>';

        return $tab_icon;

    }//end coupon_tab_icon()


    /**
     * Pop style icon svg
     *
     * @return $popup_style_icon array of svgs
     */
    public static function coupon_popup_style_icon()
    {
        $popup_style_icon['slide-in-popup'] = '<svg xmlns="http://www.w3.org/2000/svg" width="261" height="173" viewBox="0 0 261 173"><defs><style>.a,.d,.f{fill:#fff;}.a{stroke:#aeaeae;}.b{fill:#f6f5fd;stroke:#d9d7e2;stroke-width:0.6px;}.c{fill:#f0eff4;}.e{fill:#dddcec;}.f{stroke:#d2d2d8;stroke-width:0.4px;}.g{fill:#ebebf5;}.h{fill:#7e5ce7;}.i{fill:#1e1e1e;font-size:7px;font-family:EuclidCircularB-SemiBold, Euclid Circular B;font-weight:600;}.j{fill:#747488;}.k{stroke:none;}.l{fill:none;}</style></defs><g transform="translate(-300 -473)"><g class="a" transform="translate(300 473)"><rect class="k" width="261" height="173" rx="10"/><rect class="l" x="0.5" y="0.5" width="260" height="172" rx="9.5"/></g><g transform="translate(905 -185)"><g transform="translate(-594 669)"><g class="b" transform="translate(0 0)"><rect class="k" width="239" height="151" rx="4"/><rect class="l" x="0.3" y="0.3" width="238.4" height="150.4" rx="3.7"/></g><g transform="translate(7.092 21.274)"><rect class="c" width="41" height="15" transform="translate(-0.091 -0.274)"/><rect class="c" width="41" height="32" transform="translate(-0.091 91.726)"/><rect class="c" width="41" height="32" transform="translate(46.909 91.726)"/><rect class="c" width="41" height="32" transform="translate(93.908 91.726)"/><rect class="c" width="135" height="68" transform="translate(-0.091 19.726)"/><rect class="c" width="85" height="13" transform="translate(140.908 19.726)"/><rect class="c" width="85" height="33" transform="translate(140.908 55.726)"/><rect class="c" width="85" height="4" transform="translate(140.908 36.726)"/><rect class="c" width="85" height="5" transform="translate(140.908 92.726)"/><rect class="c" width="85" height="2" transform="translate(140.908 42.726)"/><rect class="c" width="85" height="2" transform="translate(140.908 99.726)"/><rect class="c" width="85" height="2" transform="translate(140.908 48.726)"/><rect class="c" width="85" height="2" transform="translate(140.908 105.726)"/><rect class="c" width="85" height="4" transform="translate(140.908 109.726)"/><rect class="c" width="85" height="2" transform="translate(140.908 115.726)"/><rect class="c" width="85" height="3" transform="translate(140.908 120.726)"/><rect class="c" width="38" height="6" transform="translate(48.909 3.726)"/><rect class="c" width="39" height="6" transform="translate(94.908 3.726)"/><rect class="c" width="38" height="6" transform="translate(141.908 3.726)"/><rect class="c" width="37" height="6" transform="translate(188.908 3.726)"/></g></g><path class="d" d="M3,0H234a3,3,0,0,1,3,3V16a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V3A3,3,0,0,1,3,0Z" transform="translate(-593 670)"/><ellipse class="e" cx="2" cy="2.5" rx="2" ry="2.5" transform="translate(-587 676)"/><circle class="e" cx="2.5" cy="2.5" r="2.5" transform="translate(-578 676)"/><circle class="e" cx="2.5" cy="2.5" r="2.5" transform="translate(-569 676)"/></g><g transform="translate(-96.365 35.064)"><g class="f" transform="translate(547.365 536.936)"><rect class="k" width="93" height="57" rx="4"/><rect class="l" x="0.2" y="0.2" width="92.6" height="56.6" rx="3.8"/></g><rect class="g" width="85" height="2" rx="1" transform="translate(551.365 561.936)"/><rect class="g" width="85" height="2" rx="1" transform="translate(551.365 557.936)"/><rect class="h" width="85" height="10" rx="1" transform="translate(551.365 579.936)"/><text class="i" transform="translate(557.365 551.936)"><tspan x="0" y="0">Your headline is here</tspan></text><g transform="translate(633.692 540.408)"><rect class="j" width="0.743" height="4.461" transform="translate(3.154 0) rotate(45)"/><rect class="j" width="0.743" height="4.461" transform="translate(3.68 3.154) rotate(135)"/></g><rect class="g" width="85" height="8" rx="1" transform="translate(551.365 567.936)"/></g></g></svg>';

        return $popup_style_icon;

    }//end coupon_popup_style_icon()


    /**
     * Custom icon svg
     *
     * @return $icon string svg
     */
    public static function custom_tab_icon()
    {
        $icon = '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="18" r="18"/><path d="M24.7528 25.463H20.8737H19.8292H19.6036V20.2599H21.3053C21.7368 20.2599 21.9918 19.7695 21.7368 19.4164L18.4266 14.8361C18.2158 14.5419 17.7793 14.5419 17.5685 14.8361L14.2583 19.4164C14.0033 19.7695 14.2534 20.2599 14.6898 20.2599H16.3915V25.463H16.1659H15.1214H10.6244C8.04986 25.3208 6 22.913 6 20.304C6 18.5043 6.97589 16.935 8.42256 16.0866C8.29015 15.7286 8.2215 15.3461 8.2215 14.944C8.2215 13.105 9.7074 11.6191 11.5464 11.6191C11.9436 11.6191 12.3261 11.6878 12.6841 11.8202C13.7483 9.56436 16.0433 8 18.7111 8C22.1635 8.0049 25.0078 10.6481 25.3314 14.0172C27.9845 14.4732 30 16.9301 30 19.7107C30 22.6825 27.6853 25.257 24.7528 25.463Z" fill="#FFFBFB"/></svg>';
        return $icon;

    }//end custom_tab_icon()


    /**
     * Svgs for widget type
     *
     * @return $icon Array of svgs
     */
    public static function coupon_type()
    {
        $icon['coupon_cpy'] = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M29.3633 16.3938C29.241 16.1435 29.241 15.8565 29.3633 15.6063L30.4972 13.2868C31.1284 11.9954 30.6283 10.4561 29.3585 9.78236L27.0779 8.57232C26.8319 8.44181 26.6632 8.20954 26.615 7.93529L26.169 5.39235C25.9206 3.97651 24.611 3.02509 23.1879 3.22643L20.6317 3.58802C20.3558 3.62697 20.083 3.53826 19.8828 3.34465L18.0273 1.54964C16.9941 0.550133 15.3756 0.550074 14.3425 1.54964L12.4869 3.34482C12.2867 3.5385 12.0139 3.62703 11.738 3.5882L9.18178 3.22661C7.75828 3.02515 6.44908 3.97668 6.20071 5.39252L5.75469 7.93535C5.70654 8.20966 5.53786 8.44187 5.29187 8.57244L3.0113 9.78248C1.74152 10.4561 1.24136 11.9955 1.87262 13.287L3.00638 15.6064C3.12869 15.8567 3.12869 16.1437 3.00638 16.3939L1.87256 18.7133C1.2413 20.0047 1.74146 21.544 3.01124 22.2177L5.29181 23.4278C5.53786 23.5583 5.70654 23.7905 5.75469 24.0648L6.20071 26.6077C6.42681 27.8966 7.532 28.8006 8.8022 28.8004C8.9273 28.8004 9.05424 28.7916 9.18184 28.7736L11.7381 28.412C12.0138 28.3729 12.2868 28.4618 12.487 28.6554L14.3425 30.4504C14.8592 30.9502 15.5219 31.2 16.1849 31.2C16.8477 31.1999 17.5108 30.9501 18.0272 30.4504L19.8828 28.6554C20.083 28.4618 20.3559 28.3733 20.6317 28.412L23.1879 28.7736C24.6116 28.975 25.9206 28.0235 26.169 26.6077L26.6151 24.0649C26.6632 23.7905 26.8319 23.5583 27.0779 23.4278L29.3585 22.2177C30.6283 21.5441 31.1284 20.0047 30.4972 18.7132L29.3633 16.3938ZM12.6782 8.11003C14.4506 8.11003 15.8926 9.55205 15.8926 11.3245C15.8926 13.0969 14.4506 14.539 12.6782 14.539C10.9057 14.539 9.46369 13.0969 9.46369 11.3245C9.46369 9.55205 10.9057 8.11003 12.6782 8.11003ZM11.019 22.4056C10.8478 22.5768 10.6234 22.6624 10.3991 22.6624C10.1748 22.6624 9.95038 22.5768 9.77926 22.4056C9.43691 22.0632 9.43691 21.5081 9.77926 21.1658L21.3507 9.59439C21.693 9.25203 22.2481 9.25203 22.5905 9.59439C22.9328 9.93674 22.9328 10.4918 22.5905 10.8342L11.019 22.4056ZM19.6914 23.8901C17.919 23.8901 16.477 22.448 16.477 20.6756C16.477 18.9031 17.919 17.4611 19.6914 17.4611C21.4639 17.4611 22.9059 18.9031 22.9059 20.6756C22.9059 22.448 21.4639 23.8901 19.6914 23.8901ZM19.6915 19.2145C18.8858 19.2145 18.2303 19.87 18.2303 20.6756C18.2303 21.4813 18.8858 22.1367 19.6915 22.1367C20.4971 22.1367 21.1525 21.4813 21.1525 20.6756C21.1525 19.87 20.4971 19.2145 19.6915 19.2145ZM11.2171 11.3244C11.2171 10.5188 11.8725 9.86336 12.6782 9.86336C13.4838 9.86336 14.1392 10.5189 14.1393 11.3244C14.1393 12.1302 13.4838 12.7856 12.6782 12.7856C11.8725 12.7856 11.2171 12.1301 11.2171 11.3244Z"/></svg>';
        $icon['link']       = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M20.1997 3.67918C22.4386 1.44027 26.0814 1.44027 28.3208 3.67918C30.5597 5.91808 30.5597 9.56082 28.3208 11.7997L23.1917 16.9289C23.3426 15.5945 23.1107 14.2027 22.519 12.9613L26.0004 9.47988C26.9635 8.51683 26.9635 6.96262 26.0004 5.99957C25.0374 5.03652 23.4832 5.03652 22.5201 5.99957L14.1201 14.3996C13.1571 15.3626 13.1571 16.9168 14.1201 17.8799C14.3285 18.0888 14.5609 18.2277 14.8042 18.3557L12.4264 20.7335C12.2175 20.5716 11.9971 20.3971 11.7997 20.2003C11.6461 20.0466 11.5137 19.8722 11.3859 19.7039C11.3495 19.6559 11.3135 19.6084 11.2775 19.5621L11.266 19.5736C9.61331 17.3702 9.74292 14.136 11.7997 12.0792L20.1997 3.67918ZM20.3341 12.5756C20.3705 12.6236 20.4065 12.6711 20.4425 12.7174L20.454 12.7059C22.1072 14.9098 21.9765 18.144 19.9203 20.2003L11.7997 28.3208C9.56082 30.5597 5.91808 30.5597 3.67918 28.3208C1.44027 26.0819 1.44027 22.4392 3.67918 20.2003L8.52832 15.3511C8.37738 16.685 8.6098 18.0773 9.20098 19.3187L5.99902 22.5201C5.03652 23.4832 5.03652 25.0379 5.99902 26.0004C6.96207 26.9635 8.51683 26.9635 9.47933 26.0004L17.6004 17.8799C18.5629 16.9168 18.5629 15.3626 17.6004 14.3996C17.3915 14.1907 17.1596 14.0518 16.9157 13.9238L19.2941 11.546C19.503 11.7084 19.7234 11.8823 19.9203 12.0792C20.0739 12.2328 20.2063 12.4073 20.3341 12.5756Z"/></svg>';
        $icon['email']      = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4708 15.0803C16.6873 15.6027 15.3128 15.6027 14.5294 15.0804L14.529 15.0802L1.17715 6.179C1.61515 4.91243 2.81885 4 4.23243 4H27.7676C29.1811 4 30.3848 4.91243 30.8228 6.179L17.4712 15.0801L17.4708 15.0803ZM18.4458 16.5431L18.4462 16.5428L31 8.17352V23.2365C31 25.0187 29.55 26.4687 27.7677 26.4687H4.23241C2.45003 26.4687 1 25.0187 1 23.2365V8.17352L13.554 16.5428L13.5543 16.543C14.2401 17.0002 15.1199 17.2287 16 17.2287C16.8799 17.2287 17.7601 17.0001 18.4458 16.5431Z"/></svg>
            ';
        return $icon;

    }//end coupon_type()


    /**
     * Build and render tab css in dashboard
     *
     * @param : $settings array of widget settings.
     *
     * @return $css string of style
     */
    public static function get_tab_css($settings)
    {

        $icon_size  = (( $settings['tab_size'] * 64 ) / 100);
        $size       = ($icon_size / 2);
        $tab_height = $settings['tab_size'];
        if ('hexagon' === $settings['tab_shape']) {
            $tab_height = ($tab_height / sqrt(3));
        }

        $str = '';
        if ('' === $settings['call_action']) {
            $str = 'display: none';
        }

        $font = explode('-', $settings['font']);

        $font_type   = str_replace('_', ' ', $font[0]);
        $font_family = str_replace('_', ' ', $font[1]);

        if ('System stack' === $font_family) {
            $font_family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
        } else {
            $font_url = 'https://fonts.googleapis.com/css?family='.esc_attr($font_family).':400,500,600,700';
            wp_enqueue_style('google-font', $font_url);
        }

        $css = '
            .tab-preview .preview-box,
            .popup-preview .preview-box{ font-family:'.esc_attr($font_family).'; }
            .popup-preview .preview-box button{ font-family:'.esc_attr($font_family).' !important; }
            .preview-box .tab-icon svg{fill:'.esc_attr($settings['icon_color']).'; }
            .preview-box .tab-box.couponapp-tab-shape-hexagon .tab-icon {
                width: '.esc_attr($settings['tab_size']).'px;
                height: '.esc_attr($tab_height).'px;
                position: relative;
                background-color:'.esc_attr($settings['tab_color']).';
            }
            .preview-box .tab-box .tab-icon {
               
                background-color:'.esc_attr($settings['tab_color']).';
            }
            .preview-box .tab-box.couponapp-tab-shape-hexagon .after,
            .preview-box .tab-box.couponapp-tab-shape-hexagon .before {
            	width: '.esc_attr($settings['tab_size']).'px;

            }
            .preview-box .tab-box.couponapp-tab-shape-hexagon .tab-icon {
            	padding: 0;
            }
            .preview-box .tab-icon{
            	width:'.esc_attr($settings['tab_size']).'px;
                height:'.esc_attr($settings['tab_size']).'px;
            }
            .preview-box .tab-icon svg  {
                width:'.esc_attr($icon_size).'px;
                height:'.esc_attr($icon_size).'px;
                top: calc(50% - '.esc_attr($size).'px);
                left:calc(50% - '.esc_attr($size).'px);
                position: absolute;
            }
            .preview-box .tab-text{
                background-color: '.esc_attr($settings['action_bgcolor']).';
                color:'.esc_attr($settings['action_color']).';
            }
            .preview-box .tab-box.couponapp-position-right .tab-text:after{
                border-left-color:'.esc_attr($settings['action_bgcolor']).';
                border-right-color:transparent;     
                '.esc_attr($str).'
            }
            .preview-box .tab-box.couponapp-position-left .tab-text:after{
                border-right-color: '.esc_attr($settings['action_bgcolor']).';
                border-left-color:transparent;
                '.esc_attr($str).'
            }
            #coupon-pending-message {
                color: '.esc_attr($settings['no_color']).'; 
                background: '.esc_attr($settings['no_bgcolor']).' none repeat scroll 0% 0%
            }
            .icon-img {
            	background-color:'.esc_attr($settings['tab_color']).';
            }
            .hexagon-after, .hexagon-before {
                
                height: '.esc_attr(($settings['tab_size'] / sqrt(3))).'px 
            } 
            ';
        return $css;

    }//end get_tab_css()


    /**
     * Build and render tab css on frontend
     *
     * @param : $settings array of widget settings.
     *
     * @return $css string of style
     */
    public static function get_tab_css_frontend($settings)
    {

        $icon_size  = (( $settings['tab_size'] * 64 ) / 100);
        $size       = ($icon_size / 2);
        $tab_height = $settings['tab_size'];
        if ('hexagon' === $settings['tab_shape']) {
            $tab_height = ($tab_height / sqrt(3));
        }

        $str = '';
        if ('' === $settings['call_action']) {
            $str = 'display: none';
        }

        $font = [];
        $showIcon = isset($settings['show_icon']) ? $settings['show_icon'] : 1;
        $popupFont = isset($popupSettings['font']) ? $popupSettings['font'] : 'Google_Fonts-Poppins';
        if($showIcon == 1) {
            $font = explode('-', $settings['font']);
        } else {
            $font = explode('-', $popupFont);
        }
        $font_type   = str_replace('_', ' ', $font[0]);
        $font_family = str_replace('_', ' ', $font[1]);
        $css         = '
            .tab-front-box{ font-family:'.esc_attr($font_family).'; }
            .tab-front-box button{ font-family:'.esc_attr($font_family).' !important; }
            .tab-front-box .tab-icon svg{fill:'.esc_attr($settings['icon_color']).'; }
            .tab-front-box .couponapp-tab-shape-hexagon .tab-icon {
                width: '.esc_attr($settings['tab_size']).'px;
                height: '.esc_attr($settings['tab_size']).'px;
                position: relative;
                background-color:'.esc_attr($settings['tab_color']).';
            }
            .tab-front-box .couponapp-tab-shape-hexagon .after,
            .tab-front-box .couponapp-tab-shape-hexagon .before {
            	width: '.esc_attr($settings['tab_size']).'px;

            }
            .tab-front-box.couponapp-tab-shape-hexagon .tab-icon {
            	padding: 0;
            }
            .tab-front-box .tab-icon{
            	width:'.esc_attr($settings['tab_size']).'px;
                height:'.esc_attr($settings['tab_size']).'px;
                position: relative
            }
            .tab-front-box .tab-icon svg  {
                width:'.esc_attr($icon_size).'px;
                height:'.esc_attr($icon_size).'px;
                top: calc(50% - '.esc_attr($size).'px);
                left:calc(50% - '.esc_attr($size).'px);
                position: absolute;
            }
            .tab-front-box .tab-text{
                background-color: '.esc_attr($settings['action_bgcolor']).';
                color:'.esc_attr($settings['action_color']).';
            }
            .tab-front-box.couponapp-position-right .tab-text:after{
                border-left-color:'.esc_attr($settings['action_bgcolor']).';
                border-right-color:transparent;     
                '.esc_attr($str).'
            }
            .tab-front-box.couponapp-position-left .tab-text:after{
                border-right-color: '.esc_attr($settings['action_bgcolor']).' !important;
                border-left-color:transparent  !important;
                '.esc_attr($str).'
            }
            .coupon-pending-message {
                color: '.esc_attr($settings['no_color']).'  !important; 
                background: '.esc_attr($settings['no_bgcolor']).' none repeat scroll 0% 0%  !important
            }
            .hexagon-after, .hexagon-before {
                background-color:'.esc_attr($settings['tab_color']).'
            } 
            .email-content-checkbox {
            	font-size:14px
            }

            ';
        return $css;

    }//end get_tab_css_frontend()


    /**
     * Build and render widget css on frontend
     *
     * @param : $settings  array of widget settings.
     * @param : $widget_id int widget id.
     *
     * @return $css string of style
     */
    public static function get_css_frontend($settings, $widget_id)
    {
        $widgetcounter = $widget_id;

        $showIcon = isset($settings['tab']['show_icon']) ? $settings['tab']['show_icon'] : 1;
        $popupFont = isset($settings['popup']['font']) ? $settings['popup']['font'] : 'Google_Fonts-Poppins';
        if($showIcon == 1){
            $font = explode('-', $settings['tab']['font']);
            $bottomSpacing = $settings['tab']['bottom_spacing'];
            $sideSpacing = $settings['tab']['side_spacing'];
        } else {
            $font = explode('-', $popupFont);
            $bottomSpacing = $settings['popup']['bottom_spacing'];
            $sideSpacing = $settings['popup']['side_spacing'];
        }
        $font_type   = str_replace('_', ' ', $font[0]);
        $font_family = str_replace('_', ' ', $font[1]);

        if ('System stack' === $font_family) {
            $font_family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
        }

        $tab_size  = $settings['tab']['tab_size'];
        $tab_shape = $settings['tab']['tab_shape'];

        $tab_height = $tab_size;
        if ('hexagon' === $tab_shape) {
            $tab_height = ($tab_height / sqrt(3));
        }

        $icon_size = (( $tab_size * 64 ) / 100);
        $css       = '
			.sr-only {
				border: 0 !important;
				clip: rect(1px, 1px, 1px, 1px) !important;
				-webkit-clip-path: inset(50%) !important;
				clip-path: inset(50%) !important;
				height: 1px !important;
				margin: -1px !important;
				overflow: hidden !important;
				padding: 0 !important;
				position: absolute !important;
				white-space: nowrap !important;
				width: auto;
			}

			#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.couponapp-tab-shape-hexagon .tab-icon,
			#tab-box-front-'.esc_attr($widgetcounter).'.tab-box .tab-icon{
				width: '.esc_attr($tab_size).'px;
				height: '.esc_attr($tab_height).'px;
				cursor: pointer;
			}
			#tab-box-front-'.esc_attr($widgetcounter).'.tab-box .tab-icon svg{
				width: '.esc_attr($icon_size).'px;
				height: '.esc_attr($icon_size).'px;
				top: calc(50% - '.esc_attr($icon_size / 2).'px);
				left:calc(50% - '.esc_attr($icon_size / 2).'px);
			}
			#tab-box-front-'.esc_attr($widgetcounter).',
			#tab-box-front-'.esc_attr($widgetcounter).' h4,
			#tab-box-front-'.esc_attr($widgetcounter).' .coupon-button,
			#tab-box-front-'.esc_attr($widgetcounter).' input
			{ font-family: '.esc_attr($font_family).' !important}
			#tab-box-front-'.esc_attr($widgetcounter).'.couponapp-position-custom.couponapp-position-left {

				bottom: '.esc_attr($bottomSpacing).'px;
				left: '.esc_attr($sideSpacing).'px;
				font-family'.esc_attr($font_family).'
			}

			#tab-box-front-'.esc_attr($widgetcounter).'.couponapp-position-custom.couponapp-position-right {
				bottom: '.esc_attr($bottomSpacing).'px;
				right: '.esc_attr($sideSpacing).'px;}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-text { 
				color: '.esc_attr($settings['tab']['action_color']).';
				background-color: '.esc_attr($settings['tab']['action_bgcolor']).';}

			#tab-box-front-'.esc_attr($widgetcounter).'.couponapp-position-right .tab-text:after{ 
				border-left-color:'.esc_attr($settings['tab']['action_bgcolor']).';
				border-right-color:transparent; '.( ( '' === $settings['tab']['call_action'] ) ? 'display:none' : '' ).'}

			#tab-box-front-'.esc_attr($widgetcounter).'.couponapp-position-left .tab-text:after{ 
				border-right-color:'.esc_attr($settings['tab']['action_bgcolor']).';
				border-left-color:transparent; '.( ( '' === $settings['tab']['call_action'] ) ? 'display:none' : '' ).'}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-icon,
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-icon .hexagon-after,
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-icon .hexagon-before{ background-color: '.esc_attr($settings['tab']['tab_color']).';}
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-icon svg{
				fill: '.esc_attr($settings['tab']['icon_color']).';
			}
			

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content .coupon-code-email-text input{ 
				color: '.esc_attr($settings['main']['text_color']).';
				background-color: '.esc_attr($settings['main']['email_color']).';}
	

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content .coupon-button.coupon-email-button { 
				color: '.esc_attr($settings['main']['btn_text_color']).';
				background-color: '.esc_attr($settings['main']['btn_color']).';}

			

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content {
			 background-color: '.esc_attr($settings['main']['bgcolor']).';}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-code-email-text input{ 
			 color: '.esc_attr($settings['main']['text_color']).';
			 box-shadow: none !important;
			 background-color: '.esc_attr($settings['main']['email_color']).';}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-code-email-text input::placeholder{ 
			 color: '.esc_attr($settings['main']['text_color']).';}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-code-email-text input:-ms-input-placeholder{ 
			 color: '.esc_attr($settings['main']['text_color']).';}
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-code-email-text input::-ms-input-placeholder{ 
			 color: '.esc_attr($settings['main']['text_color']).';}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-button{ 
			 color: '.esc_attr($settings['main']['text_color']).';
			 background-color: '.esc_attr($settings['main']['email_color']).';}

			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-email-content .coupon-button.coupon-email-button { 
			 color: '.esc_attr($settings['main']['btn_text_color']).';
			 background-color: '.esc_attr($settings['main']['btn_color']).';}

			@media screen and (min-width: 769px) {
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.tab-front-box.couponapp-desktop{ 
				display: block;
				}
			}
			@media screen and (max-width: 768px) {
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.tab-front-box.couponapp-mobile {
					display:block
				}
			}
			'.esc_attr($settings['popup']['custom_css']).'							
			
			
			#tab-box-front-0 .tab-box-content.tab-box-email-content {
			    background-color:'.esc_attr($settings['main']['bgcolor']).'
			}
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-email-content .form-wrap{
				border-color:'.esc_attr($settings['main']['email_brdcolor']).';
				background-color:'.esc_attr($settings['main']['email_color']).'
			}
			.coupon-email-error {
            	color : '.esc_attr($settings['main']['error_color']).';
            	font-size: 12px
            }
		';
        if ((isset($settings['popup']['style']) && $settings['popup']['style'] === 'style-2') && 1 === (int) @$settings['coupon']['enable_styles']) {
            $css .= '#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content { 
				background-color: '.esc_attr($settings['main']['bgcolor']).';}
				#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content .coupon-code-text{ 
					color: '.esc_attr($settings['main']['text_color']).';
					background-color: '.esc_attr($settings['main']['email_color']).';}
				
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box-content.couponapp-email-code-option .form-wrap, 
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.couponapp-style-1 .tab-box-couponcode-content .form-wrap, 
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.couponapp-style-2 .tab-box-couponcode-content .form-wrap{
					border-color:'.esc_attr($settings['main']['email_brdcolor']).';
					background-color: '.esc_attr($settings['main']['email_color']).';
				}
				.coupon-tab-close svg{
					fill:'.esc_attr($settings['coupon']['clsbtn_color']).'
				}
				#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content .coupon-button{ 
					color: '.esc_attr($settings['main']['btn_text_color']).';
					background-color: '.esc_attr($settings['main']['btn_color']).';}';
        } else {
            $css .= '#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content { 
				background-color: '.esc_attr($settings['coupon']['bg_color']).';}
	
				#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content .coupon-code-text{ color: '.esc_attr($settings['coupon']['text_color']).';
					background-color: '.esc_attr($settings['coupon']['coupon_color']).';}
				
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box-content.couponapp-email-code-option .form-wrap, 
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.couponapp-style-1 .tab-box-couponcode-content .form-wrap, 
				#tab-box-front-'.esc_attr($widgetcounter).'.tab-box.couponapp-style-2 .tab-box-couponcode-content .form-wrap{
					border-color:'.esc_attr($settings['coupon']['coupon_brdcolor']).';
					background-color: '.esc_attr($settings['coupon']['coupon_color']).';
				}
				.coupon-tab-close svg{
					fill:'.esc_attr($settings['coupon']['clsbtn_color']).'
				}
				#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-content.tab-box-couponcode-content .coupon-button{ 
					color: '.esc_attr($settings['coupon']['txt_color']).';
					background-color: '.esc_attr($settings['coupon']['btn_color']).';}';
        }//end if

        if ('style-5' === $settings['popup']['style'] && 1 === (int) @$settings['announcement']['enable_styles']) {
            $css .= '#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-an{ 
				background-color: '.esc_attr($settings['main']['bgcolor']).' !important;
				
			}
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-an .coupon-button{ 
				background-color: '.esc_attr($settings['main']['btn_color']).' !important;
				color: '.esc_attr($settings['main']['btn_text_color']).' !important;
				
			}';
        } else {
            $css .= '#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-an{ 
				background-color: '.esc_attr($settings['announcement']['bg_color']).' !important;
				
			}
			#tab-box-front-'.esc_attr($widgetcounter).' .tab-box-an .coupon-button{ 
				background-color: '.esc_attr($settings['announcement']['btn_color']).' !important;
				color: '.esc_attr($settings['announcement']['txt_color']).' !important;
				
			}';
        }//end if

        return $css;

    }//end get_css_frontend()


    /**
     * Return pop up preview styles in backend.
     *
     * @param  options $options : widget settings.
     * @return $css css of preview elements.
     */
    public static function get_popup_css_backend($options)
    {

        $coupon_settings = $options['coupon'];

        $css           = '.close-design-popup {
			color: '.esc_attr($coupon_settings['clsbtn_color']).'
		}';

        $showIcon = isset($options['tab']['show_icon']) ? $options['tab']['show_icon'] : 1;
        $popupFont = isset($options['popup']['font']) ? $options['popup']['font'] : 'Google_Fonts-Poppins';
        if($showIcon == 1) {
            $font = explode('-', $options['tab']['font']);
        } else {
            $font = explode('-', $popupFont);
        }
        $font_family = str_replace('_', ' ', $font[1]);
        if ('System stack' === $font_family) {
            $font_family = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
        } else {
            $font_url = 'https://fonts.googleapis.com/css?family=' . $font_family . ':400,500,600,700';
            wp_enqueue_style('google-preview-font', $font_url);
        }
        $css .= '.tab-preview .preview-box,
            .popup-preview .preview-box{ font-family:' . esc_attr($font_family) . '; }
            .popup-preview .preview-box button{ font-family:' . esc_attr($font_family) . ' !important; }';

        $enable_styles = isset($options['coupon']['enable_styles']) ? $options['coupon']['enable_styles'] : 0;
        if ('style-2' === $options['popup']['style'] && 1 === (int) $enable_styles) {
            $css .= '.couponapp-email-code-option { 
				background-color: '.esc_attr($options['main']['bgcolor']).';}
				.couponapp-email-code-option .coupon-code-text{ 
					color: '.esc_attr($options['main']['text_color']).' !important;
					background-color: '.esc_attr($options['main']['email_color']).' !important;}
				
				.couponapp-email-code-option .form-wrap
				{
					border-color:'.esc_attr($options['main']['email_brdcolor']).' !important;
					background-color: '.esc_attr($options['main']['email_color']).' !important;
				}
				.coupon-tab-close svg{
					fill:'.esc_attr($options['coupon']['clsbtn_color']).'
				}
				.couponapp-email-code-option #coupon-buttonn{ 
					color: '.esc_attr($options['main']['btn_text_color']).'  !important;
					background-color: '.esc_attr($options['main']['btn_color']).'  !important;}';
        } else {
            $css .= '.couponapp-email-code-option{ 
				background-color: '.esc_attr($options['coupon']['bg_color']).';}
				.couponapp-email-code-option .coupon-code-text{ color: '.esc_attr($options['coupon']['text_color']).';
					background-color: '.esc_attr($options['coupon']['coupon_color']).';}
				
				.couponapp-email-code-option .form-wrap{
					border-color:'.esc_attr($options['coupon']['coupon_brdcolor']).' !important;
					background-color: '.esc_attr($options['coupon']['coupon_color']).' !important;
				}
				.coupon-tab-close svg{
					fill:'.esc_attr($options['coupon']['clsbtn_color']).'
				}
				.couponapp-email-code-option #coupon-buttonn{ 
					color: '.esc_attr($options['coupon']['txt_color']).' !important;
					background-color: '.esc_attr($options['coupon']['btn_color']).'  !important;}';
        }//end if

        if ('style-5' === $options['popup']['style'] && 1 === (int) @$options['announcement']['enable_styles']) {
            $css .= '.couponapp-no-coupon-option{ 
				background-color: '.esc_attr($options['main']['bgcolor']).';
			}
			.couponapp-no-coupon-option #announcement-button{ 
				background-color: '.esc_attr($options['main']['btn_color']).' !important;
				color: '.esc_attr($options['main']['btn_text_color']).' !important;
				
			}';
        } else {
            $css .= '.couponapp-no-coupon-option { 
				background-color: '.esc_attr($options['announcement']['bg_color']).';
				
			}
			.couponapp-no-coupon-option #announcement-button{ 
				background-color: '.esc_attr($options['announcement']['btn_color']).' !important;
				color: '.esc_attr($options['announcement']['txt_color']).' !important;
				
			}';
        }//end if

        return $css;

    }//end get_popup_css_backend()


    /**
     * Valid svg tags.
     */
    public static function get_svg_ruleset()
    {

        $svg_args = [
            'svg'   => [
                'class'           => true,
                'aria-hidden'     => true,
                'aria-labelledby' => true,
                'role'            => true,
                'xmlns'           => true,
                'width'           => true,
                'height'          => true,
                'viewbox'         => true,
        // <= Must be lower case!
            ],
            'g'     => [ 'fill' => true ],
            'title' => [ 'title' => true ],
            'path'  => [
                'd'    => true,
                'fill' => true,
            ],
        ];
        return $svg_args;

    }//end get_svg_ruleset()


    /**
     * List of traffic sources.
     */
    public static function coupon_traffic_source()
    {
        $traffic_source = [
            'search_engine' => [
                'accoona',
                'ansearch',
                'biglobe',
                'daum',
                'egerin	',
                'leit.is',
                'maktoob',
                'miner.hu',
                'najdi.si',
                'najdi.org',
                'naver',
                'rambler',
                'rediff',
                'sapo',
                'search.ch',
                'sesam',
                'seznam',
                'walla',
                'zipLoca',
                'slurp',
                'search.msn.com',
                'nutch',
                'simpy',
                'bot.',
                'aspSeek',
                'crawler.',
                'msnbot',
                'libwww-perl',
                'fast',
                'baidu.',
                'bing.',
                'google.',
                'duckduckgo',
                'ecosia',
                'exalead',
                'giablast',
                'munax',
                'qwant',
                'sogou',
                'soso',
                'yahoo.',
                'yandex.',
                'youdao',
                'aol.',
                'hotbot.',
                'webcrawler.',
                'eniro',
                'naver',
                'lycos',
                'ask',
                'altavista',
                'netscape',
                'about',
                'mamma',
                'alltheweb',
                'voila',
                'live',
                'alice',
                'mama',
                'wp.pl',
                'onecenter',
                'szukacz',
                'yam',
                'kvasir',
                'ozu',
                'terra',
                'pchome',
                'mynet',
                'ekolay',
                'rembler',
            ],
            'social_media'  => [
                'facebook.',
                'instagram.',
                'linkedin.',
                'myspace.',
                'twitter.',
                't.co',
                'plus.google',
                'disqus.',
                'snapchat.',
                'tumbler.',
                'pinterest.',
                'twoo',
                'mymfb',
                'youtube.',
                'vine',
                'whatsapp',
                'vk.com',
                'secret',
                'medium',
                'bebo',
                'friendster',
                'hi5',
                'habbo',
                'ning',
                'classmates',
                'tagged',
                'myyearbook',
                'meetup',
                'mylife',
                'reunion',
                'flixster',
                'myheritage',
                'multiply',
                'orkut',
                'badoo',
                'gaiaonline',
                'blackplanet',
                'skyrock',
                'perfspot',
                'zorpia',
                'netlog',
                'tuenti',
                'nasza-klasa.pl',
                'irc-gallery',
                'studivz',
                'xing',
                'renren',
                'kaixin001',
                'hyves.nl',
                'MillatFacebook',
                'ibibo',
                'sonico',
                'wer-kennt-wen',
                'cyworld',
                'iwiw',
                'dribbble.',
                'stumbleupon.',
                'flickr.',
                'plaxo.',
                'digg.',
                'del.icio.us',
            ],
        ];

        return $traffic_source;

    }//end coupon_traffic_source()

    public static function color_picker_template($label = "", $id = "", $class = "", $name = "", $value = "") {
        ob_start();
        ?>

        <label class="custom-color-box">
            <div class="custom-color-info">
                <span class="field-color"><?php echo esc_attr($label); ?></span>
                <span class="custom-color-val"><?php echo esc_attr($value); ?></span>
            </div>
            <input type='text' id='<?php echo esc_attr($id); ?>' class='<?php echo esc_attr($class); ?>' name='<?php echo esc_attr($name); ?>' value='<?php echo esc_attr($value); ?>' />
        </label>

        <?php
        return ob_get_clean();
    }

}//end class