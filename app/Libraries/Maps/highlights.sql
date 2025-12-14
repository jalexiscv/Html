CREATE TABLE IF NOT EXISTS `highlights`
(
    `id`
    int
(
    10
) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar
(
    255
) NOT NULL DEFAULT '',
    `lat` decimal
(
    10,
    8
) NOT NULL DEFAULT '0.00000000',
    `lng` decimal
(
    11,
    8
) NOT NULL DEFAULT '0.00000000',
    PRIMARY KEY
(
    `id`
)
    );

INSERT INTO `highlights` (`id`, `name`, `lat`, `lng`)
VALUES (1, 'Eifel Tower', '48.85827800', '2.29425400'),
       (2, 'The Louvre', '48.86404110', '2.33604440'),
       (3, 'Musee d''Orsay', '48.86018100', '2.32496480'),
       (4, 'Jardin du Luxembourg', '48.84695290', '2.33728500'),
       (5, 'Promenade Plantee', '48.85661400', '2.35222190');