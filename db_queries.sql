create table users
(
    id       int auto_increment
        primary key,
    username varchar(255) not null,
    password varchar(255) null
);

create table quizzes
(
    id   int auto_increment
        primary key,
    name varchar(255) not null
);

create table questions
(
    id      int auto_increment
        primary key,
    quiz_id int          not null,
    text    varchar(255) not null,
    constraint questions_quizzes_id_fk
        foreign key (quiz_id) references quizzes (id)
);

create table answers
(
    id          int auto_increment
        primary key,
    question_id int          null,
    text        varchar(255) null,
    correct     int          not null,
    constraint answers_questions_id_fk
        foreign key (question_id) references questions (id)
);

create table score
(
    id      int auto_increment
        primary key,
    user_id int          null,
    quiz_id int          null,
    Score   varchar(255) null,
    date    varchar(255) null,
    constraint score_quizzes__fk
        foreign key (quiz_id) references quizzes (id),
    constraint score_users_id_fk
        foreign key (user_id) references users (id)
);