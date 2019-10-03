<?php

define('URL','https://pokeapi.co/api/v2/pokemon/');
define('MAX_MOVES', 4);

function getMoves(array $data) {
    $moves = (array)array_rand($data['moves'], min(MAX_MOVES, count($data['moves'])));
    foreach($moves AS $move) {
        $moveName = $data['moves'][$move]['move']['name'];
        echo '<li>'.$moveName.'</li>';
    }
}

function getTypes(array $data) {
    $types = (array)$data['types'];
    foreach($types AS $type) {
        $typeName = $type['type']['name'];
        echo '<li>'.$typeName.'</li>';
    }
}

if(empty($_GET['pokemon'])) {
    $_GET['pokemon'] = 1;
}

function fetcher($url)  {
    $data = file_get_contents($url);
    return json_decode($data, true);
}

// Function to gather all english flavor texts into one array
function flavorCatcher(array $species)
{
    $flavor_en = [];
    foreach ($species["flavor_text_entries"] AS $flavor_text) {
        if ($flavor_text["language"]["name"] === "en") {
            $flavor_en[] = $flavor_text["flavor_text"];
        }
    }
    return $flavor_en;
}

$data = fetcher(URL . strtolower($_GET['pokemon']));

$species = fetcher ($data["species"]["url"]);
$previous = fetcher (URL.$species["evolves_from_species"]['name']);

if ($species["evolves_from_species"] != null){;
    $display = 'block;';
}
else{
    $display = 'none;';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Pokédex">
    <meta name="keywords" content="pokémon, pokemon, pokédex, pokedex, gotta catch em all">
    <meta name="author" content="Robin Mariën">
    <link rel="icon" type="image/png" href="images/pokedex.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P&display=swap" rel="stylesheet">
    <title>Pokédex</title>
</head>
<body>
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <form id="search" method="get">
                    <input id="pokemon" type="text" name="pokemon" placeholder="Enter name or ID" required>
                    <button id="run" class="button" type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 half">
                <div id="info">
                    <div class="pokeID text-center">
                        <span>#</span>
                        <span id="id">
                            <?php
                            echo $data["id"]
                            ?>
                        </span>
                        <h1 id="name">
                            <?php
                                echo $data["name"]
                            ?>
                        </h1>
                    </div>

                    <div class="pokemonimage text-center">
                        <div id="pokeBackground">
                            <img id="main-pokemon" src="<?php echo $data["sprites"]["front_default"]?>">
                        </div>
                    </div>
                    <div id="styleButtons" class="text-center">
                        <button id="front" class="m-2 px-3">front</button>
                        <button id="back" class="m-2 px-3">back</button>
                        <button id="shiny" class="m-2 px-3">shiny</button>
                        <button id="shiny-back" class="m-2 px-3">shiny-back</button>
                    </div>
                    <div class="text">
                        <p id="infoText">
                            <?php // Gather all english flavorTexts and display a random one from that array
                            $flavor_en = flavorCatcher($species);
                            $flavor_rand = array_rand($flavor_en);
                            echo '<i>' . $flavor_en[$flavor_rand] . '</i>'; ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 half">
                <div class="row">
                    <div class="col-md-6">
                        <div id="information-pokemon" class="text">
                            <p>Type:</p>
                            <ul id="type">
                                <?php getTypes($data) ?>
                            </ul>
                            <p>Height:
                                <span id="height">
                                    <?php echo ($data["height"]/10) ?> m
                                </span>
                            </p>
                            <p>Weight:
                                <span id="weight">
                                    <?php echo ($data["weight"]/10) ?> kg
                                </span>
                            </p>
                            <p>HP:
                                <span id="hp">
                                    <?php echo $data["stats"][5]["base_stat"] ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="moves" class="text">
                            <p class="movement">Moves</p>
                            <ul id="move-list">
                                <?php getMoves($data) ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id= "evoBox" class="text">
                    <div id='evolutions' class='text-center' style="display:<?php echo $display ?>">
                        <p>Evolved from</p>
                        <a href="?pokemon=<?php echo $previous['id'] ?>">
                            <img id='pre-evolution' src="<?php echo $previous['sprites']['front_default']?>">
                            <p>#
                                <span id='preId'>
                                    <?php echo $previous["id"] ?>
                                </span>
                                <span id='preName'>
                                    <?php echo $previous["name"] ?>
                                </span>
                            </p>
                        </a>

                    </div>
                </div>
                <div class="arrows row justify-content-around text-center">
                    <div class="col-6">
                        <a href="?pokemon=<?php echo ($data['id']-1) ?>">
                            <button id="prev">&lt;</button>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="?pokemon=<?php echo ($data['id']+1) ?>">
                            <button id="next">&gt;</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--<script src="script.js" charset="UTF-8"></script>-->
</body>
</html>