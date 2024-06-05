<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Création des catégories
        $categories = [
            ['nom' => 'informatique', 'description' => 'Découvrez et explorez le monde de l’informatique, de la programmation aux dernières innovations technologiques. Partagez vos connaissances, posez des questions et collaborez sur des projets informatiques'],
            // ['nom' => 'chimie', 'description' => 'Échangez sur les mystères de la chimie, des réactions élémentaires aux avancées en chimie organique et inorganique. Posez vos questions, partagez des expériences de laboratoire et apprenez ensemble'],
            // ['nom' => 'physique', 'description' => 'Explorez les lois de la physique, de la mécanique quantique à la relativité. Discutez de théories, réalisez des expériences virtuelles et aidez-vous mutuellement à comprendre les phénomènes physiques.'],
            // ['nom' => 'math', 'description' => 'Plongez dans l’univers des réseaux informatiques. Discutez de la configuration, de la sécurité, des protocoles et de la maintenance des réseaux. Échangez des conseils et résolvez des problèmes ensemble.'],
            ['nom' => 'reseaux', 'description' => 'Plongez dans l’univers des réseaux informatiques. Discutez de la configuration, de la sécurité, des protocoles et de la maintenance des réseaux. Échangez des conseils et résolvez des problèmes ensemble.'],
        ];

        // Parcourir les catégories et les enregistrer dans la base de données
        foreach ($categories as $categorieData) {
            Category::create($categorieData);
        }
    }
}
