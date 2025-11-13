<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que el rol "Escritor" existe
        $escritorRole = Role::where('name', 'Escritor')->first();
        if (!$escritorRole) {
            $this->command->error('El rol "Escritor" no existe. Por favor, créalo primero.');
            return;
        }

        // Obtener usuarios con rol "Escritor" o "super_admin"
        $escritores = User::role(['Escritor', 'super_admin'])->get();
        
        // Si no hay escritores, asignar el rol a algunos usuarios existentes
        if ($escritores->isEmpty()) {
            $this->command->warn('No hay usuarios con rol "Escritor". Asignando el rol a usuarios existentes...');
            
            $usuariosDisponibles = User::doesntHave('roles', 'or', function($query) {
                $query->whereIn('name', ['super_admin', 'Escritor']);
            })->take(2)->get();

            if ($usuariosDisponibles->isEmpty()) {
                // Crear usuarios escritores si no hay usuarios disponibles
                $this->command->info('Creando usuarios escritores de ejemplo...');
                
                $escritor1 = User::create([
                    'name' => 'María Escritora',
                    'email' => 'maria.escritora@example.com',
                    'password' => bcrypt('Password123!'),
                    'email_verified_at' => now(),
                ]);
                $escritor1->assignRole('Escritor');
                
                $escritor2 = User::create([
                    'name' => 'Carlos Redactor',
                    'email' => 'carlos.redactor@example.com', 
                    'password' => bcrypt('Password123!'),
                    'email_verified_at' => now(),
                ]);
                $escritor2->assignRole('Escritor');
                
                $escritores = collect([$escritor1, $escritor2]);
                $this->command->info('Se han creado 2 usuarios escritores.');
                
            } else {
                // Asignar rol Escritor a usuarios existentes
                foreach ($usuariosDisponibles as $usuario) {
                    $usuario->assignRole('Escritor');
                    $this->command->info("Rol 'Escritor' asignado a: {$usuario->name}");
                }
                $escritores = $usuariosDisponibles;
            }
        } else {
            $this->command->info("Encontrados {$escritores->count()} usuarios con rol Escritor o super_admin.");
        
        // Limpiar publicaciones existentes para evitar duplicados
        Post::truncate();
        $this->command->info('Publicaciones existentes eliminadas.');
        }

        $publicaciones = [
            [
                'title' => 'Bienvenido a nuestra plataforma',
                'excerpt' => 'Esta es nuestra primera publicación donde te damos la bienvenida a nuestra plataforma.',
                'content' => '<p>¡Hola y bienvenidos a nuestro blog! Estamos emocionados de compartir con ustedes contenido de calidad sobre diversos temas de interés.</p><p>En este espacio encontrarás artículos sobre tecnología, desarrollo web, tendencias digitales y mucho más.</p><p>¡Esperamos que disfrutes leyendo nuestro contenido tanto como nosotros disfrutamos creándolo!</p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Guía básica de Laravel para principiantes',
                'excerpt' => 'Aprende los conceptos fundamentales de Laravel con esta guía completa.',
                'content' => '<p>Laravel es uno de los frameworks de PHP más populares del mundo. En esta guía aprenderás:</p><ul><li>Instalación y configuración</li><li>Rutas y controladores</li><li>Modelos y migraciones</li><li>Vistas con Blade</li></ul><p>¡Perfecto para comenzar tu viaje en Laravel!</p>',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Las mejores prácticas de seguridad web',
                'excerpt' => 'Conoce las técnicas esenciales para proteger tu aplicación web.',
                'content' => '<p>La seguridad web es fundamental en cualquier aplicación. Algunas prácticas importantes incluyen:</p><ul><li>Validación de entrada de datos</li><li>Autenticación y autorización robustas</li><li>Protección CSRF</li><li>Encriptación de datos sensibles</li></ul><p>Implementar estas prácticas desde el inicio te ahorrará muchos dolores de cabeza.</p>',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Próximos features de nuestra plataforma',
                'excerpt' => 'Un vistazo a las nuevas funcionalidades que estamos desarrollando.',
                'content' => '<p>Estamos trabajando en emocionantes nuevas características para mejorar tu experiencia:</p><ul><li>Dashboard personalizable</li><li>Notificaciones en tiempo real</li><li>API REST completa</li><li>Integración con redes sociales</li></ul><p>¡Mantente atento a las actualizaciones!</p>',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
            [
                'title' => 'Historia de la programación web',
                'excerpt' => 'Un recorrido por la evolución de las tecnologías web.',
                'content' => '<p>La programación web ha evolucionado tremendamente desde los primeros sitios estáticos. Hemos visto el surgimiento de:</p><ul><li>HTML y CSS básicos</li><li>JavaScript dinámico</li><li>Frameworks modernos</li><li>Aplicaciones de página única (SPA)</li></ul><p>Cada era ha traído nuevas posibilidades y desafíos únicos.</p>',
                'status' => 'archived',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($publicaciones as $postData) {
            Post::create([
                'title' => $postData['title'],
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'status' => $postData['status'],
                'is_featured' => $postData['is_featured'],
                'user_id' => $escritores->random()->id, // Asigna a un escritor aleatorio
                'published_at' => $postData['published_at'],
            ]);
        }

        $this->command->info('Se han creado ' . count($publicaciones) . ' publicaciones de ejemplo por usuarios con rol Escritor.');
    }
}
