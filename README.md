# Home sweet home (hsh)

Home sweet home tem a ideia inicial de centralizar links e informações de como acessar sistemas e softwares de uma rede local.

HSH será uma "intranet doméstica" com todos os links de sistemas que tenho na minha rede, como por exemplo:
- Jellyfin: O Jellyfin é um conjunto de aplicativos de multimídia projetados para organizar, gerenciar e compartilhar arquivos de mídia digital com dispositivos em rede.
- Samba: Servidor Samba é um software executado em servidores Linux, responsável por estabelecer interações com redes constituídas por computadores com Windows.
- qBittorrent: qBittorrent é um aplicativo cliente P2P multiplataforma, gratuito, livre e de código aberto para a rede BitTorrent.


### Executar

Para executar o sistema, é necessário criar o banco, para isso, foi adicionado em doc/ o "schema.sql", e também caso queira ver um exemplo de insert, lá tem o "insert_example.sql".

Para dar uma ajudinha, pode-se executar o comando ```php bin/start_database.php``` a partir da pasta application do projeto (ou assim que entrar na docker utilizando o docker-compose);

Na pasta containers/databases, existe um ".env.example" para ser usado como base para criação do seu .env, então, copie e renomeie para .env e deixe em containers/databases, e uma cópia também em application/.env

Caso queira utilizar o ambiente com a docker, precisará da docker e do docker compose instalados, então bastará executar ```docker-compose up -d``` no ambiente de "produção", ou ```docker-compose -f docker-compose-dev.yml up -d``` no ambiente de desenvolvimento.

Obs.: Lembre-se de realizar o composer install
