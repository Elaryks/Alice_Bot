<?php

const QUE = array(
    0 => array("прив", "привет", "приветик", "приветос", "хай", "хаюшки", "хей", "дороу", "дратути", "здорова", "здарова", "здравствуй", "здравствуйте", "дароф", "даров", "здароф"),
    1 => array("какдела", "чёкак", "чокак", "какты", "какдила", "шокак"),
    2 => array("погода", "пагода", "прогноз", "погоде", "погоды")
);

const ANS = array(
    0 => array(
        // &#128521; — подмигивание
        // &#128526; — в солнечных очках
        // &#128516; — смеющийся
        // &#128522; — улыбающийся
        //
        "Здравствуй, user_name &#128526;",
        "О, user_name, привет &#128522;",
        "Привет-привет, user_name &#128516;",
        "Оу, user_name, рад тебя видеть!",
        "Приветик, user_name! Рад тебя видеть!",
        "Дратути, user_name &#128526;",
        "О, какие люди &#128522; Привет, user_name!",
        "user_name, моё почтеньице &#128526;",
        "Доброго времени суток, user_name!",
        "Доброго дня, или ночи, или что там у тебя, user_name!" // Не забыть запятую при продлении списка!
    ),
    1 => array(
        "Спасибо, что поинтересовался, user_name &#128516; У меня всё хорошо. Надеюсь, что у тебя тоже &#128521;",
        "Всё очень неплохо. Надеюсь, у тебя тоже всё хорошо, user_name &#128516;",
        "В целом всё гут, user_name &#128521;"
    ),
    2 => array(
        0 => "user_weather"
    )
);
