# TechFix — Sistema de Agendamento de Assistência Técnica

Projeto acadêmico: sistema web simples para agendamento de serviços de
assistência técnica de hardware e software. Arquitetura monolítica em
Laravel + Blade + Tailwind CSS + SQLite.

## 1. Objetivo

- Cliente: cria conta, visualiza serviços, escolhe data/horário disponível,
  confirma o agendamento e acompanha o status (Pendente → Agendado → Concluído).
- Administrador: cadastra/edita/desativa serviços, gerencia horários
  disponíveis, visualiza agendamentos e altera o status de cada um.

## 2. Tecnologias

- PHP + Laravel (framework)
- Blade (views)
- Tailwind CSS v4 (via plugin oficial do Vite, sem arquivo de config extra)
- SQLite (banco de dados)
- Eloquent ORM
- Vite + Node.js/NPM (build do frontend)
- Git

Sem React/Vue, sem API separada, sem microsserviços, sem Docker.

## 3. O que está neste pacote

Este pacote contém **apenas os arquivos da aplicação** (models, controllers,
migrations, seeders, rotas, views e configuração do Tailwind/Vite). Ele **não
inclui o esqueleto do Laravel** (pasta `vendor`, `artisan`, `public/index.php`,
etc.), pois esses arquivos são baixados automaticamente pelo Composer. Você vai
criar um projeto Laravel novo e copiar estes arquivos por cima.

Estrutura deste pacote:

```
app/Http/Controllers/...
app/Http/Middleware/EnsureUserIsAdmin.php
app/Http/Requests/...
app/Models/...
bootstrap/app.php
database/migrations/...
database/seeders/...
resources/css/app.css
resources/views/...
routes/web.php
vite.config.js
README.md
```

## 4. Requisitos (Windows + VS Code)

- PHP 8.2 ou superior instalado e no PATH (`php -v`)
- Composer instalado (`composer -V`)
- Node.js 18+ e NPM (`node -v`, `npm -v`)
- Git (opcional, mas recomendado)

## 5. Passo a passo de instalação

### 5.1. Criar o projeto Laravel

Abra o terminal do VS Code na pasta onde deseja criar o projeto e rode:

```bash
composer create-project laravel/laravel techfix
cd techfix
```

Isso cria um projeto Laravel novo (versão estável mais recente disponível,
compatível com Laravel 11/12/13, todas com a mesma estrutura usada aqui).

### 5.2. Copiar os arquivos deste pacote

Copie o conteúdo das pastas `app/`, `database/`, `resources/`, `routes/` deste
pacote **por cima** das pastas de mesmo nome no projeto recém-criado,
substituindo os arquivos quando solicitado. Copie também `bootstrap/app.php`
e `vite.config.js`, substituindo os originais.

Arquivos/pastas a copiar e sobrescrever no projeto Laravel:

- `app/Http/Controllers/` (adiciona controllers novos)
- `app/Http/Middleware/EnsureUserIsAdmin.php` (novo arquivo)
- `app/Http/Requests/` (novos arquivos)
- `app/Models/` (sobrescreve `User.php`, adiciona os demais)
- `bootstrap/app.php` (substitui o original — registra o middleware `admin`)
- `database/migrations/` (adiciona as 4 migrations novas)
- `database/seeders/` (sobrescreve `DatabaseSeeder.php`, adiciona os demais)
- `resources/css/app.css` (substitui o original)
- `resources/views/` (adiciona todas as views do projeto)
- `routes/web.php` (substitui o original)
- `vite.config.js` (substitui o original)

### 5.3. Instalar dependências PHP e JS

```bash
composer install
npm install
npm install -D tailwindcss @tailwindcss/vite
```

### 5.4. Configurar o `.env`

Abra o arquivo `.env` (criado automaticamente pelo `composer create-project`)
e ajuste a conexão do banco para usar SQLite:

```
DB_CONNECTION=sqlite
```

Remova ou comente as linhas `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`
e `DB_PASSWORD` (não são usadas pelo SQLite).

