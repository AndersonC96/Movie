# 🎬 Movies Database

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![TMDb](https://img.shields.io/badge/TMDb-API-01D277?style=for-the-badge&logo=themoviedatabase&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Uma aplicação web moderna para explorar informações sobre filmes e séries, utilizando a API do The Movie Database (TMDb).

---

## 📸 Screenshots

| Home | Busca | Detalhes |
|:---:|:---:|:---:|
| ![Home](screenshots/home.png) | ![Browse](screenshots/browse.png) | ![Details](screenshots/details.png) |

---

## ✨ Funcionalidades

- 🔍 **Busca avançada** de filmes por título
- 🎬 **Detalhes completos** - elenco, sinopse, avaliações, duração
- 📊 **Top Rated** - carrossel com os filmes mais bem avaliados
- 📺 **Séries** - explore também séries de TV
- 👤 **Sistema de autenticação** - login, registro e logout
- 🛡️ **Painel Admin** - gerenciamento de usuários e solicitações
- 📱 **Design responsivo** - funciona em qualquer dispositivo
- 🌙 **Dark theme** - design moderno com glassmorphism

---

## 🏗️ Arquitetura

```
Movie/
├── config/                 # Configurações (banco, API, app)
├── public/                 # Entry points e assets públicos
│   ├── css/               # Estilos
│   ├── js/                # JavaScript
│   ├── images/            # Imagens
│   ├── index.php          # Entry point principal
│   ├── api.php            # Proxy para API TMDb
│   └── auth.php           # Handler de autenticação
├── src/
│   ├── App/
│   │   ├── Controllers/   # Controllers da aplicação
│   │   ├── Models/        # Models com PDO
│   │   └── Views/         # Templates PHP
│   │       ├── partials/  # Header, navbar, footer, modals
│   │       ├── guest/     # Views para visitantes
│   │       ├── user/      # Views para usuários
│   │       └── admin/     # Views para administradores
│   └── Core/              # Classes base
│       ├── Controller.php # Controller base
│       ├── Database.php   # Conexão PDO Singleton
│       └── Router.php     # Roteador simples
├── autoload.php           # Autoloader PSR-4
└── database.sql           # Schema do banco de dados
```

---

## 🛡️ Segurança

- ✅ **Prepared Statements** - proteção contra SQL Injection
- ✅ **Password Hashing** - bcrypt com cost 12
- ✅ **API Key protegida** - proxy no backend
- ✅ **Input Sanitization** - htmlspecialchars em todas entradas
- ✅ **Session Security** - gerenciamento seguro de sessões

---

## 🚀 Instalação

### Pré-requisitos

- PHP 8.0+
- MySQL/MariaDB
- Apache com mod_rewrite (XAMPP, WAMP, Laragon)

### Passos

1. **Clone o repositório**
   ```bash
   git clone https://github.com/AndersonC96/Movie.git
   cd Movie
   ```

2. **Configure o banco de dados**
   ```bash
   # Importe o schema
   mysql -u root -p < database.sql
   ```

3. **Configure as credenciais**
   
   Edite `config/database.php`:
   ```php
   return [
       'host'     => 'localhost',
       'database' => 'moviesinfo',
       'username' => 'root',
       'password' => '',
       // ...
   ];
   ```

4. **Configure a API Key do TMDb**
   
   Edite `config/api.php`:
   ```php
   return [
       'tmdb' => [
           'api_key' => 'SUA_API_KEY_AQUI',
           // ...
       ]
   ];
   ```
   
   > Obtenha sua API key em: https://www.themoviedb.org/settings/api

5. **Acesse a aplicação**
   ```
   http://localhost/Movie/public/
   ```

---

## 📁 Estrutura de Arquivos

| Diretório/Arquivo | Descrição |
|-------------------|-----------|
| `config/` | Arquivos de configuração (database, API, app) |
| `public/` | Arquivos públicos acessíveis diretamente |
| `src/App/Controllers/` | Controllers seguindo PSR-4 |
| `src/App/Models/` | Models com PDO e prepared statements |
| `src/App/Views/` | Templates PHP com partials |
| `src/Core/` | Classes base (Database, Controller, Router) |
| `autoload.php` | Autoloader PSR-4 customizado |

---

## 🛠️ Tecnologias

### Backend
- **PHP 8.0+** - Linguagem de programação
- **PDO** - Acesso ao banco com prepared statements
- **PSR-4** - Autoloading de classes

### Frontend
- **Bootstrap 5.3** - Framework CSS
- **Font Awesome 6** - Ícones
- **Inter Font** - Tipografia moderna
- **Vanilla JS** - JavaScript moderno (ES6+)

### API
- **TMDb API** - Dados de filmes e séries

---

## 👤 Credenciais de Teste

| Tipo | Usuário | Senha |
|------|---------|-------|
| Admin | admin | admin |
| Usuário | user | 123456 |

> ⚠️ **Importante:** Altere essas credenciais em produção!

---

## 📈 Roadmap

- [ ] Implementar sistema de favoritos
- [ ] Adicionar comparação de filmes
- [ ] Implementar PWA
- [ ] Adicionar testes unitários
- [ ] Implementar cache de requisições
- [ ] Dark/Light mode toggle

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

1. Faça um Fork do projeto
2. Crie sua Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

## 👨‍💻 Autor

**Anderson Cavalcante**

[![GitHub](https://img.shields.io/badge/GitHub-AndersonC96-181717?style=flat-square&logo=github)](https://github.com/AndersonC96)

---

<p align="center">
  Desenvolvido com ❤️ e ☕
</p>
