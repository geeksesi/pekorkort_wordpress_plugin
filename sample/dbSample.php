<?php


$array = [
    [
        "question"      => "how old are u",
        "answers"       => "12ß18ß16ß23ß22ß25",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 3,
        "level"         => 3,
    ],
    [
        "question"      => "how are u",
        "answers"       => "goodßbadßasasßsss",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 3,
        "level"         => 1,
    ],
    [
        "question"      => "wich one of tem ",
        "answers"       => "dotaßcsßclash",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 2,
    ],
    [
        "question"      => "for te thest",
        "answers"       => "testßRRRßsssß",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 3,
    ],
    [
        "question"      => "forasdasdasdas",
        "answers"       => "axaxaxßaxaxaxßaxaxax",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 1,
    ],
    [
        "question"      => "axaxaxax",
        "answers"       => "sdasdßasdasßasdaßsaas",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 2,
    ],
    [
        "question"      => "khkhkhkhkhkhkh",
        "answers"       => "55ß66ß88ß99ßi",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 3,
    ],
    [
        "question"      => "OMG",
        "answers"       => "WOOWßWWWßWWSSßSSDSßsdasd",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 1,
    ],
    [
        "question"      => "OMGLLLLLLLLLSLSLSLSL",
        "answers"       => "lslslßslslslßsososoßaa",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 1,
        "level"         => 2,
    ],
    [
        "question"      => "assdasd",
        "answers"       => "aasasßasasdßasdasdßasdasdßASAS",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 2,
        "level"         => 3,
    ],
    [
        "question"      => "ppoooii",
        "answers"       => "yuiasydißuyouyßouyoiuyßoyoiuyßuyoiyßSAS",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 2,
        "level"         => 3,
    ],
    [
        "question"      => "AAASASAS",
        "answers"       => "ASDASßSASDASßASASD",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 2,
        "level"         => 1,
    ],
    [
        "question"      => "AWQWQWQW",
        "answers"       => "sassadßasdasdßqqqq",
        "quest_type"    => 'null',
        "answers_type"  => "t",
        "wrong_refer"   => 'null',
        "correct_refer" => 'null',
        "category_id"   => 2,
        "level"         => 2,
    ],

];


function insert_value()
{
    global $quest_db;
    global $array;
    foreach ($array as $key => $value) {

        $question           = $value["question"];
        $answers            = $value["answers"];
        $quest_type         = $value["quest_type"];
        $answers_type       = $value["answers_type"];
        $wrong_refer        = $value["wrong_refer"];
        $correct_refer      = $value["correct_refer"];
        $category_id        = $value["category_id"];
        $level              = $value["level"];

        $quest_db->set_data($question, $answers, $quest_type, $answers_type, $wrong_refer, $correct_refer, $category_id, $level);
    }
}

insert_value();