### 5.5. Criar o arquivo do banco SQLite

```bash
type nul > database\database.sqlite
```

(No PowerShell, use: `New-Item database\database.sqlite -ItemType File`)

### 5.6. Rodar migrations e seeders

```bash
php artisan migrate --seed
```

Isso cria as tabelas (`users`, `services`, `availabilities`, `appointments`)
e popula: 1 administrador de teste, 6 serviços de exemplo e horários
disponíveis para os próximos 5 dias úteis.

### 5.7. Compilar o frontend (Tailwind)

Para desenvolvimento (mantém rodando e recompila ao salvar):

```bash
npm run dev
```

Para gerar os arquivos finais (necessário antes de rodar sem o `npm run dev`
ativo):

```bash
npm run build
```

### 5.8. Iniciar o servidor Laravel

Em outro terminal:

```bash
php artisan serve
```

Acesse: http://127.0.0.1:8000

## 6. Credenciais de administrador de teste

```
E-mail: admin@example.com
Senha:  admin123
```

**Atenção:** essas são credenciais apenas para desenvolvimento/teste local.
Não use em produção.

## 7. Estrutura do sistema

### Entidades (tabelas)

- **users**: id, name, email, password, role (`cliente` ou `administrador`)
- **services**: id, name, description, price_cents (preço em centavos), active
- **availabilities**: id, date, time, available (horários que o admin libera)
- **appointments**: id, user_id, service_id, date, time, status
  (`pendente`, `agendado` ou `concluido`)

### Fluxo do cliente

1. Cria conta / faz login
2. Visualiza a lista de serviços ativos
3. Abre um serviço e clica em "Agendar este serviço"
4. Escolhe uma data (apenas datas com horários livres aparecem) e um horário
5. Confirma — o sistema verifica se o horário ainda está livre antes de
   gravar o agendamento (evita conflito entre dois clientes)
6. Acompanha o agendamento em "Meus Agendamentos", com o status atual

### Fluxo do administrador

1. Faz login com a conta de administrador
2. Acessa o painel administrativo (contadores gerais)
3. Cadastra, edita e desativa/remove serviços
4. Cadastra horários disponíveis (data + hora)
5. Visualiza todos os agendamentos e os detalhes de cada um
6. Altera o status do agendamento (Pendente → Agendado → Concluído)

### Regras de negócio implementadas

- Um horário só pode ser usado por um cliente (verificação em transação de
  banco + índice único em `date`+`time`)
- Não é possível agendar um serviço desativado
- O cliente só enxerga e usa os próprios agendamentos (nunca há rota que
  exponha agendamento de outro cliente)
- Rotas administrativas protegidas pelo middleware `admin`; rotas de cliente
  e admin protegidas pelo middleware `auth` do Laravel
- Senhas armazenadas com hash (bcrypt, padrão do Laravel)
- Formulários protegidos por CSRF (padrão do Blade/Laravel)
- Valores monetários armazenados como inteiro em centavos (`price_cents`),
  evitando problemas de ponto flutuante

## 8. Funcionalidades

**Área pública:** página inicial, login, cadastro.

**Área do cliente:** painel com resumo, lista de serviços, detalhes do
serviço, agendamento (escolha de data/horário), lista "Meus Agendamentos"
com status.

**Área administrativa:** painel com indicadores, CRUD de serviços,
gerenciamento de horários disponíveis, listagem e detalhe de agendamentos
com alteração de status.

## 9. Problemas comuns

- **Erro de rota `login`/`register` não encontrada:** confira se
  `routes/web.php` foi realmente substituído pelo deste pacote.
- **Página sem estilo (sem Tailwind):** rode `npm install` seguido de
  `npm run dev` (ou `npm run build`), e confirme que `resources/css/app.css`
  foi substituído.
- **Erro sobre coluna `role` não existir:** rode
  `php artisan migrate:fresh --seed` para recriar o banco do zero.
- **"could not find driver" (SQLite):** confirme que a extensão `pdo_sqlite`
  está habilitada no seu `php.ini`.
