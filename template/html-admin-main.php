<div id="PekorKort">

    <h1>Hello World</h1>

    <br>
    <br>
    <br>

    <?php

    // var_dump(get_current_user_id());

    var_dump($exam_generator->new_exam(1, [
        "new_only"      => false,
        "emptys"        => true,
        "wrongs"        => true,
        "answer_result" => false,
        "random"        => true,
        "length"        => 2,
        "category"      => '',
    ]));




    ?>

</div>