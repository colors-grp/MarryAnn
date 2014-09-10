--
-- Triggers `user_category`
--
DROP TRIGGER IF EXISTS `update_scoreboards`;
DELIMITER //
CREATE TRIGGER `update_scoreboards` AFTER UPDATE ON `user_category`
 FOR EACH ROW IF (SELECT active_table FROM active_scoreboard WHERE category_id = 1) = 1  THEN
UPDATE sallySyamak_scoreboard_2 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 1;
UPDATE mosalslat_scoreboard_2 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 2;
UPDATE manElQatel_scoreboard_2 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 3;
UPDATE shahryar_scoreboard_2 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 4;
ELSE
UPDATE sallySyamak_scoreboard_1 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 1;
UPDATE mosalslat_scoreboard_1 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 2;
UPDATE manElQatel_scoreboard_1 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 3;
UPDATE shahryar_scoreboard_1 SET score = NEW.score WHERE user_id = NEW.user_id and NEW.category_id = 4;
END IF
//
DELIMITER ;


DELIMITER $$
--
-- Events
--
DROP EVENT `update_scoreboards`$$
CREATE DEFINER=`hitsevey`@`localhost` EVENT `update_scoreboards` ON SCHEDULE EVERY 20 MINUTE STARTS '2014-06-28 23:41:57' ON COMPLETION NOT PRESERVE ENABLE DO IF (SELECT active_table FROM active_scoreboard WHERE category_id = 1) = 1  THEN

TRUNCATE TABLE sallySyamak_scoreboard;
INSERT INTO sallySyamak_scoreboard (SELECT * FROM sallySyamak_scoreboard_2);

TRUNCATE TABLE sallySyamak_scoreboard_2;
TRUNCATE TABLE mosalslat_scoreboard_2;
TRUNCATE TABLE manElQatel_scoreboard_2;
TRUNCATE TABLE shahryar_scoreboard_2;

SET @a:=0;
INSERT INTO sallySyamak_scoreboard_2 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 1 order by score DESC);

SET @a:=0;
INSERT INTO mosalslat_scoreboard_2 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 2 order by score DESC);

SET @a:=0;
INSERT INTO manElQatel_scoreboard_2 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 3 order by score DESC);


SET @a:=0;
INSERT INTO shahryar_scoreboard_2 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 4 order by score DESC);



UPDATE `sallySyamak_scoreboard_2` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `mosalslat_scoreboard_2` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `manElQatel_scoreboard_2` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `shahryar_scoreboard_2` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);


UPDATE active_scoreboard SET active_table = 2;

ELSE

TRUNCATE TABLE sallySyamak_scoreboard;
INSERT INTO sallySyamak_scoreboard (SELECT * FROM sallySyamak_scoreboard_1);

TRUNCATE TABLE sallySyamak_scoreboard_1;
TRUNCATE TABLE mosalslat_scoreboard_1;
TRUNCATE TABLE manElQatel_scoreboard_1;
TRUNCATE TABLE shahryar_scoreboard_1;

SET @a:=0;
INSERT INTO sallySyamak_scoreboard_1 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 1 order by score DESC);

SET @a:=0;
INSERT INTO mosalslat_scoreboard_1 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 2 order by score DESC);

SET @a:=0;
INSERT INTO manElQatel_scoreboard_1 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 3 order by score DESC);


SET @a:=0;
INSERT INTO shahryar_scoreboard_1 (SELECT @a:=@a+1 AS 'rank', user_id, '' AS user_name, score, 'n' AS 'change' FROM `user_category` where category_id = 4 order by score DESC);



UPDATE `sallySyamak_scoreboard_1` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `mosalslat_scoreboard_1` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `manElQatel_scoreboard_1` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);

UPDATE `shahryar_scoreboard_1` AS ss2 SET user_name = (SELECT user_name FROM `sallySyamak_scoreboard` AS ss1 where ss2.user_id = ss1.user_id);


UPDATE active_scoreboard SET active_table = 1;

END IF$$

DELIMITER ;