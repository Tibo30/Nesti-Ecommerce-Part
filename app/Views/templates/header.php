<!doctype html>
<html>

<head>
    <title>CodeIgniter Tutorial</title>
</head>

<body>

    <em>&copy; 2021</em>


<ul>
<li><a href=<?= base_url("public/home"); ?>>Home</a></li>
<li><a href=<?= base_url("public/tags"); ?>>Lire Tous</a></li>
<li><a href=<?= base_url("public/tag/1"); ?>>Lire 1</a></li>
<li><a href=<?= base_url("public/tag/1/edit"); ?>>Editer 1</a></li>
<li><a href=<?= base_url("public/tag/create"); ?>>Créer</a></li>
<li><a href=<?= base_url("public/tag/search"); ?>>Rechercher</a></li>
</ul>

<h1><?= esc($title) ?></h1>

</body>
