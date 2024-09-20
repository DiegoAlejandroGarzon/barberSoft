<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array de departamentos
        $departments = [
            ['code_dane' => '05', 'name' => 'ANTIOQUIA'],
            ['code_dane' => '08', 'name' => 'ATLANTICO'],
            ['code_dane' => '11', 'name' => 'BOGOTA'],
            ['code_dane' => '13', 'name' => 'BOLIVAR'],
            ['code_dane' => '15', 'name' => 'BOYACA'],
            ['code_dane' => '17', 'name' => 'CALDAS'],
            ['code_dane' => '18', 'name' => 'CAQUETA'],
            ['code_dane' => '19', 'name' => 'CAUCA'],
            ['code_dane' => '20', 'name' => 'CESAR'],
            ['code_dane' => '23', 'name' => 'CORDOBA'],
            ['code_dane' => '25', 'name' => 'CUNDINAMARCA'],
            ['code_dane' => '27', 'name' => 'CHOCO'],
            ['code_dane' => '41', 'name' => 'HUILA'],
            ['code_dane' => '44', 'name' => 'LA GUAJIRA'],
            ['code_dane' => '47', 'name' => 'MAGDALENA'],
            ['code_dane' => '50', 'name' => 'META'],
            ['code_dane' => '52', 'name' => 'NARIÑO'],
            ['code_dane' => '54', 'name' => 'N. DE SANTANDER'],
            ['code_dane' => '63', 'name' => 'QUINDIO'],
            ['code_dane' => '66', 'name' => 'RISARALDA'],
            ['code_dane' => '68', 'name' => 'SANTANDER'],
            ['code_dane' => '70', 'name' => 'SUCRE'],
            ['code_dane' => '73', 'name' => 'TOLIMA'],
            ['code_dane' => '76', 'name' => 'VALLE DEL CAUCA'],
            ['code_dane' => '81', 'name' => 'ARAUCA'],
            ['code_dane' => '85', 'name' => 'CASANARE'],
            ['code_dane' => '86', 'name' => 'PUTUMAYO'],
            ['code_dane' => '88', 'name' => 'SAN ANDRES'],
            ['code_dane' => '91', 'name' => 'AMAZONAS'],
            ['code_dane' => '94', 'name' => 'GUAINIA'],
            ['code_dane' => '95', 'name' => 'GUAVIARE'],
            ['code_dane' => '97', 'name' => 'VAUPES'],
            ['code_dane' => '99', 'name' => 'VICHADA'],
        ];

        // Insertar departamentos
        foreach ($departments as $deptData) {
            $department = Department::create($deptData);

            // Array de ciudades (ejemplo para Antioquia)
            if ($department->code_dane == '05') {
                $cities = [
                    ['code_dane' => '05001', 'name' => 'MEDELLIN', 'department_id' => $department->id],
                    ['code_dane' => '05002', 'name' => 'ABEJORRAL', 'department_id' => $department->id],
                    ['code_dane' => '05004', 'name' => 'ABRIAQUI', 'department_id' => $department->id],
                    ['code_dane' => '05021', 'name' => 'ALEJANDRIA', 'department_id' => $department->id],
                    ['code_dane' => '05030', 'name' => 'AMAGA', 'department_id' => $department->id],
                    ['code_dane' => '05031', 'name' => 'AMALFI', 'department_id' => $department->id],
                    ['code_dane' => '05034', 'name' => 'ANDES', 'department_id' => $department->id],
                    ['code_dane' => '05036', 'name' => 'ANGELOPOLIS', 'department_id' => $department->id],
                    ['code_dane' => '05038', 'name' => 'ANGOSTURA', 'department_id' => $department->id],
                    ['code_dane' => '05040', 'name' => 'ANORI', 'department_id' => $department->id],
                    ['code_dane' => '05042', 'name' => 'SANTAFE DE ANTIOQUIA', 'department_id' => $department->id],
                    ['code_dane' => '05044', 'name' => 'ANZA', 'department_id' => $department->id],
                    ['code_dane' => '05045', 'name' => 'APARTADO', 'department_id' => $department->id],
                    ['code_dane' => '05051', 'name' => 'ARBOLETES', 'department_id' => $department->id],
                    ['code_dane' => '05055', 'name' => 'ARGELIA', 'department_id' => $department->id],
                    ['code_dane' => '05059', 'name' => 'ARMENIA', 'department_id' => $department->id],
                    ['code_dane' => '05079', 'name' => 'BARBOSA', 'department_id' => $department->id],
                    ['code_dane' => '05086', 'name' => 'BELMIRA', 'department_id' => $department->id],
                    ['code_dane' => '05088', 'name' => 'BELLO', 'department_id' => $department->id],
                    ['code_dane' => '05091', 'name' => 'BETANIA', 'department_id' => $department->id],
                    ['code_dane' => '05093', 'name' => 'BETULIA', 'department_id' => $department->id],
                    ['code_dane' => '05101', 'name' => 'CIUDAD BOLIVAR', 'department_id' => $department->id],
                    ['code_dane' => '05107', 'name' => 'BRICEÑO', 'department_id' => $department->id],
                    ['code_dane' => '05113', 'name' => 'BURITICA', 'department_id' => $department->id],
                    ['code_dane' => '05120', 'name' => 'CACERES', 'department_id' => $department->id],
                    ['code_dane' => '05125', 'name' => 'CAICEDO', 'department_id' => $department->id],
                    ['code_dane' => '05129', 'name' => 'CALDAS', 'department_id' => $department->id],
                    ['code_dane' => '05134', 'name' => 'CAMPAMENTO', 'department_id' => $department->id],
                    ['code_dane' => '05138', 'name' => 'CAÑASGORDAS', 'department_id' => $department->id],
                    ['code_dane' => '05142', 'name' => 'CARACOLI', 'department_id' => $department->id],
                    ['code_dane' => '05145', 'name' => 'CARAMANTA', 'department_id' => $department->id],
                    ['code_dane' => '05147', 'name' => 'CAREPA', 'department_id' => $department->id],
                    ['code_dane' => '05148', 'name' => 'EL CARMEN DE VIBORAL', 'department_id' => $department->id],
                    ['code_dane' => '05150', 'name' => 'CAROLINA', 'department_id' => $department->id],
                    ['code_dane' => '05154', 'name' => 'CAUCASIA', 'department_id' => $department->id],
                    ['code_dane' => '05172', 'name' => 'CHIGORODO', 'department_id' => $department->id],
                    ['code_dane' => '05190', 'name' => 'CISNEROS', 'department_id' => $department->id],
                    ['code_dane' => '05197', 'name' => 'COCORNA', 'department_id' => $department->id],
                    ['code_dane' => '05206', 'name' => 'CONCEPCION', 'department_id' => $department->id],
                    ['code_dane' => '05209', 'name' => 'CONCORDIA', 'department_id' => $department->id],
                    ['code_dane' => '05212', 'name' => 'COPACABANA', 'department_id' => $department->id],
                    ['code_dane' => '05234', 'name' => 'DABEIBA', 'department_id' => $department->id],
                    ['code_dane' => '05237', 'name' => 'DON MATIAS', 'department_id' => $department->id],
                    ['code_dane' => '05240', 'name' => 'EBEJICO', 'department_id' => $department->id],
                    ['code_dane' => '05250', 'name' => 'EL BAGRE', 'department_id' => $department->id],
                    ['code_dane' => '05264', 'name' => 'ENTRERRIOS', 'department_id' => $department->id],
                    ['code_dane' => '05266', 'name' => 'ENVIGADO', 'department_id' => $department->id],
                    ['code_dane' => '05282', 'name' => 'FREDONIA', 'department_id' => $department->id],
                    ['code_dane' => '05284', 'name' => 'FRONTINO', 'department_id' => $department->id],
                    ['code_dane' => '05306', 'name' => 'GIRALDO', 'department_id' => $department->id],
                    ['code_dane' => '05308', 'name' => 'GIRARDOTA', 'department_id' => $department->id],
                    ['code_dane' => '05310', 'name' => 'GOMEZ PLATA', 'department_id' => $department->id],
                    ['code_dane' => '05313', 'name' => 'GRANADA', 'department_id' => $department->id],
                    ['code_dane' => '05315', 'name' => 'GUADALUPE', 'department_id' => $department->id],
                    ['code_dane' => '05318', 'name' => 'GUARNE', 'department_id' => $department->id],
                    ['code_dane' => '05321', 'name' => 'GUATAPE', 'department_id' => $department->id],
                    ['code_dane' => '05347', 'name' => 'HELICONIA', 'department_id' => $department->id],
                    ['code_dane' => '05353', 'name' => 'HISPANIA', 'department_id' => $department->id],
                    ['code_dane' => '05360', 'name' => 'ITAGUI', 'department_id' => $department->id],
                    ['code_dane' => '05361', 'name' => 'ITUANGO', 'department_id' => $department->id],
                    ['code_dane' => '05364', 'name' => 'JARDIN', 'department_id' => $department->id],
                    ['code_dane' => '05368', 'name' => 'JERICO', 'department_id' => $department->id],
                    ['code_dane' => '05376', 'name' => 'LA CEJA', 'department_id' => $department->id],
                    ['code_dane' => '05380', 'name' => 'LA ESTRELLA', 'department_id' => $department->id],
                    ['code_dane' => '05390', 'name' => 'LA PINTADA', 'department_id' => $department->id],
                    ['code_dane' => '05400', 'name' => 'LA UNION', 'department_id' => $department->id],
                    ['code_dane' => '05411', 'name' => 'LIBORINA', 'department_id' => $department->id],
                    ['code_dane' => '05425', 'name' => 'MACEO', 'department_id' => $department->id],
                    ['code_dane' => '05440', 'name' => 'MARINILLA', 'department_id' => $department->id],
                    ['code_dane' => '05467', 'name' => 'MONTEBELLO', 'department_id' => $department->id],
                    ['code_dane' => '05475', 'name' => 'MURINDO', 'department_id' => $department->id],
                    ['code_dane' => '05480', 'name' => 'MUTATA', 'department_id' => $department->id],
                    ['code_dane' => '05483', 'name' => 'NARIÑO', 'department_id' => $department->id],
                    ['code_dane' => '05490', 'name' => 'NECOCLI', 'department_id' => $department->id],
                    ['code_dane' => '05495', 'name' => 'NECHI', 'department_id' => $department->id],
                    ['code_dane' => '05501', 'name' => 'OLAYA', 'department_id' => $department->id],
                    ['code_dane' => '05541', 'name' => 'PEÐOL', 'department_id' => $department->id],
                    ['code_dane' => '05543', 'name' => 'PEQUE', 'department_id' => $department->id],
                    ['code_dane' => '05576', 'name' => 'PUEBLORRICO', 'department_id' => $department->id],
                    ['code_dane' => '05579', 'name' => 'PUERTO BERRIO', 'department_id' => $department->id],
                    ['code_dane' => '05585', 'name' => 'PUERTO NARE', 'department_id' => $department->id],
                    ['code_dane' => '05591', 'name' => 'PUERTO TRIUNFO', 'department_id' => $department->id],
                    ['code_dane' => '05604', 'name' => 'REMEDIOS', 'department_id' => $department->id],
                    ['code_dane' => '05607', 'name' => 'RETIRO', 'department_id' => $department->id],
                    ['code_dane' => '05615', 'name' => 'RIONEGRO', 'department_id' => $department->id],
                    ['code_dane' => '05628', 'name' => 'SABANALARGA', 'department_id' => $department->id],
                    ['code_dane' => '05631', 'name' => 'SABANETA', 'department_id' => $department->id],
                    ['code_dane' => '05642', 'name' => 'SALGAR', 'department_id' => $department->id],
                    ['code_dane' => '05647', 'name' => 'SAN ANDRES DE CUERQUIA', 'department_id' => $department->id],
                    ['code_dane' => '05649', 'name' => 'SAN CARLOS', 'department_id' => $department->id],
                    ['code_dane' => '05652', 'name' => 'SAN FRANCISCO', 'department_id' => $department->id],
                    ['code_dane' => '05656', 'name' => 'SAN JERONIMO', 'department_id' => $department->id],
                    ['code_dane' => '05658', 'name' => 'SAN JOSE DE LA MONTAÑA', 'department_id' => $department->id],
                    ['code_dane' => '05659', 'name' => 'SAN JUAN DE URABA', 'department_id' => $department->id],
                    ['code_dane' => '05660', 'name' => 'SAN LUIS', 'department_id' => $department->id],
                    ['code_dane' => '05664', 'name' => 'SAN PEDRO', 'department_id' => $department->id],
                    ['code_dane' => '05665', 'name' => 'SAN PEDRO DE URABA', 'department_id' => $department->id],
                    ['code_dane' => '05667', 'name' => 'SAN RAFAEL', 'department_id' => $department->id],
                    ['code_dane' => '05670', 'name' => 'SAN ROQUE', 'department_id' => $department->id],
                    ['code_dane' => '05674', 'name' => 'SAN VICENTE', 'department_id' => $department->id],
                    ['code_dane' => '05679', 'name' => 'SANTA BARBARA', 'department_id' => $department->id],
                    ['code_dane' => '05686', 'name' => 'SANTA ROSA DE OSOS', 'department_id' => $department->id],
                    ['code_dane' => '05690', 'name' => 'SANTO DOMINGO', 'department_id' => $department->id],
                    ['code_dane' => '05697', 'name' => 'EL SANTUARIO', 'department_id' => $department->id],
                    ['code_dane' => '05736', 'name' => 'SEGOVIA', 'department_id' => $department->id],
                    ['code_dane' => '05756', 'name' => 'SONSON', 'department_id' => $department->id],
                    ['code_dane' => '05761', 'name' => 'SOPETRAN', 'department_id' => $department->id],
                    ['code_dane' => '05789', 'name' => 'TAMESIS', 'department_id' => $department->id],
                    ['code_dane' => '05790', 'name' => 'TARAZA', 'department_id' => $department->id],
                    ['code_dane' => '05792', 'name' => 'TARSO', 'department_id' => $department->id],
                    ['code_dane' => '05809', 'name' => 'TITIRIBI', 'department_id' => $department->id],
                    ['code_dane' => '05819', 'name' => 'TOLEDO', 'department_id' => $department->id],
                    ['code_dane' => '05837', 'name' => 'TURBO', 'department_id' => $department->id],
                    ['code_dane' => '05842', 'name' => 'URAMITA', 'department_id' => $department->id],
                    ['code_dane' => '05847', 'name' => 'URRAO', 'department_id' => $department->id],
                    ['code_dane' => '05854', 'name' => 'VALDIVIA', 'department_id' => $department->id],
                    ['code_dane' => '05856', 'name' => 'VALPARAISO', 'department_id' => $department->id],
                    ['code_dane' => '05858', 'name' => 'VEGACHI', 'department_id' => $department->id],
                    ['code_dane' => '05861', 'name' => 'VENECIA', 'department_id' => $department->id],
                    ['code_dane' => '05873', 'name' => 'VIGIA DEL FUERTE', 'department_id' => $department->id],
                    ['code_dane' => '05885', 'name' => 'YALI', 'department_id' => $department->id],
                    ['code_dane' => '05887', 'name' => 'YARUMAL', 'department_id' => $department->id],
                    ['code_dane' => '05890', 'name' => 'YOLOMBO', 'department_id' => $department->id],
                    ['code_dane' => '05893', 'name' => 'YONDO', 'department_id' => $department->id],
                    ['code_dane' => '05895', 'name' => 'ZARAGOZA', 'department_id' => $department->id],
                ];

                // Insertar ciudades de Antioquia
                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }

            if ($department->code_dane == '08') {
                $cities = [
                    ['code_dane' => '08001', 'name' => 'BARRANQUILLA', 'department_id' => $department->id],
                    ['code_dane' => '08078', 'name' => 'BARANOA', 'department_id' => $department->id],
                    ['code_dane' => '08137', 'name' => 'CAMPO DE LA CRUZ', 'department_id' => $department->id],
                    ['code_dane' => '08141', 'name' => 'CANDELARIA', 'department_id' => $department->id],
                    ['code_dane' => '08296', 'name' => 'GALAPA', 'department_id' => $department->id],
                    ['code_dane' => '08372', 'name' => 'JUAN DE ACOSTA', 'department_id' => $department->id],
                    ['code_dane' => '08421', 'name' => 'LURUACO', 'department_id' => $department->id],
                    ['code_dane' => '08433', 'name' => 'MALAMBO', 'department_id' => $department->id],
                    ['code_dane' => '08436', 'name' => 'MANATI', 'department_id' => $department->id],
                    ['code_dane' => '08520', 'name' => 'PALMAR DE VARELA', 'department_id' => $department->id],
                    ['code_dane' => '08549', 'name' => 'PIOJO', 'department_id' => $department->id],
                    ['code_dane' => '08558', 'name' => 'POLONUEVO', 'department_id' => $department->id],
                    ['code_dane' => '08560', 'name' => 'PONEDERA', 'department_id' => $department->id],
                    ['code_dane' => '08573', 'name' => 'PUERTO COLOMBIA', 'department_id' => $department->id],
                    ['code_dane' => '08606', 'name' => 'REPELON', 'department_id' => $department->id],
                    ['code_dane' => '08634', 'name' => 'SABANAGRANDE', 'department_id' => $department->id],
                    ['code_dane' => '08638', 'name' => 'SABANALARGA', 'department_id' => $department->id],
                    ['code_dane' => '08675', 'name' => 'SANTA LUCIA', 'department_id' => $department->id],
                    ['code_dane' => '08685', 'name' => 'SANTO TOMAS', 'department_id' => $department->id],
                    ['code_dane' => '08758', 'name' => 'SOLEDAD', 'department_id' => $department->id],
                    ['code_dane' => '08770', 'name' => 'SUAN', 'department_id' => $department->id],
                    ['code_dane' => '08832', 'name' => 'TUBARA', 'department_id' => $department->id],
                    ['code_dane' => '08849', 'name' => 'USIACURI', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }

            if ($department->code_dane == '11') {
                $cities = [
                    ['code_dane' => '11001', 'name' => 'BOGOTA, D.C.', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '13') {
                $cities = [
                    ['code_dane' => '13001', 'name' => 'CARTAGENA', 'department_id' => $department->id],
                    ['code_dane' => '13006', 'name' => 'ACHI', 'department_id' => $department->id],
                    ['code_dane' => '13030', 'name' => 'ALTOS DEL ROSARIO', 'department_id' => $department->id],
                    ['code_dane' => '13042', 'name' => 'ARENAL', 'department_id' => $department->id],
                    ['code_dane' => '13052', 'name' => 'ARJONA', 'department_id' => $department->id],
                    ['code_dane' => '13062', 'name' => 'ARROYOHONDO', 'department_id' => $department->id],
                    ['code_dane' => '13074', 'name' => 'BARRANCO DE LOBA', 'department_id' => $department->id],
                    ['code_dane' => '13140', 'name' => 'CALAMAR', 'department_id' => $department->id],
                    ['code_dane' => '13160', 'name' => 'CANTAGALLO', 'department_id' => $department->id],
                    ['code_dane' => '13188', 'name' => 'CICUCO', 'department_id' => $department->id],
                    ['code_dane' => '13212', 'name' => 'CORDOBA', 'department_id' => $department->id],
                    ['code_dane' => '13222', 'name' => 'CLEMENCIA', 'department_id' => $department->id],
                    ['code_dane' => '13244', 'name' => 'EL CARMEN DE BOLIVAR', 'department_id' => $department->id],
                    ['code_dane' => '13248', 'name' => 'EL GUAMO', 'department_id' => $department->id],
                    ['code_dane' => '13268', 'name' => 'EL PEÑON', 'department_id' => $department->id],
                    ['code_dane' => '13300', 'name' => 'HATILLO DE LOBA', 'department_id' => $department->id],
                    ['code_dane' => '13430', 'name' => 'MAGANGUE', 'department_id' => $department->id],
                    ['code_dane' => '13433', 'name' => 'MAHATES', 'department_id' => $department->id],
                    ['code_dane' => '13440', 'name' => 'MARGARITA', 'department_id' => $department->id],
                    ['code_dane' => '13442', 'name' => 'MARIA LA BAJA', 'department_id' => $department->id],
                    ['code_dane' => '13458', 'name' => 'MONTECRISTO', 'department_id' => $department->id],
                    ['code_dane' => '13468', 'name' => 'MOMPOS', 'department_id' => $department->id],
                    ['code_dane' => '13490', 'name' => 'NOROSI (1)', 'department_id' => $department->id],
                    ['code_dane' => '13473', 'name' => 'MORALES', 'department_id' => $department->id],
                    ['code_dane' => '13549', 'name' => 'PINILLOS', 'department_id' => $department->id],
                    ['code_dane' => '13580', 'name' => 'REGIDOR', 'department_id' => $department->id],
                    ['code_dane' => '13600', 'name' => 'RIO VIEJO (1)', 'department_id' => $department->id],
                    ['code_dane' => '13620', 'name' => 'SAN CRISTOBAL', 'department_id' => $department->id],
                    ['code_dane' => '13647', 'name' => 'SAN ESTANISLAO', 'department_id' => $department->id],
                    ['code_dane' => '13650', 'name' => 'SAN FERNANDO', 'department_id' => $department->id],
                    ['code_dane' => '13654', 'name' => 'SAN JACINTO', 'department_id' => $department->id],
                    ['code_dane' => '13655', 'name' => 'SAN JACINTO DEL CAUCA', 'department_id' => $department->id],
                    ['code_dane' => '13657', 'name' => 'SAN JUAN NEPOMUCENO', 'department_id' => $department->id],
                    ['code_dane' => '13667', 'name' => 'SAN MARTIN DE LOBA', 'department_id' => $department->id],
                    ['code_dane' => '13670', 'name' => 'SAN PABLO', 'department_id' => $department->id],
                    ['code_dane' => '13673', 'name' => 'SANTA CATALINA', 'department_id' => $department->id],
                    ['code_dane' => '13683', 'name' => 'SANTA ROSA', 'department_id' => $department->id],
                    ['code_dane' => '13688', 'name' => 'SANTA ROSA DEL SUR', 'department_id' => $department->id],
                    ['code_dane' => '13744', 'name' => 'SIMITI', 'department_id' => $department->id],
                    ['code_dane' => '13760', 'name' => 'SOPLAVIENTO', 'department_id' => $department->id],
                    ['code_dane' => '13780', 'name' => 'TALAIGUA NUEVO', 'department_id' => $department->id],
                    ['code_dane' => '13810', 'name' => 'TIQUISIO', 'department_id' => $department->id],
                    ['code_dane' => '13836', 'name' => 'TURBACO', 'department_id' => $department->id],
                    ['code_dane' => '13838', 'name' => 'TURBANA', 'department_id' => $department->id],
                    ['code_dane' => '13873', 'name' => 'VILLANUEVA', 'department_id' => $department->id],
                    ['code_dane' => '13894', 'name' => 'ZAMBRANO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '15') {
                $cities = [
                    ['code_dane' => '15001', 'name' => 'TUNJA', 'department_id' => $department->id],
                    ['code_dane' => '15022', 'name' => 'ALMEIDA', 'department_id' => $department->id],
                    ['code_dane' => '15047', 'name' => 'AQUITANIA', 'department_id' => $department->id],
                    ['code_dane' => '15051', 'name' => 'ARCABUCO', 'department_id' => $department->id],
                    ['code_dane' => '15087', 'name' => 'BELEN', 'department_id' => $department->id],
                    ['code_dane' => '15090', 'name' => 'BERBEO', 'department_id' => $department->id],
                    ['code_dane' => '15092', 'name' => 'BETEITIVA', 'department_id' => $department->id],
                    ['code_dane' => '15097', 'name' => 'BOAVITA', 'department_id' => $department->id],
                    ['code_dane' => '15104', 'name' => 'BOYACA', 'department_id' => $department->id],
                    ['code_dane' => '15106', 'name' => 'BRICEÑO', 'department_id' => $department->id],
                    ['code_dane' => '15109', 'name' => 'BUENAVISTA', 'department_id' => $department->id],
                    ['code_dane' => '15114', 'name' => 'BUSBANZA', 'department_id' => $department->id],
                    ['code_dane' => '15131', 'name' => 'CALDAS', 'department_id' => $department->id],
                    ['code_dane' => '15135', 'name' => 'CAMPOHERMOSO', 'department_id' => $department->id],
                    ['code_dane' => '15162', 'name' => 'CERINZA', 'department_id' => $department->id],
                    ['code_dane' => '15172', 'name' => 'CHINAVITA', 'department_id' => $department->id],
                    ['code_dane' => '15176', 'name' => 'CHIQUINQUIRA', 'department_id' => $department->id],
                    ['code_dane' => '15180', 'name' => 'CHISCAS', 'department_id' => $department->id],
                    ['code_dane' => '15183', 'name' => 'CHITA', 'department_id' => $department->id],
                    ['code_dane' => '15185', 'name' => 'CHITARAQUE', 'department_id' => $department->id],
                    ['code_dane' => '15187', 'name' => 'CHIVATA', 'department_id' => $department->id],
                    ['code_dane' => '15189', 'name' => 'CIENEGA', 'department_id' => $department->id],
                    ['code_dane' => '15204', 'name' => 'COMBITA', 'department_id' => $department->id],
                    ['code_dane' => '15212', 'name' => 'COPER', 'department_id' => $department->id],
                    ['code_dane' => '15215', 'name' => 'CORRALES', 'department_id' => $department->id],
                    ['code_dane' => '15218', 'name' => 'COVARACHIA', 'department_id' => $department->id],
                    ['code_dane' => '15223', 'name' => 'CUBARA', 'department_id' => $department->id],
                    ['code_dane' => '15224', 'name' => 'CUCAITA', 'department_id' => $department->id],
                    ['code_dane' => '15226', 'name' => 'CUITIVA', 'department_id' => $department->id],
                    ['code_dane' => '15232', 'name' => 'CHIQUIZA', 'department_id' => $department->id],
                    ['code_dane' => '15236', 'name' => 'CHIVOR', 'department_id' => $department->id],
                    ['code_dane' => '15238', 'name' => 'DUITAMA', 'department_id' => $department->id],
                    ['code_dane' => '15244', 'name' => 'EL COCUY', 'department_id' => $department->id],
                    ['code_dane' => '15248', 'name' => 'EL ESPINO', 'department_id' => $department->id],
                    ['code_dane' => '15272', 'name' => 'FIRAVITOBA', 'department_id' => $department->id],
                    ['code_dane' => '15276', 'name' => 'FLORESTA', 'department_id' => $department->id],
                    ['code_dane' => '15293', 'name' => 'GACHANTIVA', 'department_id' => $department->id],
                    ['code_dane' => '15296', 'name' => 'GAMEZA', 'department_id' => $department->id],
                    ['code_dane' => '15299', 'name' => 'GARAGOA', 'department_id' => $department->id],
                    ['code_dane' => '15317', 'name' => 'GUACAMAYAS', 'department_id' => $department->id],
                    ['code_dane' => '15322', 'name' => 'GUATEQUE', 'department_id' => $department->id],
                    ['code_dane' => '15325', 'name' => 'GUAYATA', 'department_id' => $department->id],
                    ['code_dane' => '15332', 'name' => 'GsICAN', 'department_id' => $department->id],
                    ['code_dane' => '15362', 'name' => 'IZA', 'department_id' => $department->id],
                    ['code_dane' => '15367', 'name' => 'JENESANO', 'department_id' => $department->id],
                    ['code_dane' => '15368', 'name' => 'JERICO', 'department_id' => $department->id],
                    ['code_dane' => '15377', 'name' => 'LABRANZAGRANDE', 'department_id' => $department->id],
                    ['code_dane' => '15380', 'name' => 'LA CAPILLA', 'department_id' => $department->id],
                    ['code_dane' => '15401', 'name' => 'LA VICTORIA', 'department_id' => $department->id],
                    ['code_dane' => '15403', 'name' => 'LA UVITA', 'department_id' => $department->id],
                    ['code_dane' => '15407', 'name' => 'VILLA DE LEYVA', 'department_id' => $department->id],
                    ['code_dane' => '15425', 'name' => 'MACANAL', 'department_id' => $department->id],
                    ['code_dane' => '15442', 'name' => 'MARIPI', 'department_id' => $department->id],
                    ['code_dane' => '15455', 'name' => 'MIRAFLORES', 'department_id' => $department->id],
                    ['code_dane' => '15464', 'name' => 'MONGUA', 'department_id' => $department->id],
                    ['code_dane' => '15466', 'name' => 'MONGUI', 'department_id' => $department->id],
                    ['code_dane' => '15469', 'name' => 'MONIQUIRA', 'department_id' => $department->id],
                    ['code_dane' => '15476', 'name' => 'MOTAVITA', 'department_id' => $department->id],
                    ['code_dane' => '15480', 'name' => 'MUZO', 'department_id' => $department->id],
                    ['code_dane' => '15491', 'name' => 'NOBSA', 'department_id' => $department->id],
                    ['code_dane' => '15494', 'name' => 'NUEVO COLON', 'department_id' => $department->id],
                    ['code_dane' => '15500', 'name' => 'OICATA', 'department_id' => $department->id],
                    ['code_dane' => '15507', 'name' => 'OTANCHE', 'department_id' => $department->id],
                    ['code_dane' => '15511', 'name' => 'PACHAVITA', 'department_id' => $department->id],
                    ['code_dane' => '15514', 'name' => 'PAEZ', 'department_id' => $department->id],
                    ['code_dane' => '15516', 'name' => 'PAIPA', 'department_id' => $department->id],
                    ['code_dane' => '15518', 'name' => 'PAJARITO', 'department_id' => $department->id],
                    ['code_dane' => '15522', 'name' => 'PANQUEBA', 'department_id' => $department->id],
                    ['code_dane' => '15531', 'name' => 'PAUNA', 'department_id' => $department->id],
                    ['code_dane' => '15533', 'name' => 'PAYA', 'department_id' => $department->id],
                    ['code_dane' => '15537', 'name' => 'PAZ DE RIO', 'department_id' => $department->id],
                    ['code_dane' => '15542', 'name' => 'PESCA', 'department_id' => $department->id],
                    ['code_dane' => '15550', 'name' => 'PISBA', 'department_id' => $department->id],
                    ['code_dane' => '15572', 'name' => 'PUERTO BOYACA', 'department_id' => $department->id],
                    ['code_dane' => '15580', 'name' => 'QUIPAMA', 'department_id' => $department->id],
                    ['code_dane' => '15599', 'name' => 'RAMIRIQUI', 'department_id' => $department->id],
                    ['code_dane' => '15600', 'name' => 'RAQUIRA', 'department_id' => $department->id],
                    ['code_dane' => '15621', 'name' => 'RONDON', 'department_id' => $department->id],
                    ['code_dane' => '15632', 'name' => 'SABOYA', 'department_id' => $department->id],
                    ['code_dane' => '15638', 'name' => 'SACHICA', 'department_id' => $department->id],
                    ['code_dane' => '15646', 'name' => 'SAMACA', 'department_id' => $department->id],
                    ['code_dane' => '15660', 'name' => 'SAN EDUARDO', 'department_id' => $department->id],
                    ['code_dane' => '15664', 'name' => 'SAN JOSE DE PARE', 'department_id' => $department->id],
                    ['code_dane' => '15667', 'name' => 'SAN LUIS DE GACENO', 'department_id' => $department->id],
                    ['code_dane' => '15673', 'name' => 'SAN MATEO', 'department_id' => $department->id],
                    ['code_dane' => '15676', 'name' => 'SAN MIGUEL DE SEMA', 'department_id' => $department->id],
                    ['code_dane' => '15681', 'name' => 'SAN PABLO DE BORBUR', 'department_id' => $department->id],
                    ['code_dane' => '15686', 'name' => 'SANTANA', 'department_id' => $department->id],
                    ['code_dane' => '15690', 'name' => 'SANTA MARIA', 'department_id' => $department->id],
                    ['code_dane' => '15693', 'name' => 'SANTA ROSA DE VITERBO', 'department_id' => $department->id],
                    ['code_dane' => '15696', 'name' => 'SANTA SOFIA', 'department_id' => $department->id],
                    ['code_dane' => '15720', 'name' => 'SATIVANORTE', 'department_id' => $department->id],
                    ['code_dane' => '15723', 'name' => 'SATIVASUR', 'department_id' => $department->id],
                    ['code_dane' => '15740', 'name' => 'SIACHOQUE', 'department_id' => $department->id],
                    ['code_dane' => '15753', 'name' => 'SOATA', 'department_id' => $department->id],
                    ['code_dane' => '15755', 'name' => 'SOCOTA', 'department_id' => $department->id],
                    ['code_dane' => '15757', 'name' => 'SOCHA', 'department_id' => $department->id],
                    ['code_dane' => '15759', 'name' => 'SOGAMOSO', 'department_id' => $department->id],
                    ['code_dane' => '15761', 'name' => 'SOMONDOCO', 'department_id' => $department->id],
                    ['code_dane' => '15762', 'name' => 'SORA', 'department_id' => $department->id],
                    ['code_dane' => '15763', 'name' => 'SOTAQUIRA', 'department_id' => $department->id],
                    ['code_dane' => '15764', 'name' => 'SORACA', 'department_id' => $department->id],
                    ['code_dane' => '15774', 'name' => 'SUSACON', 'department_id' => $department->id],
                    ['code_dane' => '15776', 'name' => 'SUTAMARCHAN', 'department_id' => $department->id],
                    ['code_dane' => '15778', 'name' => 'SUTATENZA', 'department_id' => $department->id],
                    ['code_dane' => '15790', 'name' => 'TASCO', 'department_id' => $department->id],
                    ['code_dane' => '15798', 'name' => 'TENZA', 'department_id' => $department->id],
                    ['code_dane' => '15804', 'name' => 'TIBANA', 'department_id' => $department->id],
                    ['code_dane' => '15806', 'name' => 'TIBASOSA', 'department_id' => $department->id],
                    ['code_dane' => '15808', 'name' => 'TINJACA', 'department_id' => $department->id],
                    ['code_dane' => '15810', 'name' => 'TIPACOQUE', 'department_id' => $department->id],
                    ['code_dane' => '15814', 'name' => 'TOCA', 'department_id' => $department->id],
                    ['code_dane' => '15816', 'name' => 'TOGsI', 'department_id' => $department->id],
                    ['code_dane' => '15820', 'name' => 'TOPAGA', 'department_id' => $department->id],
                    ['code_dane' => '15822', 'name' => 'TOTA', 'department_id' => $department->id],
                    ['code_dane' => '15832', 'name' => 'TUNUNGUA', 'department_id' => $department->id],
                    ['code_dane' => '15835', 'name' => 'TURMEQUE', 'department_id' => $department->id],
                    ['code_dane' => '15837', 'name' => 'TUTA', 'department_id' => $department->id],
                    ['code_dane' => '15839', 'name' => 'TUTAZA', 'department_id' => $department->id],
                    ['code_dane' => '15842', 'name' => 'UMBITA', 'department_id' => $department->id],
                    ['code_dane' => '15861', 'name' => 'VENTAQUEMADA', 'department_id' => $department->id],
                    ['code_dane' => '15879', 'name' => 'VIRACACHA', 'department_id' => $department->id],
                    ['code_dane' => '15897', 'name' => 'ZETAQUIRA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '17') {
                $cities = [
                    ['code_dane' => '17001', 'name' => 'MANIZALES', 'department_id' => $department->id],
                    ['code_dane' => '17013', 'name' => 'AGUADAS', 'department_id' => $department->id],
                    ['code_dane' => '17042', 'name' => 'ANSERMA', 'department_id' => $department->id],
                    ['code_dane' => '17050', 'name' => 'ARANZAZU', 'department_id' => $department->id],
                    ['code_dane' => '17088', 'name' => 'BELALCAZAR', 'department_id' => $department->id],
                    ['code_dane' => '17174', 'name' => 'CHINCHINA', 'department_id' => $department->id],
                    ['code_dane' => '17272', 'name' => 'FILADELFIA', 'department_id' => $department->id],
                    ['code_dane' => '17380', 'name' => 'LA DORADA', 'department_id' => $department->id],
                    ['code_dane' => '17388', 'name' => 'LA MERCED', 'department_id' => $department->id],
                    ['code_dane' => '17433', 'name' => 'MANZANARES', 'department_id' => $department->id],
                    ['code_dane' => '17442', 'name' => 'MARMATO', 'department_id' => $department->id],
                    ['code_dane' => '17444', 'name' => 'MARQUETALIA', 'department_id' => $department->id],
                    ['code_dane' => '17446', 'name' => 'MARULANDA', 'department_id' => $department->id],
                    ['code_dane' => '17486', 'name' => 'NEIRA', 'department_id' => $department->id],
                    ['code_dane' => '17495', 'name' => 'NORCASIA', 'department_id' => $department->id],
                    ['code_dane' => '17513', 'name' => 'PACORA', 'department_id' => $department->id],
                    ['code_dane' => '17524', 'name' => 'PALESTINA', 'department_id' => $department->id],
                    ['code_dane' => '17541', 'name' => 'PENSILVANIA', 'department_id' => $department->id],
                    ['code_dane' => '17614', 'name' => 'RIOSUCIO', 'department_id' => $department->id],
                    ['code_dane' => '17616', 'name' => 'RISARALDA', 'department_id' => $department->id],
                    ['code_dane' => '17653', 'name' => 'SALAMINA', 'department_id' => $department->id],
                    ['code_dane' => '17662', 'name' => 'SAMANA', 'department_id' => $department->id],
                    ['code_dane' => '17665', 'name' => 'SAN JOSE', 'department_id' => $department->id],
                    ['code_dane' => '17777', 'name' => 'SUPIA', 'department_id' => $department->id],
                    ['code_dane' => '17867', 'name' => 'VICTORIA', 'department_id' => $department->id],
                    ['code_dane' => '17873', 'name' => 'VILLAMARIA', 'department_id' => $department->id],
                    ['code_dane' => '17877', 'name' => 'VITERBO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '18') {
                $cities = [
                    ['code_dane' => '18001', 'name' => 'FLORENCIA', 'department_id' => $department->id],
                    ['code_dane' => '18029', 'name' => 'ALBANIA', 'department_id' => $department->id],
                    ['code_dane' => '18094', 'name' => 'BELEN DE LOS ANDAQUIES', 'department_id' => $department->id],
                    ['code_dane' => '18150', 'name' => 'CARTAGENA DEL CHAIRA', 'department_id' => $department->id],
                    ['code_dane' => '18205', 'name' => 'CURILLO', 'department_id' => $department->id],
                    ['code_dane' => '18247', 'name' => 'EL DONCELLO', 'department_id' => $department->id],
                    ['code_dane' => '18256', 'name' => 'EL PAUJIL', 'department_id' => $department->id],
                    ['code_dane' => '18410', 'name' => 'LA MONTAÑITA', 'department_id' => $department->id],
                    ['code_dane' => '18460', 'name' => 'MILAN', 'department_id' => $department->id],
                    ['code_dane' => '18479', 'name' => 'MORELIA', 'department_id' => $department->id],
                    ['code_dane' => '18592', 'name' => 'PUERTO RICO', 'department_id' => $department->id],
                    ['code_dane' => '18610', 'name' => 'SAN JOSE DEL FRAGUA', 'department_id' => $department->id],
                    ['code_dane' => '18753', 'name' => 'SAN VICENTE DEL CAGUAN', 'department_id' => $department->id],
                    ['code_dane' => '18756', 'name' => 'SOLANO', 'department_id' => $department->id],
                    ['code_dane' => '18785', 'name' => 'SOLITA', 'department_id' => $department->id],
                    ['code_dane' => '18860', 'name' => 'VALPARAISO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '19') {
                $cities = [
                    ['code_dane' => '19001', 'name' => 'POPAYAN', 'department_id' => $department->id],
                    ['code_dane' => '19022', 'name' => 'ALMAGUER', 'department_id' => $department->id],
                    ['code_dane' => '19050', 'name' => 'ARGELIA', 'department_id' => $department->id],
                    ['code_dane' => '19075', 'name' => 'BALBOA', 'department_id' => $department->id],
                    ['code_dane' => '19100', 'name' => 'BOLIVAR', 'department_id' => $department->id],
                    ['code_dane' => '19110', 'name' => 'BUENOS AIRES', 'department_id' => $department->id],
                    ['code_dane' => '19130', 'name' => 'CAJIBIO', 'department_id' => $department->id],
                    ['code_dane' => '19137', 'name' => 'CALDONO', 'department_id' => $department->id],
                    ['code_dane' => '19142', 'name' => 'CALOTO (1)', 'department_id' => $department->id],
                    ['code_dane' => '19212', 'name' => 'CORINTO', 'department_id' => $department->id],
                    ['code_dane' => '19256', 'name' => 'EL TAMBO', 'department_id' => $department->id],
                    ['code_dane' => '19290', 'name' => 'FLORENCIA', 'department_id' => $department->id],
                    ['code_dane' => '19300', 'name' => 'GUACHENE (1)', 'department_id' => $department->id],
                    ['code_dane' => '19318', 'name' => 'GUAPI', 'department_id' => $department->id],
                    ['code_dane' => '19355', 'name' => 'INZA', 'department_id' => $department->id],
                    ['code_dane' => '19364', 'name' => 'JAMBALO', 'department_id' => $department->id],
                    ['code_dane' => '19392', 'name' => 'LA SIERRA', 'department_id' => $department->id],
                    ['code_dane' => '19397', 'name' => 'LA VEGA', 'department_id' => $department->id],
                    ['code_dane' => '19418', 'name' => 'LOPEZ', 'department_id' => $department->id],
                    ['code_dane' => '19450', 'name' => 'MERCADERES', 'department_id' => $department->id],
                    ['code_dane' => '19455', 'name' => 'MIRANDA', 'department_id' => $department->id],
                    ['code_dane' => '19473', 'name' => 'MORALES', 'department_id' => $department->id],
                    ['code_dane' => '19513', 'name' => 'PADILLA', 'department_id' => $department->id],
                    ['code_dane' => '19517', 'name' => 'PAEZ', 'department_id' => $department->id],
                    ['code_dane' => '19532', 'name' => 'PATIA', 'department_id' => $department->id],
                    ['code_dane' => '19533', 'name' => 'PIAMONTE', 'department_id' => $department->id],
                    ['code_dane' => '19548', 'name' => 'PIENDAMO', 'department_id' => $department->id],
                    ['code_dane' => '19573', 'name' => 'PUERTO TEJADA', 'department_id' => $department->id],
                    ['code_dane' => '19585', 'name' => 'PURACE', 'department_id' => $department->id],
                    ['code_dane' => '19622', 'name' => 'ROSAS', 'department_id' => $department->id],
                    ['code_dane' => '19693', 'name' => 'SAN SEBASTIAN', 'department_id' => $department->id],
                    ['code_dane' => '19698', 'name' => 'SANTANDER DE QUILICHAO', 'department_id' => $department->id],
                    ['code_dane' => '19701', 'name' => 'SANTA ROSA', 'department_id' => $department->id],
                    ['code_dane' => '19743', 'name' => 'SILVIA', 'department_id' => $department->id],
                    ['code_dane' => '19760', 'name' => 'SOTARA', 'department_id' => $department->id],
                    ['code_dane' => '19780', 'name' => 'SUAREZ', 'department_id' => $department->id],
                    ['code_dane' => '19785', 'name' => 'SUCRE', 'department_id' => $department->id],
                    ['code_dane' => '19807', 'name' => 'TIMBIO', 'department_id' => $department->id],
                    ['code_dane' => '19809', 'name' => 'TIMBIQUI', 'department_id' => $department->id],
                    ['code_dane' => '19821', 'name' => 'TORIBIO', 'department_id' => $department->id],
                    ['code_dane' => '19824', 'name' => 'TOTORO', 'department_id' => $department->id],
                    ['code_dane' => '19845', 'name' => 'VILLA RICA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '20') {
                $cities = [
                    ['code_dane' => '20001', 'name' => 'VALLEDUPAR', 'department_id' => $department->id],
                    ['code_dane' => '20011', 'name' => 'AGUACHICA', 'department_id' => $department->id],
                    ['code_dane' => '20013', 'name' => 'AGUSTIN CODAZZI', 'department_id' => $department->id],
                    ['code_dane' => '20032', 'name' => 'ASTREA', 'department_id' => $department->id],
                    ['code_dane' => '20045', 'name' => 'BECERRIL', 'department_id' => $department->id],
                    ['code_dane' => '20060', 'name' => 'BOSCONIA', 'department_id' => $department->id],
                    ['code_dane' => '20175', 'name' => 'CHIMICHAGUA', 'department_id' => $department->id],
                    ['code_dane' => '20178', 'name' => 'CHIRIGUANA', 'department_id' => $department->id],
                    ['code_dane' => '20228', 'name' => 'CURUMANI', 'department_id' => $department->id],
                    ['code_dane' => '20238', 'name' => 'EL COPEY', 'department_id' => $department->id],
                    ['code_dane' => '20250', 'name' => 'EL PASO', 'department_id' => $department->id],
                    ['code_dane' => '20295', 'name' => 'GAMARRA', 'department_id' => $department->id],
                    ['code_dane' => '20310', 'name' => 'GONZALEZ', 'department_id' => $department->id],
                    ['code_dane' => '20383', 'name' => 'LA GLORIA', 'department_id' => $department->id],
                    ['code_dane' => '20400', 'name' => 'LA JAGUA DE IBIRICO', 'department_id' => $department->id],
                    ['code_dane' => '20443', 'name' => 'MANAURE', 'department_id' => $department->id],
                    ['code_dane' => '20517', 'name' => 'PAILITAS', 'department_id' => $department->id],
                    ['code_dane' => '20550', 'name' => 'PELAYA', 'department_id' => $department->id],
                    ['code_dane' => '20570', 'name' => 'PUEBLO BELLO', 'department_id' => $department->id],
                    ['code_dane' => '20614', 'name' => 'RIO DE ORO', 'department_id' => $department->id],
                    ['code_dane' => '20621', 'name' => 'LA PAZ', 'department_id' => $department->id],
                    ['code_dane' => '20710', 'name' => 'SAN ALBERTO', 'department_id' => $department->id],
                    ['code_dane' => '20750', 'name' => 'SAN DIEGO', 'department_id' => $department->id],
                    ['code_dane' => '20770', 'name' => 'SAN MARTIN', 'department_id' => $department->id],
                    ['code_dane' => '20787', 'name' => 'TAMALAMEQUE', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '23') {
                $cities = [
                    ['code_dane' => '23001', 'name' => 'MONTERIA', 'department_id' => $department->id],
                    ['code_dane' => '23068', 'name' => 'AYAPEL', 'department_id' => $department->id],
                    ['code_dane' => '23079', 'name' => 'BUENAVISTA', 'department_id' => $department->id],
                    ['code_dane' => '23090', 'name' => 'CANALETE', 'department_id' => $department->id],
                    ['code_dane' => '23162', 'name' => 'CERETE', 'department_id' => $department->id],
                    ['code_dane' => '23168', 'name' => 'CHIMA (3)', 'department_id' => $department->id],
                    ['code_dane' => '23182', 'name' => 'CHINU', 'department_id' => $department->id],
                    ['code_dane' => '23189', 'name' => 'CIENAGA DE ORO', 'department_id' => $department->id],
                    ['code_dane' => '23300', 'name' => 'COTORRA', 'department_id' => $department->id],
                    ['code_dane' => '23350', 'name' => 'LA APARTADA', 'department_id' => $department->id],
                    ['code_dane' => '23417', 'name' => 'LORICA', 'department_id' => $department->id],
                    ['code_dane' => '23419', 'name' => 'LOS CORDOBAS', 'department_id' => $department->id],
                    ['code_dane' => '23464', 'name' => 'MOMIL', 'department_id' => $department->id],
                    ['code_dane' => '23466', 'name' => 'MONTELIBANO (1)', 'department_id' => $department->id],
                    ['code_dane' => '23500', 'name' => 'MOÑITOS', 'department_id' => $department->id],
                    ['code_dane' => '23555', 'name' => 'PLANETA RICA', 'department_id' => $department->id],
                    ['code_dane' => '23570', 'name' => 'PUEBLO NUEVO', 'department_id' => $department->id],
                    ['code_dane' => '23574', 'name' => 'PUERTO ESCONDIDO', 'department_id' => $department->id],
                    ['code_dane' => '23580', 'name' => 'PUERTO LIBERTADOR', 'department_id' => $department->id],
                    ['code_dane' => '23586', 'name' => 'PURISIMA', 'department_id' => $department->id],
                    ['code_dane' => '23660', 'name' => 'SAHAGUN', 'department_id' => $department->id],
                    ['code_dane' => '23670', 'name' => 'SAN ANDRES SOTAVENTO (3)', 'department_id' => $department->id],
                    ['code_dane' => '23672', 'name' => 'SAN ANTERO', 'department_id' => $department->id],
                    ['code_dane' => '23675', 'name' => 'SAN BERNARDO DEL VIENTO', 'department_id' => $department->id],
                    ['code_dane' => '23678', 'name' => 'SAN CARLOS', 'department_id' => $department->id],
                    ['code_dane' => '23682', 'name' => 'SAN JOSE DE URE (1)', 'department_id' => $department->id],
                    ['code_dane' => '23686', 'name' => 'SAN PELAYO', 'department_id' => $department->id],
                    ['code_dane' => '23807', 'name' => 'TIERRALTA', 'department_id' => $department->id],
                    ['code_dane' => '23855', 'name' => 'VALENCIA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '25') {
                $cities = [
                    ['code_dane' => '25001', 'name' => 'AGUA DE DIOS', 'department_id' => $department->id],
                    ['code_dane' => '25019', 'name' => 'ALBAN', 'department_id' => $department->id],
                    ['code_dane' => '25035', 'name' => 'ANAPOIMA', 'department_id' => $department->id],
                    ['code_dane' => '25040', 'name' => 'ANOLAIMA', 'department_id' => $department->id],
                    ['code_dane' => '25053', 'name' => 'ARBELAEZ', 'department_id' => $department->id],
                    ['code_dane' => '25086', 'name' => 'BELTRAN', 'department_id' => $department->id],
                    ['code_dane' => '25095', 'name' => 'BITUIMA', 'department_id' => $department->id],
                    ['code_dane' => '25099', 'name' => 'BOJACA', 'department_id' => $department->id],
                    ['code_dane' => '25120', 'name' => 'CABRERA', 'department_id' => $department->id],
                    ['code_dane' => '25123', 'name' => 'CACHIPAY', 'department_id' => $department->id],
                    ['code_dane' => '25126', 'name' => 'CAJICA', 'department_id' => $department->id],
                    ['code_dane' => '25148', 'name' => 'CAPARRAPI', 'department_id' => $department->id],
                    ['code_dane' => '25151', 'name' => 'CAQUEZA', 'department_id' => $department->id],
                    ['code_dane' => '25154', 'name' => 'CARMEN DE CARUPA', 'department_id' => $department->id],
                    ['code_dane' => '25168', 'name' => 'CHAGUANI', 'department_id' => $department->id],
                    ['code_dane' => '25175', 'name' => 'CHIA', 'department_id' => $department->id],
                    ['code_dane' => '25178', 'name' => 'CHIPAQUE', 'department_id' => $department->id],
                    ['code_dane' => '25181', 'name' => 'CHOACHI', 'department_id' => $department->id],
                    ['code_dane' => '25183', 'name' => 'CHOCONTA', 'department_id' => $department->id],
                    ['code_dane' => '25200', 'name' => 'COGUA', 'department_id' => $department->id],
                    ['code_dane' => '25214', 'name' => 'COTA', 'department_id' => $department->id],
                    ['code_dane' => '25224', 'name' => 'CUCUNUBA', 'department_id' => $department->id],
                    ['code_dane' => '25245', 'name' => 'EL COLEGIO', 'department_id' => $department->id],
                    ['code_dane' => '25258', 'name' => 'EL PEÑON', 'department_id' => $department->id],
                    ['code_dane' => '25260', 'name' => 'EL ROSAL', 'department_id' => $department->id],
                    ['code_dane' => '25269', 'name' => 'FACATATIVA', 'department_id' => $department->id],
                    ['code_dane' => '25279', 'name' => 'FOMEQUE', 'department_id' => $department->id],
                    ['code_dane' => '25281', 'name' => 'FOSCA', 'department_id' => $department->id],
                    ['code_dane' => '25286', 'name' => 'FUNZA', 'department_id' => $department->id],
                    ['code_dane' => '25288', 'name' => 'FUQUENE', 'department_id' => $department->id],
                    ['code_dane' => '25290', 'name' => 'FUSAGASUGA', 'department_id' => $department->id],
                    ['code_dane' => '25293', 'name' => 'GACHALA', 'department_id' => $department->id],
                    ['code_dane' => '25295', 'name' => 'GACHANCIPA', 'department_id' => $department->id],
                    ['code_dane' => '25297', 'name' => 'GACHETA', 'department_id' => $department->id],
                    ['code_dane' => '25299', 'name' => 'GAMA', 'department_id' => $department->id],
                    ['code_dane' => '25307', 'name' => 'GIRARDOT', 'department_id' => $department->id],
                    ['code_dane' => '25312', 'name' => 'GRANADA', 'department_id' => $department->id],
                    ['code_dane' => '25317', 'name' => 'GUACHETA', 'department_id' => $department->id],
                    ['code_dane' => '25320', 'name' => 'GUADUAS', 'department_id' => $department->id],
                    ['code_dane' => '25322', 'name' => 'GUASCA', 'department_id' => $department->id],
                    ['code_dane' => '25324', 'name' => 'GUATAQUI', 'department_id' => $department->id],
                    ['code_dane' => '25326', 'name' => 'GUATAVITA', 'department_id' => $department->id],
                    ['code_dane' => '25328', 'name' => 'GUAYABAL DE SIQUIMA', 'department_id' => $department->id],
                    ['code_dane' => '25335', 'name' => 'GUAYABETAL', 'department_id' => $department->id],
                    ['code_dane' => '25339', 'name' => 'GUTIERREZ', 'department_id' => $department->id],
                    ['code_dane' => '25368', 'name' => 'JERUSALEN', 'department_id' => $department->id],
                    ['code_dane' => '25372', 'name' => 'JUNIN', 'department_id' => $department->id],
                    ['code_dane' => '25377', 'name' => 'LA CALERA', 'department_id' => $department->id],
                    ['code_dane' => '25386', 'name' => 'LA MESA', 'department_id' => $department->id],
                    ['code_dane' => '25394', 'name' => 'LA PALMA', 'department_id' => $department->id],
                    ['code_dane' => '25398', 'name' => 'LA PEÑA', 'department_id' => $department->id],
                    ['code_dane' => '25402', 'name' => 'LA VEGA', 'department_id' => $department->id],
                    ['code_dane' => '25407', 'name' => 'LENGUAZAQUE', 'department_id' => $department->id],
                    ['code_dane' => '25426', 'name' => 'MACHETA', 'department_id' => $department->id],
                    ['code_dane' => '25430', 'name' => 'MADRID', 'department_id' => $department->id],
                    ['code_dane' => '25436', 'name' => 'MANTA', 'department_id' => $department->id],
                    ['code_dane' => '25438', 'name' => 'MEDINA', 'department_id' => $department->id],
                    ['code_dane' => '25473', 'name' => 'MOSQUERA', 'department_id' => $department->id],
                    ['code_dane' => '25483', 'name' => 'NARIÑO', 'department_id' => $department->id],
                    ['code_dane' => '25486', 'name' => 'NEMOCON', 'department_id' => $department->id],
                    ['code_dane' => '25488', 'name' => 'NILO', 'department_id' => $department->id],
                    ['code_dane' => '25489', 'name' => 'NIMAIMA', 'department_id' => $department->id],
                    ['code_dane' => '25491', 'name' => 'NOCAIMA', 'department_id' => $department->id],
                    ['code_dane' => '25506', 'name' => 'VENECIA', 'department_id' => $department->id],
                    ['code_dane' => '25513', 'name' => 'PACHO', 'department_id' => $department->id],
                    ['code_dane' => '25518', 'name' => 'PAIME', 'department_id' => $department->id],
                    ['code_dane' => '25524', 'name' => 'PANDI', 'department_id' => $department->id],
                    ['code_dane' => '25530', 'name' => 'PARATEBUENO', 'department_id' => $department->id],
                    ['code_dane' => '25535', 'name' => 'PASCA', 'department_id' => $department->id],
                    ['code_dane' => '25572', 'name' => 'PUERTO SALGAR', 'department_id' => $department->id],
                    ['code_dane' => '25580', 'name' => 'PULI', 'department_id' => $department->id],
                    ['code_dane' => '25592', 'name' => 'QUEBRADANEGRA', 'department_id' => $department->id],
                    ['code_dane' => '25594', 'name' => 'QUETAME', 'department_id' => $department->id],
                    ['code_dane' => '25596', 'name' => 'QUIPILE', 'department_id' => $department->id],
                    ['code_dane' => '25599', 'name' => 'APULO', 'department_id' => $department->id],
                    ['code_dane' => '25612', 'name' => 'RICAURTE', 'department_id' => $department->id],
                    ['code_dane' => '25645', 'name' => 'SAN ANTONIO DEL TEQUENDAMA', 'department_id' => $department->id],
                    ['code_dane' => '25649', 'name' => 'SAN BERNARDO', 'department_id' => $department->id],
                    ['code_dane' => '25653', 'name' => 'SAN CAYETANO', 'department_id' => $department->id],
                    ['code_dane' => '25658', 'name' => 'SAN FRANCISCO', 'department_id' => $department->id],
                    ['code_dane' => '25662', 'name' => 'SAN JUAN DE RIO SECO', 'department_id' => $department->id],
                    ['code_dane' => '25718', 'name' => 'SASAIMA', 'department_id' => $department->id],
                    ['code_dane' => '25736', 'name' => 'SESQUILE', 'department_id' => $department->id],
                    ['code_dane' => '25740', 'name' => 'SIBATE', 'department_id' => $department->id],
                    ['code_dane' => '25743', 'name' => 'SILVANIA', 'department_id' => $department->id],
                    ['code_dane' => '25745', 'name' => 'SIMIJACA', 'department_id' => $department->id],
                    ['code_dane' => '25754', 'name' => 'SOACHA', 'department_id' => $department->id],
                    ['code_dane' => '25758', 'name' => 'SOPO', 'department_id' => $department->id],
                    ['code_dane' => '25769', 'name' => 'SUBACHOQUE', 'department_id' => $department->id],
                    ['code_dane' => '25772', 'name' => 'SUESCA', 'department_id' => $department->id],
                    ['code_dane' => '25777', 'name' => 'SUPATA', 'department_id' => $department->id],
                    ['code_dane' => '25779', 'name' => 'SUSA', 'department_id' => $department->id],
                    ['code_dane' => '25781', 'name' => 'SUTATAUSA', 'department_id' => $department->id],
                    ['code_dane' => '25785', 'name' => 'TABIO', 'department_id' => $department->id],
                    ['code_dane' => '25793', 'name' => 'TAUSA', 'department_id' => $department->id],
                    ['code_dane' => '25797', 'name' => 'TENA', 'department_id' => $department->id],
                    ['code_dane' => '25799', 'name' => 'TENJO', 'department_id' => $department->id],
                    ['code_dane' => '25805', 'name' => 'TIBACUY', 'department_id' => $department->id],
                    ['code_dane' => '25807', 'name' => 'TIBIRITA', 'department_id' => $department->id],
                    ['code_dane' => '25815', 'name' => 'TOCAIMA', 'department_id' => $department->id],
                    ['code_dane' => '25817', 'name' => 'TOCANCIPA', 'department_id' => $department->id],
                    ['code_dane' => '25823', 'name' => 'TOPAIPI', 'department_id' => $department->id],
                    ['code_dane' => '25839', 'name' => 'UBALA', 'department_id' => $department->id],
                    ['code_dane' => '25841', 'name' => 'UBAQUE', 'department_id' => $department->id],
                    ['code_dane' => '25843', 'name' => 'VILLA DE SAN DIEGO DE UBATE', 'department_id' => $department->id],
                    ['code_dane' => '25845', 'name' => 'UNE', 'department_id' => $department->id],
                    ['code_dane' => '25851', 'name' => 'UTICA', 'department_id' => $department->id],
                    ['code_dane' => '25862', 'name' => 'VERGARA', 'department_id' => $department->id],
                    ['code_dane' => '25867', 'name' => 'VIANI', 'department_id' => $department->id],
                    ['code_dane' => '25871', 'name' => 'VILLAGOMEZ', 'department_id' => $department->id],
                    ['code_dane' => '25873', 'name' => 'VILLAPINZON', 'department_id' => $department->id],
                    ['code_dane' => '25875', 'name' => 'VILLETA', 'department_id' => $department->id],
                    ['code_dane' => '25878', 'name' => 'VIOTA', 'department_id' => $department->id],
                    ['code_dane' => '25885', 'name' => 'YACOPI', 'department_id' => $department->id],
                    ['code_dane' => '25898', 'name' => 'ZIPACON', 'department_id' => $department->id],
                    ['code_dane' => '25899', 'name' => 'ZIPAQUIRA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '27') {
                $cities = [
                    ['code_dane' => '27001', 'name' => 'QUIBDO', 'department_id' => $department->id],
                    ['code_dane' => '27006', 'name' => 'ACANDI', 'department_id' => $department->id],
                    ['code_dane' => '27025', 'name' => 'ALTO BAUDO', 'department_id' => $department->id],
                    ['code_dane' => '27050', 'name' => 'ATRATO', 'department_id' => $department->id],
                    ['code_dane' => '27073', 'name' => 'BAGADO', 'department_id' => $department->id],
                    ['code_dane' => '27075', 'name' => 'BAHIA SOLANO', 'department_id' => $department->id],
                    ['code_dane' => '27077', 'name' => 'BAJO BAUDO', 'department_id' => $department->id],
                    ['code_dane' => '27099', 'name' => 'BOJAYA', 'department_id' => $department->id],
                    ['code_dane' => '27135', 'name' => 'EL CANTON DEL SAN PABLO', 'department_id' => $department->id],
                    ['code_dane' => '27150', 'name' => 'CARMEN DEL DARIEN', 'department_id' => $department->id],
                    ['code_dane' => '27160', 'name' => 'CERTEGUI', 'department_id' => $department->id],
                    ['code_dane' => '27205', 'name' => 'CONDOTO', 'department_id' => $department->id],
                    ['code_dane' => '27245', 'name' => 'EL CARMEN DE ATRATO', 'department_id' => $department->id],
                    ['code_dane' => '27250', 'name' => 'EL LITORAL DEL SAN JUAN', 'department_id' => $department->id],
                    ['code_dane' => '27361', 'name' => 'ISTMINA', 'department_id' => $department->id],
                    ['code_dane' => '27372', 'name' => 'JURADO', 'department_id' => $department->id],
                    ['code_dane' => '27413', 'name' => 'LLORO', 'department_id' => $department->id],
                    ['code_dane' => '27425', 'name' => 'MEDIO ATRATO', 'department_id' => $department->id],
                    ['code_dane' => '27430', 'name' => 'MEDIO BAUDO', 'department_id' => $department->id],
                    ['code_dane' => '27450', 'name' => 'MEDIO SAN JUAN', 'department_id' => $department->id],
                    ['code_dane' => '27491', 'name' => 'NOVITA', 'department_id' => $department->id],
                    ['code_dane' => '27495', 'name' => 'NUQUI', 'department_id' => $department->id],
                    ['code_dane' => '27580', 'name' => 'RIO IRO', 'department_id' => $department->id],
                    ['code_dane' => '27600', 'name' => 'RIO QUITO', 'department_id' => $department->id],
                    ['code_dane' => '27615', 'name' => 'RIOSUCIO (2)', 'department_id' => $department->id],
                    ['code_dane' => '27660', 'name' => 'SAN JOSE DEL PALMAR', 'department_id' => $department->id],
                    ['code_dane' => '27745', 'name' => 'SIPI', 'department_id' => $department->id],
                    ['code_dane' => '27787', 'name' => 'TADO', 'department_id' => $department->id],
                    ['code_dane' => '27800', 'name' => 'UNGUIA', 'department_id' => $department->id],
                    ['code_dane' => '27810', 'name' => 'UNION PANAMERICANA', 'department_id' => $department->id],
                ];

                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '41') {
                $cities = [
                    ['code_dane' => '41001', 'name' => 'NEIVA', 'department_id' => $department->id],
                    ['code_dane' => '41006', 'name' => 'ACEVEDO', 'department_id' => $department->id],
                    ['code_dane' => '41013', 'name' => 'AGRADO', 'department_id' => $department->id],
                    ['code_dane' => '41016', 'name' => 'AIPE', 'department_id' => $department->id],
                    ['code_dane' => '41020', 'name' => 'ALGECIRAS', 'department_id' => $department->id],
                    ['code_dane' => '41026', 'name' => 'ALTAMIRA', 'department_id' => $department->id],
                    ['code_dane' => '41078', 'name' => 'BARAYA', 'department_id' => $department->id],
                    ['code_dane' => '41132', 'name' => 'CAMPOALEGRE', 'department_id' => $department->id],
                    ['code_dane' => '41206', 'name' => 'COLOMBIA', 'department_id' => $department->id],
                    ['code_dane' => '41244', 'name' => 'ELIAS', 'department_id' => $department->id],
                    ['code_dane' => '41298', 'name' => 'GARZON', 'department_id' => $department->id],
                    ['code_dane' => '41306', 'name' => 'GIGANTE', 'department_id' => $department->id],
                    ['code_dane' => '41319', 'name' => 'GUADALUPE', 'department_id' => $department->id],
                    ['code_dane' => '41349', 'name' => 'HOBO', 'department_id' => $department->id],
                    ['code_dane' => '41357', 'name' => 'IQUIRA', 'department_id' => $department->id],
                    ['code_dane' => '41359', 'name' => 'ISNOS', 'department_id' => $department->id],
                    ['code_dane' => '41378', 'name' => 'LA ARGENTINA', 'department_id' => $department->id],
                    ['code_dane' => '41396', 'name' => 'LA PLATA', 'department_id' => $department->id],
                    ['code_dane' => '41483', 'name' => 'NATAGA', 'department_id' => $department->id],
                    ['code_dane' => '41503', 'name' => 'OPORAPA', 'department_id' => $department->id],
                    ['code_dane' => '41518', 'name' => 'PAICOL', 'department_id' => $department->id],
                    ['code_dane' => '41524', 'name' => 'PALERMO', 'department_id' => $department->id],
                    ['code_dane' => '41530', 'name' => 'PALESTINA', 'department_id' => $department->id],
                    ['code_dane' => '41548', 'name' => 'PITAL', 'department_id' => $department->id],
                    ['code_dane' => '41551', 'name' => 'PITALITO', 'department_id' => $department->id],
                    ['code_dane' => '41615', 'name' => 'RIVERA', 'department_id' => $department->id],
                    ['code_dane' => '41660', 'name' => 'SALADOBLANCO', 'department_id' => $department->id],
                    ['code_dane' => '41668', 'name' => 'SAN AGUSTIN', 'department_id' => $department->id],
                    ['code_dane' => '41676', 'name' => 'SANTA MARIA', 'department_id' => $department->id],
                    ['code_dane' => '41770', 'name' => 'SUAZA', 'department_id' => $department->id],
                    ['code_dane' => '41791', 'name' => 'TARQUI', 'department_id' => $department->id],
                    ['code_dane' => '41797', 'name' => 'TESALIA', 'department_id' => $department->id],
                    ['code_dane' => '41799', 'name' => 'TELLO', 'department_id' => $department->id],
                    ['code_dane' => '41801', 'name' => 'TERUEL', 'department_id' => $department->id],
                    ['code_dane' => '41807', 'name' => 'TIMANA', 'department_id' => $department->id],
                    ['code_dane' => '41872', 'name' => 'VILLAVIEJA', 'department_id' => $department->id],
                    ['code_dane' => '41885', 'name' => 'YAGUARA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '44') {
                $cities = [
                    ['code_dane' => '44001', 'name' => 'RIOHACHA', 'department_id' => $department->id],
                    ['code_dane' => '44035', 'name' => 'ALBANIA', 'department_id' => $department->id],
                    ['code_dane' => '44078', 'name' => 'BARRANCAS', 'department_id' => $department->id],
                    ['code_dane' => '44090', 'name' => 'DIBULLA', 'department_id' => $department->id],
                    ['code_dane' => '44098', 'name' => 'DISTRACCION', 'department_id' => $department->id],
                    ['code_dane' => '44110', 'name' => 'EL MOLINO', 'department_id' => $department->id],
                    ['code_dane' => '44279', 'name' => 'FONSECA', 'department_id' => $department->id],
                    ['code_dane' => '44378', 'name' => 'HATONUEVO', 'department_id' => $department->id],
                    ['code_dane' => '44420', 'name' => 'LA JAGUA DEL PILAR', 'department_id' => $department->id],
                    ['code_dane' => '44430', 'name' => 'MAICAO', 'department_id' => $department->id],
                    ['code_dane' => '44560', 'name' => 'MANAURE', 'department_id' => $department->id],
                    ['code_dane' => '44650', 'name' => 'SAN JUAN DEL CESAR', 'department_id' => $department->id],
                    ['code_dane' => '44847', 'name' => 'URIBIA', 'department_id' => $department->id],
                    ['code_dane' => '44855', 'name' => 'URUMITA', 'department_id' => $department->id],
                    ['code_dane' => '44874', 'name' => 'VILLANUEVA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '47') {
                $cities = [
                    ['code_dane' => '47001', 'name' => 'SANTA MARTA', 'department_id' => $department->id],
                    ['code_dane' => '47030', 'name' => 'ALGARROBO', 'department_id' => $department->id],
                    ['code_dane' => '47053', 'name' => 'ARACATACA', 'department_id' => $department->id],
                    ['code_dane' => '47058', 'name' => 'ARIGUANI', 'department_id' => $department->id],
                    ['code_dane' => '47161', 'name' => 'CERRO SAN ANTONIO', 'department_id' => $department->id],
                    ['code_dane' => '47170', 'name' => 'CHIBOLO', 'department_id' => $department->id],
                    ['code_dane' => '47189', 'name' => 'CIENAGA', 'department_id' => $department->id],
                    ['code_dane' => '47205', 'name' => 'CONCORDIA', 'department_id' => $department->id],
                    ['code_dane' => '47245', 'name' => 'EL BANCO', 'department_id' => $department->id],
                    ['code_dane' => '47258', 'name' => 'EL PIÑON', 'department_id' => $department->id],
                    ['code_dane' => '47268', 'name' => 'EL RETEN', 'department_id' => $department->id],
                    ['code_dane' => '47288', 'name' => 'FUNDACION', 'department_id' => $department->id],
                    ['code_dane' => '47318', 'name' => 'GUAMAL', 'department_id' => $department->id],
                    ['code_dane' => '47460', 'name' => 'NUEVA GRANADA', 'department_id' => $department->id],
                    ['code_dane' => '47541', 'name' => 'PEDRAZA', 'department_id' => $department->id],
                    ['code_dane' => '47545', 'name' => 'PIJIÑO DEL CARMEN', 'department_id' => $department->id],
                    ['code_dane' => '47551', 'name' => 'PIVIJAY', 'department_id' => $department->id],
                    ['code_dane' => '47555', 'name' => 'PLATO', 'department_id' => $department->id],
                    ['code_dane' => '47570', 'name' => 'PUEBLOVIEJO', 'department_id' => $department->id],
                    ['code_dane' => '47605', 'name' => 'REMOLINO', 'department_id' => $department->id],
                    ['code_dane' => '47660', 'name' => 'SABANAS DE SAN ANGEL', 'department_id' => $department->id],
                    ['code_dane' => '47675', 'name' => 'SALAMINA', 'department_id' => $department->id],
                    ['code_dane' => '47692', 'name' => 'SAN SEBASTIAN DE BUENAVISTA', 'department_id' => $department->id],
                    ['code_dane' => '47703', 'name' => 'SAN ZENON', 'department_id' => $department->id],
                    ['code_dane' => '47707', 'name' => 'SANTA ANA', 'department_id' => $department->id],
                    ['code_dane' => '47720', 'name' => 'SANTA BARBARA DE PINTO', 'department_id' => $department->id],
                    ['code_dane' => '47745', 'name' => 'SITIONUEVO', 'department_id' => $department->id],
                    ['code_dane' => '47798', 'name' => 'TENERIFE', 'department_id' => $department->id],
                    ['code_dane' => '47960', 'name' => 'ZAPAYAN', 'department_id' => $department->id],
                    ['code_dane' => '47980', 'name' => 'ZONA BANANERA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '50') {
                $cities = [
                    ['code_dane' => '50001', 'name' => 'VILLAVICENCIO', 'department_id' => $department->id],
                    ['code_dane' => '50006', 'name' => 'ACACIAS', 'department_id' => $department->id],
                    ['code_dane' => '50110', 'name' => 'BARRANCA DE UPIA', 'department_id' => $department->id],
                    ['code_dane' => '50124', 'name' => 'CABUYARO', 'department_id' => $department->id],
                    ['code_dane' => '50150', 'name' => 'CASTILLA LA NUEVA', 'department_id' => $department->id],
                    ['code_dane' => '50223', 'name' => 'CUBARRAL', 'department_id' => $department->id],
                    ['code_dane' => '50226', 'name' => 'CUMARAL', 'department_id' => $department->id],
                    ['code_dane' => '50245', 'name' => 'EL CALVARIO', 'department_id' => $department->id],
                    ['code_dane' => '50251', 'name' => 'EL CASTILLO', 'department_id' => $department->id],
                    ['code_dane' => '50270', 'name' => 'EL DORADO', 'department_id' => $department->id],
                    ['code_dane' => '50287', 'name' => 'FUENTE DE ORO', 'department_id' => $department->id],
                    ['code_dane' => '50313', 'name' => 'GRANADA', 'department_id' => $department->id],
                    ['code_dane' => '50318', 'name' => 'GUAMAL', 'department_id' => $department->id],
                    ['code_dane' => '50325', 'name' => 'MAPIRIPAN', 'department_id' => $department->id],
                    ['code_dane' => '50330', 'name' => 'MESETAS', 'department_id' => $department->id],
                    ['code_dane' => '50350', 'name' => 'LA MACARENA', 'department_id' => $department->id],
                    ['code_dane' => '50370', 'name' => 'URIBE', 'department_id' => $department->id],
                    ['code_dane' => '50400', 'name' => 'LEJANIAS', 'department_id' => $department->id],
                    ['code_dane' => '50450', 'name' => 'PUERTO CONCORDIA', 'department_id' => $department->id],
                    ['code_dane' => '50568', 'name' => 'PUERTO GAITAN', 'department_id' => $department->id],
                    ['code_dane' => '50573', 'name' => 'PUERTO LOPEZ', 'department_id' => $department->id],
                    ['code_dane' => '50577', 'name' => 'PUERTO LLERAS', 'department_id' => $department->id],
                    ['code_dane' => '50590', 'name' => 'PUERTO RICO', 'department_id' => $department->id],
                    ['code_dane' => '50606', 'name' => 'RESTREPO', 'department_id' => $department->id],
                    ['code_dane' => '50680', 'name' => 'SAN CARLOS DE GUAROA', 'department_id' => $department->id],
                    ['code_dane' => '50683', 'name' => 'SAN JUAN DE ARAMA', 'department_id' => $department->id],
                    ['code_dane' => '50686', 'name' => 'SAN JUANITO', 'department_id' => $department->id],
                    ['code_dane' => '50689', 'name' => 'SAN MARTIN', 'department_id' => $department->id],
                    ['code_dane' => '50711', 'name' => 'VISTAHERMOSA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '52') {
                $cities = [
                    ['code_dane' => '52001', 'name' => 'PASTO', 'department_id' => $department->id],
                    ['code_dane' => '52019', 'name' => 'ALBAN', 'department_id' => $department->id],
                    ['code_dane' => '52022', 'name' => 'ALDANA', 'department_id' => $department->id],
                    ['code_dane' => '52036', 'name' => 'ANCUYA', 'department_id' => $department->id],
                    ['code_dane' => '52051', 'name' => 'ARBOLEDA', 'department_id' => $department->id],
                    ['code_dane' => '52079', 'name' => 'BARBACOAS', 'department_id' => $department->id],
                    ['code_dane' => '52083', 'name' => 'BELEN', 'department_id' => $department->id],
                    ['code_dane' => '52110', 'name' => 'BUESACO', 'department_id' => $department->id],
                    ['code_dane' => '52203', 'name' => 'COLON', 'department_id' => $department->id],
                    ['code_dane' => '52207', 'name' => 'CONSACA', 'department_id' => $department->id],
                    ['code_dane' => '52210', 'name' => 'CONTADERO', 'department_id' => $department->id],
                    ['code_dane' => '52215', 'name' => 'CORDOBA', 'department_id' => $department->id],
                    ['code_dane' => '52224', 'name' => 'CUASPUD', 'department_id' => $department->id],
                    ['code_dane' => '52227', 'name' => 'CUMBAL', 'department_id' => $department->id],
                    ['code_dane' => '52233', 'name' => 'CUMBITARA', 'department_id' => $department->id],
                    ['code_dane' => '52240', 'name' => 'CHACHAGsI', 'department_id' => $department->id],
                    ['code_dane' => '52250', 'name' => 'EL CHARCO', 'department_id' => $department->id],
                    ['code_dane' => '52254', 'name' => 'EL PEÑOL', 'department_id' => $department->id],
                    ['code_dane' => '52256', 'name' => 'EL ROSARIO', 'department_id' => $department->id],
                    ['code_dane' => '52258', 'name' => 'EL TABLON DE GOMEZ', 'department_id' => $department->id],
                    ['code_dane' => '52260', 'name' => 'EL TAMBO', 'department_id' => $department->id],
                    ['code_dane' => '52287', 'name' => 'FUNES', 'department_id' => $department->id],
                    ['code_dane' => '52317', 'name' => 'GUACHUCAL', 'department_id' => $department->id],
                    ['code_dane' => '52320', 'name' => 'GUAITARILLA', 'department_id' => $department->id],
                    ['code_dane' => '52323', 'name' => 'GUALMATAN', 'department_id' => $department->id],
                    ['code_dane' => '52352', 'name' => 'ILES', 'department_id' => $department->id],
                    ['code_dane' => '52354', 'name' => 'IMUES', 'department_id' => $department->id],
                    ['code_dane' => '52356', 'name' => 'IPIALES', 'department_id' => $department->id],
                    ['code_dane' => '52378', 'name' => 'LA CRUZ', 'department_id' => $department->id],
                    ['code_dane' => '52381', 'name' => 'LA FLORIDA', 'department_id' => $department->id],
                    ['code_dane' => '52385', 'name' => 'LA LLANADA', 'department_id' => $department->id],
                    ['code_dane' => '52390', 'name' => 'LA TOLA', 'department_id' => $department->id],
                    ['code_dane' => '52399', 'name' => 'LA UNION', 'department_id' => $department->id],
                    ['code_dane' => '52405', 'name' => 'LEIVA', 'department_id' => $department->id],
                    ['code_dane' => '52411', 'name' => 'LINARES', 'department_id' => $department->id],
                    ['code_dane' => '52418', 'name' => 'LOS ANDES', 'department_id' => $department->id],
                    ['code_dane' => '52427', 'name' => 'MAGsI', 'department_id' => $department->id],
                    ['code_dane' => '52435', 'name' => 'MALLAMA', 'department_id' => $department->id],
                    ['code_dane' => '52473', 'name' => 'MOSQUERA', 'department_id' => $department->id],
                    ['code_dane' => '52480', 'name' => 'NARIÑO', 'department_id' => $department->id],
                    ['code_dane' => '52490', 'name' => 'OLAYA HERRERA', 'department_id' => $department->id],
                    ['code_dane' => '52506', 'name' => 'OSPINA', 'department_id' => $department->id],
                    ['code_dane' => '52520', 'name' => 'FRANCISCO PIZARRO', 'department_id' => $department->id],
                    ['code_dane' => '52540', 'name' => 'POLICARPA', 'department_id' => $department->id],
                    ['code_dane' => '52560', 'name' => 'POTOSI', 'department_id' => $department->id],
                    ['code_dane' => '52565', 'name' => 'PROVIDENCIA', 'department_id' => $department->id],
                    ['code_dane' => '52573', 'name' => 'PUERRES', 'department_id' => $department->id],
                    ['code_dane' => '52585', 'name' => 'PUPIALES', 'department_id' => $department->id],
                    ['code_dane' => '52612', 'name' => 'RICAURTE', 'department_id' => $department->id],
                    ['code_dane' => '52621', 'name' => 'ROBERTO PAYAN', 'department_id' => $department->id],
                    ['code_dane' => '52678', 'name' => 'SAMANIEGO', 'department_id' => $department->id],
                    ['code_dane' => '52683', 'name' => 'SANDONA', 'department_id' => $department->id],
                    ['code_dane' => '52685', 'name' => 'SAN BERNARDO', 'department_id' => $department->id],
                    ['code_dane' => '52687', 'name' => 'SAN LORENZO', 'department_id' => $department->id],
                    ['code_dane' => '52693', 'name' => 'SAN PABLO', 'department_id' => $department->id],
                    ['code_dane' => '52694', 'name' => 'SAN PEDRO DE CARTAGO', 'department_id' => $department->id],
                    ['code_dane' => '52696', 'name' => 'SANTA BARBARA', 'department_id' => $department->id],
                    ['code_dane' => '52699', 'name' => 'SANTACRUZ', 'department_id' => $department->id],
                    ['code_dane' => '52720', 'name' => 'SAPUYES', 'department_id' => $department->id],
                    ['code_dane' => '52786', 'name' => 'TAMINANGO', 'department_id' => $department->id],
                    ['code_dane' => '52788', 'name' => 'TANGUA', 'department_id' => $department->id],
                    ['code_dane' => '52835', 'name' => 'SAN ANDRES DE TUMACO', 'department_id' => $department->id],
                    ['code_dane' => '52838', 'name' => 'TUQUERRES', 'department_id' => $department->id],
                    ['code_dane' => '52885', 'name' => 'YACUANQUER', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '54') {
                $cities = [
                    ['code_dane' => '54001', 'name' => 'CUCUTA', 'department_id' => $department->id],
                    ['code_dane' => '54003', 'name' => 'ABREGO', 'department_id' => $department->id],
                    ['code_dane' => '54051', 'name' => 'ARBOLEDAS', 'department_id' => $department->id],
                    ['code_dane' => '54099', 'name' => 'BOCHALEMA', 'department_id' => $department->id],
                    ['code_dane' => '54109', 'name' => 'BUCARASICA', 'department_id' => $department->id],
                    ['code_dane' => '54125', 'name' => 'CACOTA', 'department_id' => $department->id],
                    ['code_dane' => '54128', 'name' => 'CACHIRA', 'department_id' => $department->id],
                    ['code_dane' => '54172', 'name' => 'CHINACOTA', 'department_id' => $department->id],
                    ['code_dane' => '54174', 'name' => 'CHITAGA', 'department_id' => $department->id],
                    ['code_dane' => '54206', 'name' => 'CONVENCION', 'department_id' => $department->id],
                    ['code_dane' => '54223', 'name' => 'CUCUTILLA', 'department_id' => $department->id],
                    ['code_dane' => '54239', 'name' => 'DURANIA', 'department_id' => $department->id],
                    ['code_dane' => '54245', 'name' => 'EL CARMEN', 'department_id' => $department->id],
                    ['code_dane' => '54250', 'name' => 'EL TARRA', 'department_id' => $department->id],
                    ['code_dane' => '54261', 'name' => 'EL ZULIA', 'department_id' => $department->id],
                    ['code_dane' => '54313', 'name' => 'GRAMALOTE', 'department_id' => $department->id],
                    ['code_dane' => '54344', 'name' => 'HACARI', 'department_id' => $department->id],
                    ['code_dane' => '54347', 'name' => 'HERRAN', 'department_id' => $department->id],
                    ['code_dane' => '54377', 'name' => 'LABATECA', 'department_id' => $department->id],
                    ['code_dane' => '54385', 'name' => 'LA ESPERANZA', 'department_id' => $department->id],
                    ['code_dane' => '54398', 'name' => 'LA PLAYA', 'department_id' => $department->id],
                    ['code_dane' => '54405', 'name' => 'LOS PATIOS', 'department_id' => $department->id],
                    ['code_dane' => '54418', 'name' => 'LOURDES', 'department_id' => $department->id],
                    ['code_dane' => '54480', 'name' => 'MUTISCUA', 'department_id' => $department->id],
                    ['code_dane' => '54498', 'name' => 'OCAÑA', 'department_id' => $department->id],
                    ['code_dane' => '54518', 'name' => 'PAMPLONA', 'department_id' => $department->id],
                    ['code_dane' => '54520', 'name' => 'PAMPLONITA', 'department_id' => $department->id],
                    ['code_dane' => '54553', 'name' => 'PUERTO SANTANDER', 'department_id' => $department->id],
                    ['code_dane' => '54599', 'name' => 'RAGONVALIA', 'department_id' => $department->id],
                    ['code_dane' => '54660', 'name' => 'SALAZAR', 'department_id' => $department->id],
                    ['code_dane' => '54670', 'name' => 'SAN CALIXTO', 'department_id' => $department->id],
                    ['code_dane' => '54673', 'name' => 'SAN CAYETANO', 'department_id' => $department->id],
                    ['code_dane' => '54680', 'name' => 'SANTIAGO', 'department_id' => $department->id],
                    ['code_dane' => '54720', 'name' => 'SARDINATA', 'department_id' => $department->id],
                    ['code_dane' => '54743', 'name' => 'SILOS', 'department_id' => $department->id],
                    ['code_dane' => '54800', 'name' => 'TEORAMA', 'department_id' => $department->id],
                    ['code_dane' => '54810', 'name' => 'TIBU', 'department_id' => $department->id],
                    ['code_dane' => '54820', 'name' => 'TOLEDO', 'department_id' => $department->id],
                    ['code_dane' => '54871', 'name' => 'VILLA CARO', 'department_id' => $department->id],
                    ['code_dane' => '54874', 'name' => 'VILLA DEL ROSARIO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '63') {
                $cities = [
                    ['code_dane' => '63001', 'name' => 'ARMENIA', 'department_id' => $department->id],
                    ['code_dane' => '63111', 'name' => 'BUENAVISTA', 'department_id' => $department->id],
                    ['code_dane' => '63130', 'name' => 'CALARCA', 'department_id' => $department->id],
                    ['code_dane' => '63190', 'name' => 'CIRCASIA', 'department_id' => $department->id],
                    ['code_dane' => '63212', 'name' => 'CORDOBA', 'department_id' => $department->id],
                    ['code_dane' => '63272', 'name' => 'FILANDIA', 'department_id' => $department->id],
                    ['code_dane' => '63302', 'name' => 'GENOVA', 'department_id' => $department->id],
                    ['code_dane' => '63401', 'name' => 'LA TEBAIDA', 'department_id' => $department->id],
                    ['code_dane' => '63470', 'name' => 'MONTENEGRO', 'department_id' => $department->id],
                    ['code_dane' => '63548', 'name' => 'PIJAO', 'department_id' => $department->id],
                    ['code_dane' => '63594', 'name' => 'QUIMBAYA', 'department_id' => $department->id],
                    ['code_dane' => '63690', 'name' => 'SALENTO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '66') {
                $cities = [
                    ['code_dane' => '66001', 'name' => 'PEREIRA', 'department_id' => $department->id],
                    ['code_dane' => '66045', 'name' => 'APIA', 'department_id' => $department->id],
                    ['code_dane' => '66075', 'name' => 'BALBOA', 'department_id' => $department->id],
                    ['code_dane' => '66088', 'name' => 'BELEN DE UMBRIA', 'department_id' => $department->id],
                    ['code_dane' => '66170', 'name' => 'DOSQUEBRADAS', 'department_id' => $department->id],
                    ['code_dane' => '66318', 'name' => 'GUATICA', 'department_id' => $department->id],
                    ['code_dane' => '66383', 'name' => 'LA CELIA', 'department_id' => $department->id],
                    ['code_dane' => '66400', 'name' => 'LA VIRGINIA', 'department_id' => $department->id],
                    ['code_dane' => '66440', 'name' => 'MARSELLA', 'department_id' => $department->id],
                    ['code_dane' => '66456', 'name' => 'MISTRATO', 'department_id' => $department->id],
                    ['code_dane' => '66572', 'name' => 'PUEBLO RICO', 'department_id' => $department->id],
                    ['code_dane' => '66594', 'name' => 'QUINCHIA', 'department_id' => $department->id],
                    ['code_dane' => '66682', 'name' => 'SANTA ROSA DE CABAL', 'department_id' => $department->id],
                    ['code_dane' => '66687', 'name' => 'SANTUARIO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '68') {
                $cities = [
                    ['code_dane' => '68001', 'name' => 'BUCARAMANGA', 'department_id' => $department->id],
                    ['code_dane' => '68013', 'name' => 'AGUADA', 'department_id' => $department->id],
                    ['code_dane' => '68020', 'name' => 'ALBANIA', 'department_id' => $department->id],
                    ['code_dane' => '68051', 'name' => 'ARATOCA', 'department_id' => $department->id],
                    ['code_dane' => '68077', 'name' => 'BARBOSA', 'department_id' => $department->id],
                    ['code_dane' => '68079', 'name' => 'BARICHARA', 'department_id' => $department->id],
                    ['code_dane' => '68081', 'name' => 'BARRANCABERMEJA', 'department_id' => $department->id],
                    ['code_dane' => '68092', 'name' => 'BETULIA', 'department_id' => $department->id],
                    ['code_dane' => '68101', 'name' => 'BOLIVAR', 'department_id' => $department->id],
                    ['code_dane' => '68121', 'name' => 'CABRERA', 'department_id' => $department->id],
                    ['code_dane' => '68132', 'name' => 'CALIFORNIA', 'department_id' => $department->id],
                    ['code_dane' => '68147', 'name' => 'CAPITANEJO', 'department_id' => $department->id],
                    ['code_dane' => '68152', 'name' => 'CARCASI', 'department_id' => $department->id],
                    ['code_dane' => '68160', 'name' => 'CEPITA', 'department_id' => $department->id],
                    ['code_dane' => '68162', 'name' => 'CERRITO', 'department_id' => $department->id],
                    ['code_dane' => '68167', 'name' => 'CHARALA', 'department_id' => $department->id],
                    ['code_dane' => '68169', 'name' => 'CHARTA', 'department_id' => $department->id],
                    ['code_dane' => '68176', 'name' => 'CHIMA', 'department_id' => $department->id],
                    ['code_dane' => '68179', 'name' => 'CHIPATA', 'department_id' => $department->id],
                    ['code_dane' => '68190', 'name' => 'CIMITARRA', 'department_id' => $department->id],
                    ['code_dane' => '68207', 'name' => 'CONCEPCION', 'department_id' => $department->id],
                    ['code_dane' => '68209', 'name' => 'CONFINES', 'department_id' => $department->id],
                    ['code_dane' => '68211', 'name' => 'CONTRATACION', 'department_id' => $department->id],
                    ['code_dane' => '68217', 'name' => 'COROMORO', 'department_id' => $department->id],
                    ['code_dane' => '68229', 'name' => 'CURITI', 'department_id' => $department->id],
                    ['code_dane' => '68235', 'name' => 'EL CARMEN DE CHUCURI', 'department_id' => $department->id],
                    ['code_dane' => '68245', 'name' => 'EL GUACAMAYO', 'department_id' => $department->id],
                    ['code_dane' => '68250', 'name' => 'EL PEÑON', 'department_id' => $department->id],
                    ['code_dane' => '68255', 'name' => 'EL PLAYON', 'department_id' => $department->id],
                    ['code_dane' => '68264', 'name' => 'ENCINO', 'department_id' => $department->id],
                    ['code_dane' => '68266', 'name' => 'ENCISO', 'department_id' => $department->id],
                    ['code_dane' => '68271', 'name' => 'FLORIAN', 'department_id' => $department->id],
                    ['code_dane' => '68276', 'name' => 'FLORIDABLANCA', 'department_id' => $department->id],
                    ['code_dane' => '68296', 'name' => 'GALAN', 'department_id' => $department->id],
                    ['code_dane' => '68298', 'name' => 'GAMBITA', 'department_id' => $department->id],
                    ['code_dane' => '68307', 'name' => 'GIRON', 'department_id' => $department->id],
                    ['code_dane' => '68318', 'name' => 'GUACA', 'department_id' => $department->id],
                    ['code_dane' => '68320', 'name' => 'GUADALUPE', 'department_id' => $department->id],
                    ['code_dane' => '68322', 'name' => 'GUAPOTA', 'department_id' => $department->id],
                    ['code_dane' => '68324', 'name' => 'GUAVATA', 'department_id' => $department->id],
                    ['code_dane' => '68327', 'name' => 'GsEPSA', 'department_id' => $department->id],
                    ['code_dane' => '68344', 'name' => 'HATO', 'department_id' => $department->id],
                    ['code_dane' => '68368', 'name' => 'JESUS MARIA', 'department_id' => $department->id],
                    ['code_dane' => '68370', 'name' => 'JORDAN', 'department_id' => $department->id],
                    ['code_dane' => '68377', 'name' => 'LA BELLEZA', 'department_id' => $department->id],
                    ['code_dane' => '68385', 'name' => 'LANDAZURI', 'department_id' => $department->id],
                    ['code_dane' => '68397', 'name' => 'LA PAZ', 'department_id' => $department->id],
                    ['code_dane' => '68406', 'name' => 'LEBRIJA', 'department_id' => $department->id],
                    ['code_dane' => '68418', 'name' => 'LOS SANTOS', 'department_id' => $department->id],
                    ['code_dane' => '68425', 'name' => 'MACARAVITA', 'department_id' => $department->id],
                    ['code_dane' => '68432', 'name' => 'MALAGA', 'department_id' => $department->id],
                    ['code_dane' => '68444', 'name' => 'MATANZA', 'department_id' => $department->id],
                    ['code_dane' => '68464', 'name' => 'MOGOTES', 'department_id' => $department->id],
                    ['code_dane' => '68468', 'name' => 'MOLAGAVITA', 'department_id' => $department->id],
                    ['code_dane' => '68498', 'name' => 'OCAMONTE', 'department_id' => $department->id],
                    ['code_dane' => '68500', 'name' => 'OIBA', 'department_id' => $department->id],
                    ['code_dane' => '68502', 'name' => 'ONZAGA', 'department_id' => $department->id],
                    ['code_dane' => '68522', 'name' => 'PALMAR', 'department_id' => $department->id],
                    ['code_dane' => '68524', 'name' => 'PALMAS DEL SOCORRO', 'department_id' => $department->id],
                    ['code_dane' => '68533', 'name' => 'PARAMO', 'department_id' => $department->id],
                    ['code_dane' => '68547', 'name' => 'PIEDECUESTA', 'department_id' => $department->id],
                    ['code_dane' => '68549', 'name' => 'PINCHOTE', 'department_id' => $department->id],
                    ['code_dane' => '68572', 'name' => 'PUENTE NACIONAL', 'department_id' => $department->id],
                    ['code_dane' => '68573', 'name' => 'PUERTO PARRA', 'department_id' => $department->id],
                    ['code_dane' => '68575', 'name' => 'PUERTO WILCHES', 'department_id' => $department->id],
                    ['code_dane' => '68615', 'name' => 'RIONEGRO', 'department_id' => $department->id],
                    ['code_dane' => '68655', 'name' => 'SABANA DE TORRES', 'department_id' => $department->id],
                    ['code_dane' => '68669', 'name' => 'SAN ANDRES', 'department_id' => $department->id],
                    ['code_dane' => '68673', 'name' => 'SAN BENITO', 'department_id' => $department->id],
                    ['code_dane' => '68679', 'name' => 'SAN GIL', 'department_id' => $department->id],
                    ['code_dane' => '68682', 'name' => 'SAN JOAQUIN', 'department_id' => $department->id],
                    ['code_dane' => '68684', 'name' => 'SAN JOSE DE MIRANDA', 'department_id' => $department->id],
                    ['code_dane' => '68686', 'name' => 'SAN MIGUEL', 'department_id' => $department->id],
                    ['code_dane' => '68689', 'name' => 'SAN VICENTE DE CHUCURI', 'department_id' => $department->id],
                    ['code_dane' => '68705', 'name' => 'SANTA BARBARA', 'department_id' => $department->id],
                    ['code_dane' => '68720', 'name' => 'SANTA HELENA DEL OPON', 'department_id' => $department->id],
                    ['code_dane' => '68745', 'name' => 'SIMACOTA', 'department_id' => $department->id],
                    ['code_dane' => '68755', 'name' => 'SOCORRO', 'department_id' => $department->id],
                    ['code_dane' => '68770', 'name' => 'SUAITA', 'department_id' => $department->id],
                    ['code_dane' => '68773', 'name' => 'SUCRE', 'department_id' => $department->id],
                    ['code_dane' => '68780', 'name' => 'SURATA', 'department_id' => $department->id],
                    ['code_dane' => '68820', 'name' => 'TONA', 'department_id' => $department->id],
                    ['code_dane' => '68855', 'name' => 'VALLE DE SAN JOSE', 'department_id' => $department->id],
                    ['code_dane' => '68861', 'name' => 'VELEZ', 'department_id' => $department->id],
                    ['code_dane' => '68867', 'name' => 'VETAS', 'department_id' => $department->id],
                    ['code_dane' => '68872', 'name' => 'VILLANUEVA', 'department_id' => $department->id],
                    ['code_dane' => '68895', 'name' => 'ZAPATOCA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '70') {
                $cities = [
                    ['code_dane' => '70001', 'name' => 'SINCELEJO', 'department_id' => $department->id],
                    ['code_dane' => '70110', 'name' => 'BUENAVISTA', 'department_id' => $department->id],
                    ['code_dane' => '70124', 'name' => 'CAIMITO', 'department_id' => $department->id],
                    ['code_dane' => '70204', 'name' => 'COLOSO', 'department_id' => $department->id],
                    ['code_dane' => '70215', 'name' => 'COROZAL', 'department_id' => $department->id],
                    ['code_dane' => '70221', 'name' => 'COVEÑAS', 'department_id' => $department->id],
                    ['code_dane' => '70230', 'name' => 'CHALAN', 'department_id' => $department->id],
                    ['code_dane' => '70233', 'name' => 'EL ROBLE', 'department_id' => $department->id],
                    ['code_dane' => '70235', 'name' => 'GALERAS', 'department_id' => $department->id],
                    ['code_dane' => '70265', 'name' => 'GUARANDA', 'department_id' => $department->id],
                    ['code_dane' => '70400', 'name' => 'LA UNION', 'department_id' => $department->id],
                    ['code_dane' => '70418', 'name' => 'LOS PALMITOS', 'department_id' => $department->id],
                    ['code_dane' => '70429', 'name' => 'MAJAGUAL', 'department_id' => $department->id],
                    ['code_dane' => '70473', 'name' => 'MORROA', 'department_id' => $department->id],
                    ['code_dane' => '70508', 'name' => 'OVEJAS', 'department_id' => $department->id],
                    ['code_dane' => '70523', 'name' => 'PALMITO', 'department_id' => $department->id],
                    ['code_dane' => '70670', 'name' => 'SAMPUES', 'department_id' => $department->id],
                    ['code_dane' => '70678', 'name' => 'SAN BENITO ABAD', 'department_id' => $department->id],
                    ['code_dane' => '70702', 'name' => 'SAN JUAN DE BETULIA', 'department_id' => $department->id],
                    ['code_dane' => '70708', 'name' => 'SAN MARCOS', 'department_id' => $department->id],
                    ['code_dane' => '70713', 'name' => 'SAN ONOFRE', 'department_id' => $department->id],
                    ['code_dane' => '70717', 'name' => 'SAN PEDRO', 'department_id' => $department->id],
                    ['code_dane' => '70742', 'name' => 'SAN LUIS DE SINCE', 'department_id' => $department->id],
                    ['code_dane' => '70771', 'name' => 'SUCRE', 'department_id' => $department->id],
                    ['code_dane' => '70820', 'name' => 'SANTIAGO DE TOLU', 'department_id' => $department->id],
                    ['code_dane' => '70823', 'name' => 'TOLU VIEJO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '73') {
                $cities = [
                    ['code_dane' => '73001', 'name' => 'IBAGUE', 'department_id' => $department->id],
                    ['code_dane' => '73024', 'name' => 'ALPUJARRA', 'department_id' => $department->id],
                    ['code_dane' => '73026', 'name' => 'ALVARADO', 'department_id' => $department->id],
                    ['code_dane' => '73030', 'name' => 'AMBALEMA', 'department_id' => $department->id],
                    ['code_dane' => '73043', 'name' => 'ANZOATEGUI', 'department_id' => $department->id],
                    ['code_dane' => '73055', 'name' => 'ARMERO', 'department_id' => $department->id],
                    ['code_dane' => '73067', 'name' => 'ATACO', 'department_id' => $department->id],
                    ['code_dane' => '73124', 'name' => 'CAJAMARCA', 'department_id' => $department->id],
                    ['code_dane' => '73148', 'name' => 'CARMEN DE APICALA', 'department_id' => $department->id],
                    ['code_dane' => '73152', 'name' => 'CASABIANCA', 'department_id' => $department->id],
                    ['code_dane' => '73168', 'name' => 'CHAPARRAL', 'department_id' => $department->id],
                    ['code_dane' => '73200', 'name' => 'COELLO', 'department_id' => $department->id],
                    ['code_dane' => '73217', 'name' => 'COYAIMA', 'department_id' => $department->id],
                    ['code_dane' => '73226', 'name' => 'CUNDAY', 'department_id' => $department->id],
                    ['code_dane' => '73236', 'name' => 'DOLORES', 'department_id' => $department->id],
                    ['code_dane' => '73268', 'name' => 'ESPINAL', 'department_id' => $department->id],
                    ['code_dane' => '73270', 'name' => 'FALAN', 'department_id' => $department->id],
                    ['code_dane' => '73275', 'name' => 'FLANDES', 'department_id' => $department->id],
                    ['code_dane' => '73283', 'name' => 'FRESNO', 'department_id' => $department->id],
                    ['code_dane' => '73319', 'name' => 'GUAMO', 'department_id' => $department->id],
                    ['code_dane' => '73347', 'name' => 'HERVEO', 'department_id' => $department->id],
                    ['code_dane' => '73349', 'name' => 'HONDA', 'department_id' => $department->id],
                    ['code_dane' => '73352', 'name' => 'ICONONZO', 'department_id' => $department->id],
                    ['code_dane' => '73408', 'name' => 'LERIDA', 'department_id' => $department->id],
                    ['code_dane' => '73411', 'name' => 'LIBANO', 'department_id' => $department->id],
                    ['code_dane' => '73443', 'name' => 'MARIQUITA', 'department_id' => $department->id],
                    ['code_dane' => '73449', 'name' => 'MELGAR', 'department_id' => $department->id],
                    ['code_dane' => '73461', 'name' => 'MURILLO', 'department_id' => $department->id],
                    ['code_dane' => '73483', 'name' => 'NATAGAIMA', 'department_id' => $department->id],
                    ['code_dane' => '73504', 'name' => 'ORTEGA', 'department_id' => $department->id],
                    ['code_dane' => '73520', 'name' => 'PALOCABILDO', 'department_id' => $department->id],
                    ['code_dane' => '73547', 'name' => 'PIEDRAS', 'department_id' => $department->id],
                    ['code_dane' => '73555', 'name' => 'PLANADAS', 'department_id' => $department->id],
                    ['code_dane' => '73563', 'name' => 'PRADO', 'department_id' => $department->id],
                    ['code_dane' => '73585', 'name' => 'PURIFICACION', 'department_id' => $department->id],
                    ['code_dane' => '73616', 'name' => 'RIOBLANCO', 'department_id' => $department->id],
                    ['code_dane' => '73622', 'name' => 'RONCESVALLES', 'department_id' => $department->id],
                    ['code_dane' => '73624', 'name' => 'ROVIRA', 'department_id' => $department->id],
                    ['code_dane' => '73671', 'name' => 'SALDAÑA', 'department_id' => $department->id],
                    ['code_dane' => '73675', 'name' => 'SAN ANTONIO', 'department_id' => $department->id],
                    ['code_dane' => '73678', 'name' => 'SAN LUIS', 'department_id' => $department->id],
                    ['code_dane' => '73686', 'name' => 'SANTA ISABEL', 'department_id' => $department->id],
                    ['code_dane' => '73770', 'name' => 'SUAREZ', 'department_id' => $department->id],
                    ['code_dane' => '73854', 'name' => 'VALLE DE SAN JUAN', 'department_id' => $department->id],
                    ['code_dane' => '73861', 'name' => 'VENADILLO', 'department_id' => $department->id],
                    ['code_dane' => '73870', 'name' => 'VILLAHERMOSA', 'department_id' => $department->id],
                    ['code_dane' => '73873', 'name' => 'VILLARRICA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '76') {
                $cities = [
                    ['code_dane' => '76001', 'name' => 'CALI', 'department_id' => $department->id],
                    ['code_dane' => '76020', 'name' => 'ALCALA', 'department_id' => $department->id],
                    ['code_dane' => '76036', 'name' => 'ANDALUCIA', 'department_id' => $department->id],
                    ['code_dane' => '76041', 'name' => 'ANSERMANUEVO', 'department_id' => $department->id],
                    ['code_dane' => '76054', 'name' => 'ARGELIA', 'department_id' => $department->id],
                    ['code_dane' => '76100', 'name' => 'BOLIVAR', 'department_id' => $department->id],
                    ['code_dane' => '76109', 'name' => 'BUENAVENTURA', 'department_id' => $department->id],
                    ['code_dane' => '76111', 'name' => 'GUADALAJARA DE BUGA', 'department_id' => $department->id],
                    ['code_dane' => '76113', 'name' => 'BUGALAGRANDE', 'department_id' => $department->id],
                    ['code_dane' => '76122', 'name' => 'CAICEDONIA', 'department_id' => $department->id],
                    ['code_dane' => '76126', 'name' => 'CALIMA', 'department_id' => $department->id],
                    ['code_dane' => '76130', 'name' => 'CANDELARIA', 'department_id' => $department->id],
                    ['code_dane' => '76147', 'name' => 'CARTAGO', 'department_id' => $department->id],
                    ['code_dane' => '76233', 'name' => 'DAGUA', 'department_id' => $department->id],
                    ['code_dane' => '76243', 'name' => 'EL AGUILA', 'department_id' => $department->id],
                    ['code_dane' => '76246', 'name' => 'EL CAIRO', 'department_id' => $department->id],
                    ['code_dane' => '76248', 'name' => 'EL CERRITO', 'department_id' => $department->id],
                    ['code_dane' => '76250', 'name' => 'EL DOVIO', 'department_id' => $department->id],
                    ['code_dane' => '76275', 'name' => 'FLORIDA', 'department_id' => $department->id],
                    ['code_dane' => '76306', 'name' => 'GINEBRA', 'department_id' => $department->id],
                    ['code_dane' => '76318', 'name' => 'GUACARI', 'department_id' => $department->id],
                    ['code_dane' => '76364', 'name' => 'JAMUNDI', 'department_id' => $department->id],
                    ['code_dane' => '76377', 'name' => 'LA CUMBRE', 'department_id' => $department->id],
                    ['code_dane' => '76400', 'name' => 'LA UNION', 'department_id' => $department->id],
                    ['code_dane' => '76403', 'name' => 'LA VICTORIA', 'department_id' => $department->id],
                    ['code_dane' => '76497', 'name' => 'OBANDO', 'department_id' => $department->id],
                    ['code_dane' => '76520', 'name' => 'PALMIRA', 'department_id' => $department->id],
                    ['code_dane' => '76563', 'name' => 'PRADERA', 'department_id' => $department->id],
                    ['code_dane' => '76606', 'name' => 'RESTREPO', 'department_id' => $department->id],
                    ['code_dane' => '76616', 'name' => 'RIOFRIO', 'department_id' => $department->id],
                    ['code_dane' => '76622', 'name' => 'ROLDANILLO', 'department_id' => $department->id],
                    ['code_dane' => '76670', 'name' => 'SAN PEDRO', 'department_id' => $department->id],
                    ['code_dane' => '76736', 'name' => 'SEVILLA', 'department_id' => $department->id],
                    ['code_dane' => '76823', 'name' => 'TORO', 'department_id' => $department->id],
                    ['code_dane' => '76828', 'name' => 'TRUJILLO', 'department_id' => $department->id],
                    ['code_dane' => '76834', 'name' => 'TULUA', 'department_id' => $department->id],
                    ['code_dane' => '76845', 'name' => 'ULLOA', 'department_id' => $department->id],
                    ['code_dane' => '76863', 'name' => 'VERSALLES', 'department_id' => $department->id],
                    ['code_dane' => '76869', 'name' => 'VIJES', 'department_id' => $department->id],
                    ['code_dane' => '76890', 'name' => 'YOTOCO', 'department_id' => $department->id],
                    ['code_dane' => '76892', 'name' => 'YUMBO', 'department_id' => $department->id],
                    ['code_dane' => '76895', 'name' => 'ZARZAL', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '81') {
                $cities = [
                    ['code_dane' => '81001', 'name' => 'ARAUCA', 'department_id' => $department->id],
                    ['code_dane' => '81065', 'name' => 'ARAUQUITA', 'department_id' => $department->id],
                    ['code_dane' => '81220', 'name' => 'CRAVO NORTE', 'department_id' => $department->id],
                    ['code_dane' => '81300', 'name' => 'FORTUL', 'department_id' => $department->id],
                    ['code_dane' => '81591', 'name' => 'PUERTO RONDON', 'department_id' => $department->id],
                    ['code_dane' => '81736', 'name' => 'SARAVENA', 'department_id' => $department->id],
                    ['code_dane' => '81794', 'name' => 'TAME', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '85') {
                $cities = [
                    ['code_dane' => '85001', 'name' => 'YOPAL', 'department_id' => $department->id],
                    ['code_dane' => '85010', 'name' => 'AGUAZUL', 'department_id' => $department->id],
                    ['code_dane' => '85015', 'name' => 'CHAMEZA', 'department_id' => $department->id],
                    ['code_dane' => '85125', 'name' => 'HATO COROZAL', 'department_id' => $department->id],
                    ['code_dane' => '85136', 'name' => 'LA SALINA', 'department_id' => $department->id],
                    ['code_dane' => '85139', 'name' => 'MANI', 'department_id' => $department->id],
                    ['code_dane' => '85162', 'name' => 'MONTERREY', 'department_id' => $department->id],
                    ['code_dane' => '85225', 'name' => 'NUNCHIA', 'department_id' => $department->id],
                    ['code_dane' => '85230', 'name' => 'OROCUE', 'department_id' => $department->id],
                    ['code_dane' => '85250', 'name' => 'PAZ DE ARIPORO', 'department_id' => $department->id],
                    ['code_dane' => '85263', 'name' => 'PORE', 'department_id' => $department->id],
                    ['code_dane' => '85279', 'name' => 'RECETOR', 'department_id' => $department->id],
                    ['code_dane' => '85300', 'name' => 'SABANALARGA', 'department_id' => $department->id],
                    ['code_dane' => '85315', 'name' => 'SACAMA', 'department_id' => $department->id],
                    ['code_dane' => '85325', 'name' => 'SAN LUIS DE PALENQUE', 'department_id' => $department->id],
                    ['code_dane' => '85400', 'name' => 'TAMARA', 'department_id' => $department->id],
                    ['code_dane' => '85410', 'name' => 'TAURAMENA', 'department_id' => $department->id],
                    ['code_dane' => '85430', 'name' => 'TRINIDAD', 'department_id' => $department->id],
                    ['code_dane' => '85440', 'name' => 'VILLANUEVA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '86') {
                $cities = [
                    ['code_dane' => '86001', 'name' => 'MOCOA', 'department_id' => $department->id],
                    ['code_dane' => '86219', 'name' => 'COLON', 'department_id' => $department->id],
                    ['code_dane' => '86320', 'name' => 'ORITO', 'department_id' => $department->id],
                    ['code_dane' => '86568', 'name' => 'PUERTO ASIS', 'department_id' => $department->id],
                    ['code_dane' => '86569', 'name' => 'PUERTO CAICEDO', 'department_id' => $department->id],
                    ['code_dane' => '86571', 'name' => 'PUERTO GUZMAN', 'department_id' => $department->id],
                    ['code_dane' => '86573', 'name' => 'LEGUIZAMO', 'department_id' => $department->id],
                    ['code_dane' => '86749', 'name' => 'SIBUNDOY', 'department_id' => $department->id],
                    ['code_dane' => '86755', 'name' => 'SAN FRANCISCO', 'department_id' => $department->id],
                    ['code_dane' => '86757', 'name' => 'SAN MIGUEL', 'department_id' => $department->id],
                    ['code_dane' => '86760', 'name' => 'SANTIAGO', 'department_id' => $department->id],
                    ['code_dane' => '86865', 'name' => 'VALLE DEL GUAMUEZ', 'department_id' => $department->id],
                    ['code_dane' => '86885', 'name' => 'VILLAGARZON', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '88') {
                $cities = [
                    ['code_dane' => '88001', 'name' => 'SAN ANDRES', 'department_id' => $department->id],
                    ['code_dane' => '88564', 'name' => 'PROVIDENCIA', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '91') {
                $cities = [
                    ['code_dane' => '1001', 'name' => 'LETICIA', 'department_id' => $department->id],
                    ['code_dane' => '91263', 'name' => 'EL ENCANTO (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91405', 'name' => 'LA CHORRERA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91407', 'name' => 'LA PEDRERA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91430', 'name' => 'LA VICTORIA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91460', 'name' => 'MIRITI - PARANA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91530', 'name' => 'PUERTO ALEGRIA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91536', 'name' => 'PUERTO ARICA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91540', 'name' => 'PUERTO NARIÑO', 'department_id' => $department->id],
                    ['code_dane' => '91669', 'name' => 'PUERTO SANTANDER (CD)', 'department_id' => $department->id],
                    ['code_dane' => '91798', 'name' => 'TARAPACA (CD)', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '94') {
                $cities = [
                    ['code_dane' => '94001', 'name' => 'INIRIDA', 'department_id' => $department->id],
                    ['code_dane' => '94343', 'name' => 'BARRANCO MINAS (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94663', 'name' => 'MAPIRIPANA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94883', 'name' => 'SAN FELIPE (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94884', 'name' => 'PUERTO COLOMBIA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94885', 'name' => 'LA GUADALUPE (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94886', 'name' => 'CACAHUAL (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94887', 'name' => 'PANA PANA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '94888', 'name' => 'MORICHAL (CD)', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '95') {
                $cities = [
                    ['code_dane' => '95001', 'name' => 'SAN JOSE DEL GUAVIARE', 'department_id' => $department->id],
                    ['code_dane' => '95015', 'name' => 'CALAMAR', 'department_id' => $department->id],
                    ['code_dane' => '95025', 'name' => 'EL RETORNO', 'department_id' => $department->id],
                    ['code_dane' => '95200', 'name' => 'MIRAFLORES', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '97') {
                $cities = [
                    ['code_dane' => '97001', 'name' => 'MITU', 'department_id' => $department->id],
                    ['code_dane' => '97161', 'name' => 'CARURU', 'department_id' => $department->id],
                    ['code_dane' => '97511', 'name' => 'PACOA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '97666', 'name' => 'TARAIRA', 'department_id' => $department->id],
                    ['code_dane' => '97777', 'name' => 'PAPUNAUA (CD)', 'department_id' => $department->id],
                    ['code_dane' => '97889', 'name' => 'YAVARATE (CD)', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
            if ($department->code_dane == '99') {
                $cities = [
                    ['code_dane' => '99001', 'name' => 'PUERTO CARREÑO', 'department_id' => $department->id],
                    ['code_dane' => '99524', 'name' => 'LA PRIMAVERA', 'department_id' => $department->id],
                    ['code_dane' => '99624', 'name' => 'SANTA ROSALIA', 'department_id' => $department->id],
                    ['code_dane' => '99773', 'name' => 'CUMARIBO', 'department_id' => $department->id],
                ];


                foreach ($cities as $cityData) {
                    City::create($cityData);
                }
            }
        }
    }
}
