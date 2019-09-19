<?php

class Quest
{
    function __construct()
    { }


    function init($_prefix, $_charset)
    {
        $table_name = $_prefix . "_pekorkort_quest";
        $sql = "CREATE TABLE $table_name (
            id              int(9)          NOT NULL AUTO_INCREMENT,
            quest           text            NOT NULL,
            answers         text            NOT NULL,
            quest_type      varchar(20)     NOT NULL,
            answer_types    varchar(100)    NOT NULL,
            season_id       int(10)         NOT NULL,
            level           int(2)          NOT NULL,
            wrong_refer     varchar(55)     NOT NULL,
            correct_refer  varchar(55)     NOT NULL,
            timestamp       bigint(55)      NOT NULL,
            
            PRIMARY KEY  (id)
          ) $_charset;";
    }
}
