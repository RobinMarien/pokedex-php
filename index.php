<?php

$api_url = "https://pokeapi.co/api/v2/";
$random_onLoad = rand($min = 1, $max = 806);

function fetcher($url)  {
    $data = file_get_contents($url);
    return json_decode($data, true);
}

$data = fetcher($api_url . "pokemon/" . $random_onLoad);

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
                <form id="search">
                    <input id="pokemon" type="text" name="input-field" placeholder="Enter name or ID" required>
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
                            <img id="main-pokemon">
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
                            <?php echo $data ?>
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
                            </ul>
                            <p>Height: <span id="height"></span></p>
                            <p>Weight: <span id="weight"></span></p>
                            <p>HP: <span id="hp"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="moves" class="text">

                            <p class="movement">Moves</p>
                            <ul id="move-list">


                            </ul>
                        </div>
                    </div>
                </div>
                <div id= "evoBox" class="text">
                    <div id="evolutions" class="text-center">
                        <p>Evolved from</p>
                        <img id="pre-evolution">
                        <p>#<span id="preId"></span> <span id="preName"></span></p>
                    </div>
                </div>

                <div class="arrows row justify-content-around text-center">
                    <div class="col-6">
                        <button id="prev">&lt;</button>
                    </div>
                    <div class="col-6">
                        <button id="next">&gt;</button>
                    </div>
                </div>


            </div>
        </div>
    </div>


<script src="script.js" charset="UTF-8"></script>
</body>
</html>