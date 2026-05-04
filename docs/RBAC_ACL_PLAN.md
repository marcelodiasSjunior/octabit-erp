# Plano de Reestruturação: Controle de Acesso Granular (RBAC/ACL) e Status de Tenant

## 1. Visão Geral
Este plano detalha a transição do sistema de cargos estáticos (Enum) para um sistema dinâmico de Perfis e Permissões, permitindo controle granular por usuário e bloqueio de acesso em nível de empresa (tenant).

## 2. Diagnóstico da Estrutura Atual
*   **Cargos:** Atualmente fixos no Enum `UserRole`.
*   **Permissões:** Hardcoded dentro do método `UserRole::can()`.
*   **Bloqueio de Empresa:** Existe a coluna `status` na tabela `companies`, mas nenhuma trava lógica impede o uso do sistema por usuários de empresas inativas.
*   **Isolamento:** A trait `BelongsToTenant` garante a separação dos dados, mas não a autorização de operações.

## 3. Nova Arquitetura de Dados (ACL)

### 3.1 Modelos
*   **Role (Perfil):** Nome (ex: Gerente de Vendas) e slug.
*   **Permission (Permissão):** Slug da operação (ex: `deals.delete`, `users.create`).
*   **PermissionUser (Sobrescrita Individual):** Tabela pivot para vincular permissão diretamente ao usuário. **A regra é: Permissão Individual > Permissão do Perfil.**

### 3.2 Relacionamentos (Tabelas)
1.  `roles` (id, name, slug)
2.  `permissions` (id, name, slug, module)
3.  `role_user` (role_id, user_id)
4.  `permission_role` (permission_id, role_id)
5.  `permission_user` (permission_id, user_id, action: 'grant'|'deny')

## 4. Planejamento de Cenários e Regras de Negócio

### Cenário 1: Hierarquia de Permissões
*   **Fluxo:** O sistema verifica se o usuário tem a permissão `X`.
*   **Lógica:** 
    1. Verifica na `permission_user` se existe uma regra explícita para aquele usuário.
    2. Se não existir, verifica se algum dos `roles` do usuário possui a permissão.
    3. Se o usuário for `master_global`, retorna `true` automaticamente.

### Cenário 2: Bloqueio de Empresa Inativa
*   **Fluxo:** Middleware global verifica o `status` da `Company` vinculada ao usuário autenticado.
*   **Regra:** Se `company.status != 'active'`, o usuário é deslogado ou redirecionado para uma tela de "Acesso Suspenso".
*   **Exceção:** Usuários `master_global` ignoram esse bloqueio (para permitir manutenção administrativa).

### Cenário 3: Gestão de Acessos
*   **Ações:** O administrador da empresa pode criar novos perfis e selecionar quais módulos eles acessam.
*   **Ações:** O administrador pode ir no cadastro de um usuário específico e "dar um acesso extra" sem precisar mudar o perfil dele.

## 5. Etapas de Implementação (TDD)

### Fase 1: Fundação (Banco e Models)
1.  Criar migrações para as novas tabelas de ACL.
2.  Migrar dados do Enum atual para a nova estrutura.
3.  Implementar trait `HasPermissions` no model `User`.

### Fase 2: Middleware de Empresa
1.  Criar `EnsureCompanyIsActive` middleware.
2.  Registrar no `Kernel` (ou `bootstrap/app.php` no L11).
3.  Testar redirecionamento ao alterar status da empresa para `inactive`.

### Fase 3: UI de Gestão de Perfis
1.  Criar CRUD de Perfis (Roles) para Administradores de Empresa.
2.  Interface de checkbox para selecionar permissões.

### Fase 4: Sobrescrita Individual
1.  Atualizar o formulário de edição de usuário para incluir uma aba de "Permissões Especiais".

## 6. Considerações de Performance
*   Utilizar **Cache** para as permissões do usuário, evitando múltiplas queries em tabelas pivot a cada carregamento de página.
*   O cache deve ser limpo sempre que o perfil ou as permissões individuais do usuário forem alterados.

## 7. Próximos Passos Sugeridos
*   Iniciar pela criação das migrações e da lógica de middleware de bloqueio de empresa, que é a parte mais crítica para a segurança do faturamento (Tenancy Protection).
