<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RevisaoAmbienteAtividade;
use App\Models\RevisaoAmbienteNivel;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Visualizar Usuários']);
        Permission::create(['name' => 'Editar Usuários']);
        Permission::create(['name' => 'Remover Usuários']);
        Permission::create(['name' => 'Criar Usuários']);

        Permission::create(['name' => 'Visualizar Permissões']);
        Permission::create(['name' => 'Editar Permissões']);
        Permission::create(['name' => 'Remover Permissões']);
        Permission::create(['name' => 'Criar Permissões']);

        Permission::create(['name' => 'Visualizar Grupos']);
        Permission::create(['name' => 'Editar Grupos']);
        Permission::create(['name' => 'Remover Grupos']);
        Permission::create(['name' => 'Criar Grupos']);

        Permission::create(['name' => 'Visualizar Ambientes']);
        Permission::create(['name' => 'Editar Ambientes']);
        Permission::create(['name' => 'Remover Ambientes']);
        Permission::create(['name' => 'Criar Ambientes']);

        Permission::create(['name' => 'Visualizar Impressoras']);
        Permission::create(['name' => 'Editar Impressoras']);
        Permission::create(['name' => 'Remover Impressoras']);
        Permission::create(['name' => 'Criar Impressoras']);

        Permission::create(['name' => 'Visualizar Softwares']);
        Permission::create(['name' => 'Editar Softwares']);
        Permission::create(['name' => 'Remover Softwares']);
        Permission::create(['name' => 'Criar Softwares']);

        Permission::create(['name' => 'Visualizar Imagens']);
        Permission::create(['name' => 'Editar Imagens']);
        Permission::create(['name' => 'Remover Imagens']);
        Permission::create(['name' => 'Criar Imagens']);

        Permission::create(['name' => 'Visualizar Lista de Softwares']);
        Permission::create(['name' => 'Editar Lista de Softwares']);
        Permission::create(['name' => 'Remover Lista de Softwares']);
        Permission::create(['name' => 'Criar Lista de Softwares']);

        Permission::create(['name' => 'Visualizar Revisão']);
        Permission::create(['name' => 'Editar Revisão']);
        Permission::create(['name' => 'Remover Revisão']);
        Permission::create(['name' => 'Criar Revisão']);

        Permission::create(['name' => 'Visualizar Lista de Atividades']);
        Permission::create(['name' => 'Editar Lista de Atividades']);
        Permission::create(['name' => 'Remover Lista de Atividades']);
        Permission::create(['name' => 'Criar Lista de Atividades']);

        Permission::create(['name' => 'Visualizar Vencimentos']);

        Permission::create(['name' => 'Visualizar BugReport']);
        Permission::create(['name' => 'Editar BugReport']);
        Permission::create(['name' => 'Remover BugReport']);
        Permission::create(['name' => 'Criar BugReport']);

        Permission::create(['name' => 'Visualizar Projetores']);
        Permission::create(['name' => 'Editar Projetores']);
        Permission::create(['name' => 'Remover Projetores']);
        Permission::create(['name' => 'Criar Projetores']);

        Permission::create(['name' => 'Editar Vencimentos']);

        // Cria grupo de Permissão para Licençaes
        Permission::create(['name' => 'Visualizar Licença']);
        Permission::create(['name' => 'Visualizar Detalhes da Licença']);
        Permission::create(['name' => 'Editar Licença']);
        Permission::create(['name' => 'Remover Licença']);
        Permission::create(['name' => 'Criar Licença']);

        Permission::create(['name' => 'Visualizar Fornecedores']);
        Permission::create(['name' => 'Editar Fornecedores']);
        Permission::create(['name' => 'Remover Fornecedores']);
        Permission::create(['name' => 'Criar Fornecedores']);

        Permission::create(['name' => 'Visualizar Unidades']);
        Permission::create(['name' => 'Editar Unidades']);
        Permission::create(['name' => 'Remover Unidades']);
        Permission::create(['name' => 'Criar Unidades']);

        Permission::create(['name' => 'Visualizar Blocos']);
        Permission::create(['name' => 'Editar Blocos']);
        Permission::create(['name' => 'Remover Blocos']);
        Permission::create(['name' => 'Criar Blocos']);

        Permission::create(['name' => 'Visualizar Log']);

        Permission::create(['name' => 'Visualizar Termos de Responsabilidade']);
        Permission::create(['name' => 'Editar Termos de Responsabilidade']);
        Permission::create(['name' => 'Remover Termos de Responsabilidade']);
        Permission::create(['name' => 'Criar Termos de Responsabilidade']);

        Permission::create(['name' => 'Visualizar Relógios Ponto']);
        Permission::create(['name' => 'Editar Relógios Ponto']);
        Permission::create(['name' => 'Remover Relógios Ponto']);
        Permission::create(['name' => 'Criar Relógios Ponto']);

        Permission::create(['name' => 'Visualizar Notas Importantes']);
        Permission::create(['name' => 'Remover Notas Importantes']);
        Permission::create(['name' => 'Criar Notas Importantes']);

        Permission::create(['name' => 'Editar Hardware']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador'])
        ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Supervisor'])
        ->givePermissionTo(['Visualizar Usuários', 'Editar Usuários', 'Visualizar Projetores', 'Editar Projetores', 'Criar Projetores', 'Visualizar Licença', 'Editar Licença', 'Criar Licença', 'Remover Licença', 'Visualizar Fornecedores', 'Editar Fornecedores', 'Criar Fornecedores', 'Visualizar Blocos', 'Editar Blocos','Visualizar Unidades', 'Editar Unidades', 'Visualizar Termos de Responsabilidade', 'Editar Termos de Responsabilidade', 'Criar Termos de Responsabilidade', 'Visualizar Relógios Ponto', 'Editar Relógios Ponto', 'Criar Relógios Ponto', 'Visualizar Log', 'Visualizar Detalhes da Licença', 'Remover Notas Importantes', 'Criar Notas Importantes', 'Visualizar Notas Importantes']);

        $role = Role::create(['name' => 'Analista'])
            ->givePermissionTo(['Visualizar Usuários', 'Visualizar Projetores', 'Editar Projetores', 'Criar Projetores', 'Visualizar Licença', 'Visualizar Fornecedores', 'Editar Fornecedores', 'Criar Fornecedores', 'Visualizar Blocos', 'Visualizar Unidades', 'Visualizar Termos de Responsabilidade', 'Editar Termos de Responsabilidade', 'Criar Termos de Responsabilidade', 'Visualizar Detalhes da Licença', 'Visualizar Notas Importantes']);

        $role = Role::create(['name' => 'Usuário'])
            ->givePermissionTo(['Visualizar Lista de Softwares']);

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@controles.com',
            'password' => bcrypt('secret'),
            'status' => '1',
            'matricula' => '123456',
        ]);

        DB::table('model_has_roles')
        ->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1
        ]);

        RevisaoAmbienteAtividade::create([
            'nivel' => 'Nível 1',
        ]);

        RevisaoAmbienteAtividade::create([
            'nivel' => 'Nível 2',
        ]);

        RevisaoAmbienteAtividade::create([
            'nivel' => 'Nível 3',
        ]);

    }
}
