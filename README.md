# 🛰️TimezoneCLI🛰️

O projeto consiste em um CLI escrito em PHP que realiza funções baseadas em fusos horários de países.

## Instalação via Git clone

```bash
git clone https://github.com/guibmolina/timezoneCLI.git
cd timezoneCLI/
composer dump-autoload
chmod +x timezone.php
```

## Instalação via Docker

```bash
docker run -it guibmolina/timezonecli
```

## Ações

- Mostrar a hora atual de um país:

```bash
$ ./timezone.php -H BRA

//2022-04-20 09:14
```

- Mostrar o fuso horário entre o GMT (**Greenwich Mean Time Zone**) e um país:

```bash
$ ./timezone.php -t BRA

// -03:00
```

- Mostrar o fuso horário entre dois países:

```bash
$ ./timezone.php -t BRA FRA

// +05:00
```

- Conhecer todas as funções

```bash
$ ./timezone.php --help
```

** Os códigos dos países estão de acordo com a  **ISO 3166-1 alpha-3 (**[https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)**)**
