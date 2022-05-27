<img src="public/assets/images/CONTROLES.png" width="100%">

***
Desenvolvido em Laravel 9!

O sistema **Controles** foi desenvolvido para tornar a vida do profissional de TI mais fácil.

Todas as informações necessárias para o departamento são armazenadas aqui, trazendo confiança e agilidade na tomada de decisão.

***
### Funções/Módulos
***
#### 1 - Usuários
- Cada usuário do sistema possuí:
  - Nível de acesso;
  - Responsabilidade por cada ambiente/bloco;
  - Alerta de vencimento de revisões preventivas;
  - Alerta de vencimento de licença de Software;
  - Registro completo das informações pessoais para consulta do gestor do departamento;

#### 2 - Ambientes
- Os ambientes possuem inventário completo de Hardware, Software e mais.

#### 3 - Manutenção Preventiva
- Todos os ambientes têm a possibilidade de definir uma frequência de manutenção preventiva *(recorrente e por nível de complexidade)* .
- As atividades que devem ser realizadas são separadas por nível, cada nível com uma recorrência própria;

#### 4 - Software
- Gerenciamento de Licenças;
- Inventário de software instalado:
   - No sistema operacional criado (imagem);
   - No ambiente;

#### 5 - Hardware
- Inventário de:
  - Computadores
   - Informação geral
   - Tipo de Equipamento, RAM, Disco Rígido, Processador, GPU...
  - Projetores:
   - Infraestrutura de ambiente = HDMI/VGA;
   - Ficha de dados;
   - Informação geral;
  - Impressoras;
   - Informações da rede;
   - Informações do contrato de locação;
  - Relógio Ponto;
  - Catracas;

#### 6 - Segurança
  - Um login ativo por usuário. Ao efetuar o login em outro dispositivo, a seção anterior será desconectada.
  - 2FA - o usuário recebe um código do 6 digitos em seu e-mail para finalizar o login.
    * Para habilitar essa função, é necessário realizar as alterações no arquivo .env
  - Bloqueio automático por inatividade, essa configuração fica disponível no perfil do usuário;
  - Solicitação de senha do usuário logado para visualizar detalhes da licença de software;

#### 7 - Outros Módulos
   - Dashboard;
      - Todas as informações em um só lugar;
   - Fornecedores;
      - Informações de seus fornecedores de software, hardware e etc;
   - Notas Pessoais;
      - Um lugar pessoal para criar suas notas ou lembretes;
   - Bug Reports;
      - Uma ferramenta para facilitar a resolução de problemas;
   - Prorrogar data de vencimento;
      - Se necessário, o Administrador pode alterar a data de vencimento das atividades sem prejudicar os indicadores;
   - Registro do sistema;
      - Todas as alterações de data de vencimento são registradas no log. *(Outras informações serão adicionadas no futuro)*;
   - Imagens do sistema operacional criadas;
      - Um inventário de imagens criadas a partir de um sistema operacional específico, com lista de software e controle de versão de imagem
   - Grupos e Funções;
      - Permissões de acesso do usuário aos módulos do sistema;

***
### Configurando
***
#### Configuração do servidor Web
1. Instale o Apache
    `$ sudo apt update`   
    `$ sudo apt install apache2`

2. Instale o MySQL Server   
    `$ sudo apt install mysql-server`

3. Instale o PHP     
    `$ sudo apt install php7.0 libapache2-mod-php7.0 php-mysql7.0`

#### Configuração do projeto/banco de dados
1. Execute `git clone https://github.com/gelbcke/controles.git`
2. Crie um banco de dados MySQL para o projeto
    * ```mysql -u root -p```   
    * ```create database controles;```

3. Crie o usuário e dê as permissões necessárias
    * ```CREATE USER 'controles'@'localhost' IDENTIFIED BY 'sua_senha_aqui';```
    * ```GRANT ALL PRIVILEGES ON controles.* TO 'controles'@'localhost';```  
    * ```quit;```

#### Configuração final
1. Vá para o projeto da pasta
   * `cd /var/www/html/controles`
2. Da pasta raiz do projeto, execute
   * `sudo cp .env.example .env`
3. Configure seu arquivo `.env`
4. Da pasta raiz do projeto, execute
   * `composer install`
   * `php artisan key:generate`
   * `php artisan migrate`
   * `php artisan db:seed`
   * `php artisan optimize`  
   * `composer dump-autoload`

#### Defina as permissões de pastas e arquivos
   * ```sudo chmod -R 777 ./```   
   * ```sudo chown -R www-data:www-data ./```   
   * ```sudo find ./ -type f -exec chmod 644 {} \;```   
   * ```sudo find ./ -type d -exec chmod 755 {} \;```
   * ```sudo chgrp -R www-data storage bootstrap/cache```
   * ```sudo chmod -R ug+rwx storage bootstrap/cache```   
   * ```sudo chmod -R 777 ./bootstrap/cache/```

***
### Informações importantes
***
#### Credenciais do SEED
>- Usuário: admin@controles.com
>- Senha: secret

#### Exemplo do arquivo `.env`:
```
APP_NAME=Controles
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

2FACTOR_AUTH=false

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controles
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

#### CRON Tasks
```
* * * * * php /var/www/html/controles/artisan schedule:run
```

***
##### FrontEnd by [Colorlib - Octopus](https://github.com/icdcom/octopus)
