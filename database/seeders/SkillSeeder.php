<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder{
    public function run(): void
    {
        $skills = [
            // Soft Skills
            'Communication',
            'Leadership',
            'Travail d’équipe',
            'Gestion du temps',
            'Créativité',
            'Résolution de problèmes',
            'Adaptabilité',
            'Esprit critique',
            'Empathie',
            'Négociation',
            'Prise de décision',
            'Gestion du stress',
            'Intelligence émotionnelle',
            'Capacité d’apprentissage',
            'Éthique professionnelle',
        
            // Informatique & Développement
            'PHP',
            'Laravel',
            'JavaScript',
            'React.js',
            'Node.js',
            'Python',
            'Django',
            'Machine Learning',
            'Cybersécurité',
            'Cloud Computing',
            'DevOps',
            'Big Data',
            'Blockchain',
            'SQL',
            'NoSQL',
            'Docker',
            'Git',
        
            // Marketing & Communication
            'SEO',
            'Google Ads',
            'Copywriting',
            'Community Management',
            'Publicité digitale',
            'Stratégie de marque',
            'Relations publiques',
            'Content Marketing',
            'Growth Hacking',
        
            // Design & Créativité
            'Adobe Photoshop',
            'Adobe Illustrator',
            'UI/UX Design',
            'Figma',
            'Motion Design',
            'Montage vidéo',
            'Photographie',
            'Storytelling',
        
            // Finance & Gestion
            'Analyse financière',
            'Gestion de budget',
            'Comptabilité',
            'Investissement',
            'Cryptomonnaies',
            'Gestion de projet',
            'Lean Management',
            'Scrum',
            'Six Sigma',
        
            // Sciences & Ingénierie
            'Mathématiques appliquées',
            'Physique quantique',
            'Chimie organique',
            'Robotique',
            'Énergie renouvelable',
            'Génie civil',
            'Automatisation industrielle',
            'Impression 3D',
        
            // Santé & Bien-être
            'Médecine du travail',
        
            // Langues & Culture
            'Anglais',
            'Espagnol',
            'Allemand',
            'Mandarin',
            'Langue des signes',
        ];
        
        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }

    }
}

// Seeder 7