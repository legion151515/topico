<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivoConsultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motivos = [
            // Síntomas comunes
            ['nombre' => 'Dolor de cabeza', 'descripcion' => 'Cefalea común o migraña'],
            ['nombre' => 'Fiebre', 'descripcion' => 'Temperatura corporal elevada (>37.5°C)'],
            ['nombre' => 'Gripe / Resfriado', 'descripcion' => 'Síntomas gripales o resfriado común'],
            ['nombre' => 'Tos', 'descripcion' => 'Tos seca o con flema'],
            ['nombre' => 'Dolor de garganta', 'descripcion' => 'Faringitis o amigdalitis'],
            ['nombre' => 'Congestión nasal', 'descripcion' => 'Nariz tapada o secreción nasal'],

            // Problemas gastrointestinales
            ['nombre' => 'Dolor abdominal', 'descripcion' => 'Dolor o malestar en el abdomen'],
            ['nombre' => 'Náuseas / Vómitos', 'descripcion' => 'Náuseas con o sin vómitos'],
            ['nombre' => 'Diarrea', 'descripcion' => 'Evacuaciones líquidas frecuentes'],
            ['nombre' => 'Estreñimiento', 'descripcion' => 'Dificultad para evacuar'],
            ['nombre' => 'Gastritis', 'descripcion' => 'Inflamación de la mucosa gástrica'],

            // Lesiones y traumatismos
            ['nombre' => 'Herida / Corte', 'descripcion' => 'Herida superficial o corte'],
            ['nombre' => 'Golpe / Contusión', 'descripcion' => 'Traumatismo por golpe o caída'],
            ['nombre' => 'Esguince', 'descripcion' => 'Lesión de ligamentos articulares'],
            ['nombre' => 'Quemadura leve', 'descripcion' => 'Quemadura de primer o segundo grado'],
            ['nombre' => 'Raspadura / Abrasión', 'descripcion' => 'Lesión superficial de la piel'],

            // Problemas dermatológicos
            ['nombre' => 'Alergia cutánea', 'descripcion' => 'Erupción o urticaria alérgica'],
            ['nombre' => 'Picadura de insecto', 'descripcion' => 'Picadura de mosquito, araña, etc.'],
            ['nombre' => 'Sarpullido', 'descripcion' => 'Erupción cutánea'],
            ['nombre' => 'Eccema / Dermatitis', 'descripcion' => 'Inflamación de la piel'],

            // Problemas oculares y auditivos
            ['nombre' => 'Conjuntivitis', 'descripcion' => 'Inflamación de la conjuntiva ocular'],
            ['nombre' => 'Orzuelo', 'descripcion' => 'Infección del párpado'],
            ['nombre' => 'Dolor de oídos', 'descripcion' => 'Otalgia u otitis'],
            ['nombre' => 'Irritación ocular', 'descripcion' => 'Ojos rojos o irritados'],

            // Dolores musculoesqueléticos
            ['nombre' => 'Dolor muscular', 'descripcion' => 'Mialgia o dolor muscular'],
            ['nombre' => 'Dolor de espalda', 'descripcion' => 'Lumbalgia o dorsalgia'],
            ['nombre' => 'Dolor de cuello', 'descripcion' => 'Cervicalgia'],
            ['nombre' => 'Dolor articular', 'descripcion' => 'Artralgia en articulaciones'],

            // Problemas menstruales (común en estudiantes)
            ['nombre' => 'Cólicos menstruales', 'descripcion' => 'Dismenorrea o dolor menstrual'],
            ['nombre' => 'Sangrado menstrual abundante', 'descripcion' => 'Menorragia'],

            // Problemas respiratorios
            ['nombre' => 'Dificultad respiratoria', 'descripcion' => 'Disnea o falta de aire'],
            ['nombre' => 'Crisis asmática', 'descripcion' => 'Exacerbación de asma'],

            // Síntomas generales
            ['nombre' => 'Mareos / Vértigo', 'descripcion' => 'Sensación de mareo o inestabilidad'],
            ['nombre' => 'Malestar general', 'descripcion' => 'Astenia o malestar inespecífico'],
            ['nombre' => 'Fatiga / Cansancio', 'descripcion' => 'Sensación de agotamiento'],

            // Problemas psicológicos/emocionales
            ['nombre' => 'Ansiedad / Estrés', 'descripcion' => 'Crisis de ansiedad o estrés académico'],
            ['nombre' => 'Crisis de pánico', 'descripcion' => 'Ataque de pánico agudo'],
            ['nombre' => 'Insomnio', 'descripcion' => 'Dificultad para dormir'],

            // Emergencias menores
            ['nombre' => 'Presión arterial baja', 'descripcion' => 'Hipotensión arterial'],
            ['nombre' => 'Presión arterial alta', 'descripcion' => 'Hipertensión arterial'],
            ['nombre' => 'Desmayo / Lipotimia', 'descripcion' => 'Pérdida breve de consciencia'],
            ['nombre' => 'Hemorragia nasal', 'descripcion' => 'Epistaxis o sangrado nasal'],

            // Otros
            ['nombre' => 'Control de presión', 'descripcion' => 'Control de signos vitales'],
            ['nombre' => 'Revisión general', 'descripcion' => 'Chequeo médico general'],
            ['nombre' => 'Vacunación', 'descripcion' => 'Administración de vacunas'],
            ['nombre' => 'Certificado médico', 'descripcion' => 'Solicitud de certificado médico'],
            ['nombre' => 'Otro', 'descripcion' => 'Otro motivo no especificado'],
        ];

        foreach ($motivos as $motivo) {
            \App\Models\MotivoConsulta::create($motivo);
        }
    }
}
