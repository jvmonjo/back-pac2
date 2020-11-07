# Instal·lació de CodeIgniter 4

He instal·lat CodeIgniter 4 mitjançant composer

```bash
composer create-project codeigniter4/appstarter project-root
```

# Base de dades

He creat una base de dades amb phpmyadmin i dins d'ella he creat les següents taules:

- categories: id, title
- news: id, title, author, date, content, image, category_id

He definit categoy_id com a foreign key de categories.id a la base de dades usant la pestanya relacions de phpmyadmin.

# Desenvolupmanet del backend

Primer he editat el fitxer app/config/Database.php amb les credencials de la base de dades.

Després he creat els models per a News i per a Categories.

A continuació he creat el controlador per llistar les news dins de app/Controllers i he afegit la ruta al fitxer app/config/Routes.php

En el controlador he creat una funció per gestionar les diferents respostes retornant el codi corresponent i les dades o un missatge d'error.

```php
private function genericResponse($data, $msg, $code){

        if ($code == 200) {
            return $this->respond(array(
                'data' => $data,
                'code' => $code
            ));
        } else {
            return $this->respond(array(
                'msg' => $msg,
                'code' => $code
            ));
        }
    }
```
També he creat les diferents funcions que necessitarem per fer CRUD:
- index()
- show()
- create()
- update()
- delete()

He creat algunes validacions bàsiques a app/Config/Validation.php per a l'operació de create()

```php
public $news =[
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'min_length[3]|max_length[5000]'
    ];
```

## Grocery CRUD

Per a instal·lat Grocery CRUD he seguit el vídeo explicatiu de l'autor (https://www.youtube.com/watch?v=h-1q3IItG0I&t=308s&ab_channel=HappyDevelopers) i després he adaptat el controlador i la vista als nostres models (news i categories).

Ell reconama desactivar les rutes automàtiques si et dona error i afegir-les manualment. En el meu cas, m'ha funcionat amb les autorutes en true.