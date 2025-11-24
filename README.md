# LoteSmart (scaffold)

Projeto scaffold em PHP para o sistema LoteSmart.

Principais pontos:
- PHP simples com PDO + MySQL
- Autenticação por formulário (sessão)
- Módulos iniciais: usuários (registro/login) e lotes (CRUD minimal)

Instalação rápida

1. Copie o arquivo de configuração e edite as credenciais:

```powershell
cp app/config.php app/config.local.php
# editar app/config.local.php e ajustar db_user/db_pass
```

2. Criar banco / rodar migration (MySQL):

```powershell
# no MySQL: (substitua credenciais quando necessário)
mysql -u root -p < migrations/init.sql
```

3. Rodar servidor PHP embutido (apontar `public` como document root):

```powershell
# a partir da pasta do projeto
php -S 127.0.0.1:8000 -t public
```

4. Abra no navegador: `http://127.0.0.1:8000/?r=login`

Notas
- Ajustarei a implementação conforme o `LoteSmart.pdf` quando tivermos o mapa de requisitos extraído.# LoteSmart