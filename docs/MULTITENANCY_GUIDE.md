# Guia de Multi-Tenancy e Deploy — OctaBit ERP

Este documento detalha a arquitetura de multi-tenancy (múltiplas empresas) baseada em subdomínios e o procedimento para provisionar novos ambientes de clientes no servidor Hostinger.

## 1. Arquitetura do Sistema

O OctaBit ERP utiliza uma estratégia de **Banco de Dados Único com Isolamento Lógico**.
- **Identificação:** O sistema identifica a empresa (tenant) através do subdomínio acessado (ex: `apple.octabit.tech`).
- **Isolamento:** O `TenantMiddleware` captura o host, busca a empresa correspondente e aplica um escopo global em todas as queries de banco de dados através da trait `BelongsToTenant`.
- **Global Admin:** Usuários com o cargo `master_global` ignoram esse filtro e possuem visibilidade total de todas as empresas.

---

## 2. Infraestrutura e DNS

Para que novos subdomínios funcionem, a infraestrutura deve seguir estes requisitos:

### A. Registro Wildcard (DNS)
Um registro do tipo `A` deve existir apontando `*` para o IP do servidor (`147.93.64.215`). Isso garante que qualquer subdomínio digitado chegue ao servidor.

### B. Certificado SSL
É necessário um certificado **Wildcard SSL** (`*.octabit.tech`) ou a emissão de um certificado individual para cada novo subdomínio via painel da Hostinger para evitar erros de conexão insegura.

---

## 3. Provisionamento de Novo Cliente (Manual)

Sempre que uma nova empresa for cadastrada, siga estes passos para liberar o acesso via subdomínio:

1.  **Criar Subdomínio no Painel:** No hPanel da Hostinger, vá em *Subdomínios* e crie o nome desejado (ex: `cliente1`).
2.  **Configurar Pasta:** Aponte o subdomínio para a pasta `/public_html/cliente1`.
3.  **Instalar a "Ponte" (Bridge):** Copie os arquivos de configuração da pasta `/demo` para a nova pasta do cliente:
    ```bash
    cp /public_html/demo/index.php /public_html/cliente1/index.php
    cp /public_html/demo/.htaccess /public_html/cliente1/.htaccess
    ```
4.  **Linkar Assets (CSS/JS):** Para que o layout carregue, crie o link simbólico para a pasta build:
    ```bash
    ln -s /home/u688664394/domains/octabit.tech/laravel_app/public/build /home/u688664394/domains/octabit.tech/public_html/cliente1/build
    ```

---

## 4. Padronização de Dados (Máscaras)

O sistema possui formatação automática nativa para garantir a integridade dos dados:
- **Trait `HasMasks`:** Aplicada nos modelos `Client` e `Company`.
- **Casts de Atributos:** Documentos (CPF/CNPJ) e Telefones são formatados automaticamente tanto ao salvar no banco quanto ao exibir na interface.
- **Frontend:** O arquivo `components/layouts/app.blade.php` contém um script global que aplica máscaras em tempo real nos inputs de formulários.

---

## 5. Personalizações por Cliente

Embora o código seja compartilhado, é possível realizar personalizações:

### A. Configurações Dinâmicas (Recomendado)
Use a coluna `settings` (JSON) na tabela `companies` para salvar cores, logos ou flags de funcionalidades específicas que mudam o comportamento do ERP para aquele cliente.

### B. Customização de Código (Ambientes Segregados)
Se um cliente exigir uma lógica de negócio única, você pode criar uma branch no Git para ele e realizar um deploy em uma pasta `laravel_app_custom` separada, alterando o caminho no `index.php` da pasta do subdomínio dele.

---

## 6. Automação Futura (Roadmap)

Para escalar o sistema, recomenda-se automatizar o passo 3 (Provisionamento):
1.  **Script de Cadastro:** Criar um comando no Laravel (`php artisan tenant:create {name}`) que:
    - Cria a empresa no banco.
    - Cria a pasta em `public_html`.
    - Copia os arquivos `index.php` e `.htaccess`.
    - Executa o comando `ln -s` para os assets.
2.  **Integração com API Hostinger:** Se disponível, automatizar a criação do subdomínio e SSL via API.

---

## 7. Comandos de Manutenção Úteis

- **Limpar Cache Geral:** `php artisan optimize:clear`
- **Promover Master Admin:** `php artisan db:seed --class=UserSeeder`
- **Verificar Migrações:** `php artisan migrate:status`
