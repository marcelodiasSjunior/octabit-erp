# Plano de reinsercao da landing sem impacto no ERP

## Objetivo
Reinserir as otimizações e refatoracoes da landing page sem alterar funcionalidades do ERP.

## Escopo da reinsercao
Arquivos de marketing (landing):
- public_html/home.php
- public_html/includes/config.php
- public_html/css/app.css
- public_html/js/app.js

## Fonte de verdade
Commit de referencia usado para restauracao seletiva:
- 82bcf66

## Estrategia aplicada
1. Restauracao seletiva dos arquivos da landing a partir do commit de referencia.
2. Validacao para garantir que nenhum arquivo do ERP foi alterado.
3. Inclusao de guardrails no repositorio para evitar ruido operacional em proximos commits.

## Guardrails adicionados
Atualizacao de .gitignore para ignorar artefatos temporarios que nao devem entrar em versionamento:
- storage/framework/views/*.php
- erp/

## Validacoes executadas
- Restauracao seletiva executada com git checkout por arquivo.
- Verificacao de status para confirmar ausencia de mudancas no ERP.
- Confirmacao de que os arquivos da landing permanecem no estado esperado.

## Resultado
Landing preservada no estado otimizado e fluxo de commit protegido contra arquivos temporarios que podem confundir revisoes futuras.
