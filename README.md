# OctaBit ERP

ERP moderno para a OctaBit com gestão de clientes, financeiro, contratos e serviços.

## Stack

| Camada | Tecnologia |
|--------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade + TailwindCSS v3 + Alpine.js |
| Banco de dados | MySQL 8 |
| Cache/Queue | Redis 7 |
| Containerização | Docker (PHP-FPM, Nginx, MySQL, Redis) |
| Testes | Pest v3 (TDD) |

---

## Início Rápido

### 1. Pré-requisitos
- Docker + Docker Compose
- Node.js 20+ (para build de assets, caso rode fora do container)

### 2. Subir os containers

```bash
# Copiar variáveis de ambiente
cp .env.example .env

# Subir containers
docker-compose up -d

# Instalar dependências PHP (dentro do container)
docker exec octaerp_app composer install

# Gerar chave da aplicação
docker exec octaerp_app php artisan key:generate

# Executar migrations
docker exec octaerp_app php artisan migrate --seed

# Build de assets (dentro do container)
docker exec octaerp_app npm ci
docker exec octaerp_app npm run build
```

### 3. Acessar

- **URL:** http://localhost:8080
- **Admin:** admin@octabit.tech / `password`
- **Gerente:** gerente@octabit.tech / `password`
- **Operador:** operador@octabit.tech / `password`

---

## Arquitetura

```
Clean Architecture com separação clara de responsabilidades:

Request → Controller (thin) → Service (business logic) → Repository (data) → Model
```

```
app/
├── DTOs/                    # Data Transfer Objects (imutáveis, readonly)
├── Enums/                   # PHP 8.1 backed enums (status, tipos)
├── Http/
│   ├── Controllers/         # Thin controllers — apenas HTTP I/O
│   ├── Middleware/          # CheckRole, etc.
│   └── Requests/            # Validação e autorização por FormRequest
├── Models/                  # Eloquent — apenas mapeamento e relações
├── Providers/               # RepositoryServiceProvider (DI bindings)
├── Repositories/
│   ├── Contracts/           # Interfaces (Dependency Inversion)
│   └── Eloquent/            # Implementações concretas
└── Services/                # Regras de negócio puras
```

### Princípios SOLID aplicados

| Princípio | Como aplicado |
|-----------|--------------|
| **S**ingle Responsibility | Controllers só lidam com HTTP; Services só com regras de negócio |
| **O**pen/Closed | Enums com métodos `label()`, `color()` extensíveis sem modificar consumidores |
| **L**iskov Substitution | Repositórios implementam interfaces — substituíveis sem quebrar |
| **I**nterface Segregation | `ClientRepositoryInterface` específico, não um repositório genérico inchado |
| **D**ependency Inversion | Services dependem de interfaces, não de Eloquent diretamente |

---

## Testes (TDD)

```bash
# Rodar todos os testes
docker exec octaerp_app php artisan test
# ou
docker exec octaerp_app ./vendor/bin/pest

# Com coverage
docker exec octaerp_app ./vendor/bin/pest --coverage
```

### Cobertura de testes incluída

| Área | Tipo | O que cobre |
|------|------|-------------|
| `PaymentStatus::calculate` | Unit | Todos os cenários de data |
| `ClientStatus` enum | Unit | Labels, isActive(), from() |
| `CreateClientDTO` | Unit | Criação, defaults, toArray() |
| Criar cliente (HTTP) | Feature | Cenários happy path + erros |
| Listar clientes (HTTP) | Feature | Autenticação, filtros, soft-delete |
| Atualizar/Deletar cliente | Feature | Permissões por role, conflito de email |
| Login / Logout | Feature | Credenciais válidas/inválidas |
| Contas a Receber | Feature | CRUD + mark-as-paid + filtros |

---

## Entidades e Relacionamentos

```
Client
  ├── has many Contracts
  ├── has many ClientServices → Service
  └── has many AccountsReceivable

AccountsReceivable
  └── belongs to Client
  └── morphTo reference (Contract, ClientService, etc.)

AccountsPayable (independente de cliente)

User
  └── role: admin | manager | operator
```

---

## Regras de Negócio

- `PaymentStatus` é **calculado automaticamente** com base em `due_date` e `payment_date`
  - `payment_date != null` → **Paid**
  - `due_date < hoje` → **Overdue**
  - `due_date >= hoje` → **Pending**
- Documentos (CPF/CNPJ) devem ser **únicos** por cliente
- E-mail deve ser **único** por cliente
- **Soft-delete** em clientes, contratos e cobranças (auditável)
- Exclusão de cliente só permitida para **admin**
- Preço personalizado em `ClientService` sobrescreve `Service.base_price`

---

## Paleta de Cores OctaBit

| Token | Hex | Uso |
|-------|-----|-----|
| `bg-primary` | `#0a0b14` | Fundo geral |
| `bg-secondary` | `#12131e` | Cards, sidebar |
| `bg-elevated` | `#1c1d2e` | Inputs, hover |
| `octa-500` | `#7c3aed` | Primária (purple) |
| `cyan-500` | `#06b6d4` | Accent |

---

## Próximos Passos (Features v2)

- [ ] Gestão de Contratos (upload PDF, status automático por data)
- [ ] Catálogo de Serviços e Produtos
- [ ] Contas a Pagar
- [ ] Geração automática de cobranças recorrentes (Job agendado)
- [ ] Relatórios financeiros (PDF/Excel)
- [ ] API REST com Sanctum (para integrações)
- [ ] Notificações de vencimento (e-mail/webhook)
