# LocalTorrent

**Al usar LocalTorrent se descargan archivos Torrent. El usuario es el responsable de saber si estos, tienes los correspondientes derechos de autor. LocalTorrent no se hace responsable del mal uso. Ningún archivo es alojado en este servidor. Las descargas son realizadas a través del software [Transmission](https://transmissionbt.com/).

Requisitos LocalTorrent

1. Servidor Web (PHP, Mysql)
  - En la carpeta lib/DataBase se encuentran dos archivos:
    - BaseScript.sql, el cual hay que ejecutar para crear la base de datos.
    - DBConfig.txt el cual es la configuración de la base de datos.
2. Tranmission [Pagina Oficial](https://transmissionbt.com/download/)
  - **Windows / MacOs**
    - Instalar Transmission
    - En configuración / preferencias habilitar el acceso remoto.
    ![Ajustes Transmission](https://i.imgur.com/PeHvR6S.png "Ajustes Transmission")
  - **Linux**
    - Instalar el servicio de Transmission
      - sudo apt-get update
      - sudo apt-get install transmission-daemon
      - En el archivo de configuración '/etc/transmission-daemon/settings.json' poner las siguientes directivas:
        - "rpc-enabled": true
        - "umask": 000
        - "rpc-authentication-required": false
