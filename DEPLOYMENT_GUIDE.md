# Guia de Deploy para Hostinger - OctaBit ERP

## 📋 Pré-Requisitos

- [x] Código completo do módulo de orçamentos testado e funcionando
- [x] Repositório GitHub criado e vinculado
- [x] Estrutura `public_html/` e workflow criados
- [ ] Acesso SSH ao servidor Hostinger confirmado
- [ ] Banco de dados criado no Hostinger
- [ ] Chaves SSH do Hostinger configuradas (ou usar sshpass com password)

## 🔐 Configuração de GitHub Secrets

O workflow de deploy requer os seguintes secrets configurados no repositório:

### Passos para Configurar:

1. Vá para seu repositório GitHub → **Settings → Secrets and variables → Actions**
2. Clique em **"New repository secret"** para cada secret abaixo:

| Secret Name | Valor | Descrição |
|------------|-------|------------|
| `HOSTINGER_SSH_HOST` | `147.93.64.215` | IP do servidor Hostinger |
| `HOSTINGER_SSH_PORT` | `65002` | Porta SSH do Hostinger |
| `HOSTINGER_SSH_USER` | `u688664394` | Usuário SSH da conta Hostinger |
| `HOSTINGER_SSH_PASSWORD` | Conforme recebido | **REMOVER APÓS SETUP — usar chaves SSH no futuro** |
| `HOSTINGER_REMOTE_BASE_DIR` | `domains/octabit.tech` | Caminho base no servidor (verificar com Hostinger) |

### ⚠️ IMPORTANTE: Segurança da Senha

A senha foi fornecida em texto claro nesta conversa. Você **DEVE**:
1. Adicioná-la aos GitHub Secrets imediatamente
2. **Rotacionar a senha no painel Hostinger** após confirmar que o deploy funciona
3. Gerar e usar chaves SSH públicas/privadas em vez de password (melhor prática)

## 🚀 Primeiro Deploy

### 1. Commit e Push das Mudanças

```bash
cd c:\projetos\hostinger\octabit.tech\erp
git add -A
git commit -m "feat: add deployment infrastructure (public_html + GitHub Actions)"
git push origin main
```

### 2. Monitorar o Workflow

- Vá para seu repositório GitHub → **Actions**
- Localize o workflow "Deploy to Hostinger"
- Verifique cada etapa:
  - ✓ **test job**: Deve rodar testes (15 web + 5 API)
  - ✓ **build job**: Depenede do test passar, faz build de assets e deploy

### 3. Validar no Servidor

Após o workflow completar com sucesso:

```bash
# SSH ao servidor
ssh -p 65002 u688664394@147.93.64.215

# Navegar para a app
cd domains/octabit.tech/laravel_app

# Verificar estrutura
ls -la
ls -la ../public_html/

# Testar .env
cat .env | grep APP_URL

# Ver logs (se houver erros)
tail -50 storage/logs/laravel.log
```

## 📝 Checklist Pré-Deploy

- [ ] Todos os testes passam localmente (`php artisan test`)
- [ ] Assets compilam sem erros (`npm run build`)
- [ ] `.env.production` preparado (será criado no servidor se não existir)
- [ ] Banco de dados criado no Hostinger (via cPanel)
- [ ] GitHub Secrets configurados corretamente
- [ ] `.github/workflows/deploy-hostinger.yml` commitado
- [ ] `public_html/` commitado com `index.php` e `.htaccess`
- [ ] Branch `main` ou `master` pronto para deploy

## 🔧 Configuração Inicial no Servidor (Primeira Vez)

Se for o primeiro deploy, você pode precisar fazer alguns passos manuais:

```bash
# SSH ao servidor
ssh -p 65002 u688664394@147.93.64.215

# Entrar na app
cd domains/octabit.tech/laravel_app

# Criar .env se não existir
cp .env.example .env
nano .env  # Editar APP_URL, DB_*, etc.

# Gerar chave da app
php artisan key:generate

# Criar tabelas
php artisan migrate

# (Opcional) Seedar usuários
php artisan db:seed
```

O workflow tenta fazer isso automaticamente na etapa "post-deployment", mas você pode fazer manualmente se preferir maior controle.

## 🐛 Troubleshooting

### Erro: "manifest.json not found"
- **Causa**: Build de assets falhou
- **Solução**: Verificar logs do workflow, rodar `npm run build` localmente
- **Verificar**: `npm ci && npm run build` && `test -f public/build/manifest.json`

### Erro: "rsync not found"
- **Cause**: Dependência do workflow não instalada
- **Solução**: Workflow instala automaticamente via `apt-get install rsync sshpass`

### Erro: SSH permissão negada
- **Causa**: Credenciais erradas ou host/porta errada
- **Solução**: Verificar GitHub Secrets, testar SSH manualmente: `ssh -p 65002 u688664394@147.93.64.215`

### App não carrega após deploy
- **Verificar logs**: `tail -50 laravel_app/storage/logs/laravel.log`
- **Testar acesso**: `curl -k https://octabit.tech/login`
- **Validar PHP**: `php --version` (deve ser 8.2+)
- **Verificar .env**: APP_URL, DB_*, CACHE_DRIVER, etc.

## 📊 Estrutura Pós-Deploy no Servidor

```
domains/octabit.tech/
├── laravel_app/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/         # ← Com /build/manifest.json
│   ├── resources/
│   ├── routes/
│   ├── storage/        # ← Permissões 755+
│   ├── .env            # ← Criado manualmente ou pelo workflow
│   └── artisan
└── public_html/
    ├── index.php       # ← Router delegando para laravel_app/public
    └── .htaccess       # ← Rewrite rules + segurança
```

## ✅ Validação Pós-Deploy

1. **Página de Login**: https://erp.octabit.tech/login (ou seu domínio)
   - Deve carregar sem erros 502/503
   - Certificado HTTPS deve ser válido

2. **Endpoint /quotes**: https://erp.octabit.tech/quotes
   - Redireciona para login se não autenticado
   - Após login, lista orçamentos

3. **Assets Carregados**: Verificar DevTools
   - CSS/JS devem carregar de `/build/...`
   - manifest.json presente em `public/build/manifest.json`

4. **Logs**: Verificar se há erros
   ```bash
   ssh -p 65002 u688664394@147.93.64.215
   tail -50 domains/octabit.tech/laravel_app/storage/logs/laravel.log
   ```

## 🔄 Próximas Implantações

Após o primeiro deploy bem-sucedido, praticamente todo push para `main/master` acionará o workflow automaticamente:

1. Testes rodam
2. Assets compilam
3. Deploy ocorre
4. Post-deploy commands (migrate, cache clear, etc) executam

Não há ação manual necessária!

---

**Última atualização**: 2026-04-17  
**Status**: Pronto para primeiro deploy
