# DevBlog

---

## 🛠️ Pré-requisitos

Antes de começar, instale as seguintes ferramentas:

1. **Git**

    - Windows: baixe e instale em [https://git-scm.com/download/win](https://git-scm.com/download/win)
    - macOS: use o Homebrew (`brew install git`) ou baixe [https://git-scm.com/download/mac](https://git-scm.com/download/mac)
    - Linux: use o gerenciador de pacotes da sua distro (ex: `sudo apt install git`).

2. **PHP 8.2 ou superior**

    - Windows: recomendo o [Laragon](https://laragon.org/) ou [XAMPP](https://www.apachefriends.org/).
    - macOS/Linux: use Homebrew (`brew install php`) ou `sudo apt install php php-mbstring php-xml php-bcmath php-pdo php-mysql`.

3. **Composer 2+**

    - Baixe o instalador em [https://getcomposer.org/Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) (Windows).
    - macOS/Linux: siga [https://getcomposer.org/download/](https://getcomposer.org/download/) (`php -r "..."`).

4. **MySQL 8.0 ou superior**

    - Windows: pelo Laragon/XAMPP ou instalador oficial ([https://dev.mysql.com/downloads/](https://dev.mysql.com/downloads/)).
    - macOS: `brew install mysql`
    - Linux: `sudo apt install mysql-server`

5. **Node.js 14+ e npm**

    - Baixe em [https://nodejs.org/](https://nodejs.org/) ou use `brew install node` / `sudo apt install nodejs npm`.

## 🚀 Passo a Passo de Instalação

Abra o terminal (ou Prompt de Comando/PowerShell no Windows) e siga estes passos:

1. **Clone este repositório**

    ```bash
    git clone https://seu-repositorio.git DevBlog
    cd DevBlog
    ```

2. **Instale dependências PHP**

    ```bash
    composer install
    ```

3. **Copie o arquivo de ambiente**

    ```bash
    cp .env.example .env    # Linux/macOS
    copy .env.example .env  # Windows PowerShell
    ```

4. **Configure o banco de dados**

    - Abra o arquivo `.env` e ajuste as variáveis:
        ```dotenv
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=devblog
        DB_USERNAME=seu_usuario
        DB_PASSWORD=sua_senha
        ```
    - **Crie** o banco `devblog` no MySQL:
        ```bash
        mysql -u root -p -e "CREATE DATABASE devblog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        ```

5. **Gere a chave de aplicação**

    ```bash
    php artisan key:generate
    ```

6. **Crie o link de storage**

    ```bash
    php artisan storage:link
    ```

7. **Execute as migrations e seeders**

    ```bash
    php artisan migrate --seed
    ```

    Isso cria as tabelas e popula com dados de exemplo (artigos, desenvolvedores e imagens).

> 🔑 **Nota:** Um usuário administrador também é criado automaticamente:
>
> -   E-mail: `admin@email.com`
> -   Senha: `123456`
>
> Com ele é possível controlar os desenvolvedores

8. **Instale dependências JavaScript**

    ```bash
    npm install
    npm run dev
    ```

9. **Inicie o servidor de desenvolvimento**

    ```bash
    php artisan serve
    ```

10. **Acesse no navegador**

    ```
    http://localhost:8000
    ```

Pronto! 🎉 O DevBlog deverá estar funcionando com artigos, desenvolvedores, upload de imagens e alertas SweetAlert configurados.

---

Qualquer dúvida, abra uma issue ou entre em contato.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
