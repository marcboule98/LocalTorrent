# LocalTorrent
Requisitos LocalTorrent

1. Servidor Web
2. Tranmission [Pagina Oficial](https://transmissionbt.com/download/)
  - Windows / MacOs
    1. Instalar Transmission
    2. En configuración / preferencias habilitar el acceso remoto.
    ![Ajustes Transmission](https://i.imgur.com/PeHvR6S.png "Ajustes Transmission")
  1. Linux
    - Instalar el servicio de Transmission
      1. sudo apt-get update
      2. sudo apt-get install transmission-daemon
      3. En el archivo de configuración '/etc/transmission-daemon/settings.json' poner las siguientes directivas.
        - "rpc-enabled": true
        - "umask": 000
        - "rpc-authentication-required": false
