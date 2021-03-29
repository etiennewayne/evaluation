/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.17-MariaDB : Database - evaluation
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`evaluation` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `evaluation`;

/* Procedure structure for procedure `backup_report_faculty_rating_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `backup_report_faculty_rating_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `backup_report_faculty_rating_schedule`(vfaculty_code VARCHAR(20), vay_code VARCHAR(20))
BEGIN
	
    
	SET @total = 0;
	SET @no_courses = (SELECT COUNT(*) FROM registrar_gadtc.tblsched202 WHERE SchedInsCode = vfaculty_code);
	
	
    
	SELECT
		a.SchedCourse,
		a.SchedSubjCode, b.SubjName, b.SubjDesc, 
		TIME_FORMAT(a.SchedTimeFrm, '%h:%i %p') AS time_start,
		TIME_FORMAT(a.SchedTimeTo, '%h:%i %p') AS time_end, 
		a.SchedDays,
		a.SchedRoom,
		
		
		(
			SELECT COUNT(*) FROM (SELECT * FROM registrar_gadtc.tblenrdtl202 JOIN 
				(SELECT * FROM registrar_gadtc.tblsched202 WHERE SchedInsCode = vfaculty_code) AS tempsched202 ON tblenrdtl202.EnrSchedCode = tempsched202.SchedCode) AS temp_raters
		) AS total_raters,
		
		(
			SELECT COUNT(*) FROM (SELECT * FROM evaluation.ratings JOIN 
				(SELECT * FROM registrar_gadtc.tblsched202 WHERE SchedInsCode = vfaculty_code) AS tempsched202 ON evaluation.ratings.schedule_code = tempsched202.SchedCode) AS temp_raters
		) AS total_rated,
		
		
		(	#sum of ratings per schedule
			SELECT SUM(rate) FROM evaluation.ratings r JOIN evaluation.ratings_rate rr ON r.rating_id = rr.rating_id WHERE rr.schedule_code = a.SchedCode
			AND r.ay_code = vay_code
		) AS sum_rating,
		(
			SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code
		) AS no_of_criteria,
		
		(
			#no of students in every course
		SELECT COUNT(*) FROM registrar_gadtc.tblsched202
		    JOIN registrar_gadtc.tblenrdtl202 ON registrar_gadtc.tblsched202.SchedCode = registrar_gadtc.tblenrdtl202.EnrSchedCode
		    WHERE registrar_gadtc.tblsched202.SchedCode = a.SchedCode
		) AS no_students,
		(
			#no of raters (student who submit ratings only)
			SELECT COUNT(*) FROM evaluation.ratings WHERE schedule_code = a.SchedCode
			
		) AS no_of_raters,
		
		a.SchedCode,
		
		(
			#round((select sum_rating) / ((select no_of_criteria) * (select no_of_raters)), 2)
		(SELECT sum_rating) / (SELECT no_of_criteria) / (SELECT no_of_raters)
		)AS avg_rating,
		
		
		#this is not dynamic anymore. Update this when AY change
		
		(	
			(SELECT SUM(rate) FROM evaluation.ratings_rate
			JOIN evaluation.criteria ON ratings_rate.criterion_id = criteria.criterion_id
			WHERE criteria.category_id = 11 AND ratings_rate.schedule_code = a.SchedCode)
			/
			(SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code AND criteria.category_id = 11)
			/
			(SELECT no_of_raters)
		) AS 'course_design',
		
		(
			(SELECT SUM(rate) FROM evaluation.ratings_rate
			JOIN evaluation.criteria ON ratings_rate.criterion_id = criteria.criterion_id
			WHERE criteria.category_id = 12 AND ratings_rate.schedule_code = a.SchedCode)
			/
			(SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code AND criteria.category_id = 12)
			/
			(SELECT no_of_raters)
		) AS 'content',
		
		(
			(SELECT SUM(rate) FROM evaluation.ratings_rate
			JOIN evaluation.criteria ON ratings_rate.criterion_id = criteria.criterion_id
			WHERE criteria.category_id = 13 AND ratings_rate.schedule_code = a.SchedCode)
			/
			(SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code AND criteria.category_id = 13)
			/
			(SELECT no_of_raters)
		) AS 'process',
		
		
		(
			(SELECT SUM(rate) FROM evaluation.ratings_rate
			JOIN evaluation.criteria ON ratings_rate.criterion_id = criteria.criterion_id
			WHERE criteria.category_id = 14 AND ratings_rate.schedule_code = a.SchedCode)
			/
			(SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code AND criteria.category_id = 14)
			/
			(SELECT no_of_raters)
		) AS 'outcomes',
		
		(
			(SELECT SUM(rate) FROM evaluation.ratings_rate
			JOIN evaluation.criteria ON ratings_rate.criterion_id = criteria.criterion_id
			WHERE criteria.category_id = 15 AND ratings_rate.schedule_code = a.SchedCode)
			/
			(SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code AND criteria.category_id = 15)
			/
			(SELECT no_of_raters)
		) AS 'personal_quality',
		
		(
			(SELECT course_design) + (SELECT content) + (SELECT PROCESS) + (SELECT outcomes) + (SELECT personal_quality)
		) AS sum_category,
		(SELECT COUNT(*) FROM evaluation.categories WHERE categories.ay_code = vay_code) AS count_category,
		((SELECT sum_category) / (SELECT count_category)) AS avg_category,
		
		(
			SELECT ay_desc FROM evaluation.ay WHERE ay.active = 1
		)AS ay_desc,
		
		(
			SELECT legend FROM evaluation.legends
			WHERE 
			(SELECT avg_category)
			BETWEEN start_value AND end_value ORDER BY start_value DESC LIMIT 1
		) AS legend,
    
		c.InsLName, c.InsFName, c.InsMName, c.InsDept
    
	#academic year
    
	FROM registrar_gadtc.tblsched202 a
	JOIN registrar_gadtc.`tblsubject` b ON a.SchedSubjCode  = b.SubjCode
	JOIN registrar_gadtc.`tblins` c ON a.SchedInsCode = c.InsCode
	WHERE a.SchedInsCode = vfaculty_code;
	
	
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `proc_studentrate_log` */

/*!50003 DROP PROCEDURE IF EXISTS  `proc_studentrate_log` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_studentrate_log`(vay_id varchar(20))
BEGIN
    
	SELECT a.user_id, users.username, users.lname, 
	users.fname, users.mname, users.program_id, programs.program_code,
	programs.program_desc,
	 a.schedule_id, 
	 b.ay_id, 
	 ay.ay_code, 
	 ay.ay_desc,
		CASE WHEN c.rate IS NULL THEN 'NOT RATED'
		ELSE c.rate END AS 'rate' 
	FROM enrolees a
	JOIN schedules b ON a.schedule_id = b.schedule_id
	JOIN ay ON ay.ay_id = b.ay_id
	JOIN users ON users.user_id = a.user_id
	JOIN programs ON users.program_id = programs.program_id
	LEFT JOIN 
		(SELECT schedule_id, 
		    user_id, 
		    SUM(rate) AS rate 
		    FROM ratings 
		    GROUP BY user_id, schedule_id
		 ) AS c ON a.user_id = c.user_id AND a.schedule_id = c.schedule_id
	where b.ay_id = vay_id;
   
    END */$$
DELIMITER ;

/* Procedure structure for procedure `proc_student_rate_monitoring` */

/*!50003 DROP PROCEDURE IF EXISTS  `proc_student_rate_monitoring` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_student_rate_monitoring`(vayid int)
BEGIN
    
SELECT
a.user_id, 
a.username, a.lname, a.fname, a.mname,
a.sex, a.program_id, b.program_code, b.program_desc,
d.ay_id, e.ay_code, e.ay_desc,
c.schedule_id,
COUNT(c.schedule_id) AS 'no_of_course',
COALESCE(f.no_rated_course, 0) AS 'no_rated_course_coalesce',
COUNT(c.schedule_id) - (SELECT no_rated_course_coalesce) AS 'no_course_tobe_rated',
CASE WHEN (COUNT(c.schedule_id) - (SELECT no_rated_course_coalesce)) > 0 THEN 'INCOMPLETE' ELSE 'COMPLETE' END AS 'rate_status'
FROM
users a JOIN
programs b ON a.program_id= b.program_id
JOIN enrolees c ON a.user_id = c.user_id
JOIN schedules d ON c.schedule_id = d.schedule_id
JOIN ay e ON d.ay_id=e.ay_id
LEFT JOIN (
	SELECT user_id, COUNT(schedule_id) AS 'no_rated_course' FROM (SELECT a.user_id, a.schedule_id FROM ratings a
	GROUP BY a.user_id, a.schedule_id) AS tbl_a GROUP BY tbl_a.user_id
) AS f ON a.user_id = f.user_id
WHERE e.ay_id = vayid
GROUP BY a.user_id;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `proc_viewrating_perstudent` */

/*!50003 DROP PROCEDURE IF EXISTS  `proc_viewrating_perstudent` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_viewrating_perstudent`(vstudent_id VARCHAR(20), vsantarita_aycode int, vschedule_code varchar(20))
BEGIN
SELECT
a.rating_id, a.student_id, g.StudLName, g.StudFName, g.StudMName,
a.schedule_code,a.remark,
b.criterion_id, c.order_no,
c.category_id, d.category, 
f.InsCode, f.InsLName AS InsLName, f.InsFName AS InsFName, f.InsMName AS InsMName,
i.EnrCourse, h.SubjName, h.SubjDesc,
(
	SELECT COUNT(*) 
	FROM evaluation.criteria 
	WHERE evaluation.criteria.category_id = c.category_id 
	AND criteria.ay_code = vsantarita_aycode
) as count_criteria,
SUM(b.rate) AS 'sumrate',
h.SubjName, h.SubjDesc,
round(
SUM(b.rate) / 
(select count_criteria), 2)
AS n_rating
FROM
evaluation.ratings a
JOIN evaluation.ratings_rate b ON a.rating_id = b.rating_id
JOIN evaluation.criteria c ON b.criterion_id = c.criterion_id
JOIN evaluation.categories d ON c.category_id = d.category_id
JOIN registrar_gadtc.tblsched202 e ON a.schedule_code = e.SchedCode
JOIN registrar_gadtc.tblins f ON e.SchedInsCode = f.InsCode
JOIN registrar_gadtc.tblstudhinfo g ON a.student_id = g.StudID
JOIN registrar_gadtc.tblsubject h on e.SchedSubjCode = h.SubjCode
join registrar_gadtc.tblenr202 i on a.student_id = i.EnrIDNum
WHERE 
a.schedule_code = vschedule_code
AND a.student_id = vstudent_id
GROUP BY c.category_id
ORDER BY d.order_no ASC;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `proc_view_noratecourses` */

/*!50003 DROP PROCEDURE IF EXISTS  `proc_view_noratecourses` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_view_noratecourses`(vstudent_id VARCHAR(30))
BEGIN
    
    SELECT * FROM (
    SELECT a.EnrIDNum, c.StudLName, 
	c.StudFName, c.StudMName, 
	 a.EnrSchedCode, 
	 d.SubjName,
	 d.SubjDesc,
	 d.SubjClass,
		CASE WHEN e.rate IS NULL THEN 'NO RATE'
		ELSE e.rate END AS 'rate' 
	FROM registrar_gadtc.tblenrdtl202 a
	JOIN registrar_gadtc.tblsched202 b ON a.EnrSchedCode = b.SchedCode
	JOIN registrar_gadtc.tblstudhinfo c ON  c.StudID = a.EnrIDNum
	JOIN registrar_gadtc.tblsubject d ON d.SubjCOde = b.SchedSubjCode
	LEFT JOIN 
		(SELECT schedule_code, 
		    student_id, 
		    SUM(rate) AS rate 
		    FROM evaluation.ratings_rate
		    GROUP BY student_id, schedule_code
		 ) AS e ON a.EnrIDNum = e.student_id AND a.EnrSchedCode = e.schedule_code
	WHERE a.EnrIDNum = vstudent_id ) AS tbl_a
WHERE rate = 'NO RATE';
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `report_comments` */

/*!50003 DROP PROCEDURE IF EXISTS  `report_comments` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `report_comments`(vfaculty_code varchar(20), vaycode varchar(20))
BEGIN
select a.rating_id,
a.schedule_code, trim(a.remark) as remark, c.InsLName, c.InsFName, c.InsMName from evaluation.ratings a
join registrar_gadtc.tblsched202 b on a.schedule_code = b.SchedCode and b.SchedSubjSet = (select `set` from sets where active = 1)
join registrar_gadtc.tblins c on b.SchedInsCode = c.InsCode
where b.SchedInsCode = vfaculty_code
and a.ay_code=vaycode
and remark is not null;
END */$$
DELIMITER ;

/* Procedure structure for procedure `report_faculty_rating` */

/*!50003 DROP PROCEDURE IF EXISTS  `report_faculty_rating` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `report_faculty_rating`(vfaculty_code varchar(20), vay_code varchar(10))
BEGIN
SET @student_raters = (SELECT COUNT(*) FROM registrar_gadtc.tblsched202 a
JOIN registrar_gadtc.tblins b ON a.SchedInsCode = b.InsCode
JOIN registrar_gadtc.tblenrdtl202 c ON a.SchedCode = c.EnrSchedCode
WHERE a.SchedInsCode = vfaculty_code);
SET @student_rated = (SELECT COUNT(*) FROM registrar_gadtc.tblsched202 a
JOIN registrar_gadtc.tblins b ON a.SchedInsCode = b.InsCode
JOIN evaluation.ratings c ON a.SchedCode = c.schedule_code
WHERE a.SchedInsCode = vfaculty_code);
SET @no_of_criteria = (SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code);
SET @sum_rating = (SELECT SUM(c.rate) FROM registrar_gadtc.tblsched202 a
JOIN registrar_gadtc.tblins b ON a.SchedInsCode = b.InsCode
LEFT JOIN evaluation.ratings_rate c ON a.SchedCode = c.schedule_code
WHERE a.SchedInsCode = vfaculty_code);
SET @remarks = (SELECT GROUP_CONCAT(TRIM(c.remark) SEPARATOR ' ** ') FROM registrar_gadtc.tblsched202 a
JOIN registrar_gadtc.tblins b ON a.SchedInsCode = b.InsCode
JOIN evaluation.ratings c ON a.SchedInsCode = c.schedule_code
WHERE a.SchedInsCode = vfaculty_code AND c.remark IS NOT NULL  GROUP BY a.SchedInsCode);
SELECT registrar_gadtc.tblins.InsCode,
registrar_gadtc.tblins.InsLName,
registrar_gadtc.tblins.InsFName,
registrar_gadtc.tblins.InsMName,
@student_raters AS 'raters', 
@student_rated AS 'rated', 
@no_of_criteria 'no_criteria',
@sum_rating AS 'sum_rating',
(
	ROUND((SELECT sum_rating) / (SELECT rated) / (SELECT no_criteria), 2)
) AS avg_rating,
(
	SELECT legend FROM evaluation.legends
	WHERE 
	(SELECT avg_rating)
	BETWEEN start_value AND end_value ORDER BY start_value DESC LIMIT 1
) AS legend,
@remarks AS remarks
FROM registrar_gadtc.tblins WHERE InsCode = vfaculty_code;
END */$$
DELIMITER ;

/* Procedure structure for procedure `report_faculty_rating_schedule` */

/*!50003 DROP PROCEDURE IF EXISTS  `report_faculty_rating_schedule` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `report_faculty_rating_schedule`(vfaculty_code varchar(20), vay_code varchar(20))
BEGIN
	
    
	SET @total = 0;
	SET @no_courses = (SELECT COUNT(*) FROM registrar_gadtc.tblsched202 WHERE SchedInsCode = vfaculty_code);
	
	
    
	SELECT
		a.SchedCourse,
		a.SchedSubjCode, b.SubjName, b.SubjDesc, 
		TIME_FORMAT(a.SchedTimeFrm, '%h:%i %p') AS time_start,
		TIME_FORMAT(a.SchedTimeTo, '%h:%i %p') AS time_end, 
		a.SchedDays,
		a.SchedRoom,
		
		
		(
			select count(*) from (select * from registrar_gadtc.tblenrdtl202 join 
				(select * from registrar_gadtc.tblsched202 where SchedInsCode = vfaculty_code) as tempsched202 on tblenrdtl202.EnrSchedCode = tempsched202.SchedCode) as temp_raters
		) as total_raters,
		
		(
			SELECT COUNT(*) FROM (SELECT * FROM evaluation.ratings JOIN 
				(SELECT * FROM registrar_gadtc.tblsched202 WHERE SchedInsCode = vfaculty_code) AS tempsched202 ON evaluation.ratings.schedule_code = tempsched202.SchedCode) AS temp_raters
		) AS total_rated,
		
		
		(	#sum of ratings per schedule
			SELECT SUM(rate) FROM evaluation.ratings r JOIN evaluation.ratings_rate rr ON r.rating_id = rr.rating_id WHERE rr.schedule_code = a.SchedCode
			AND r.ay_code = vay_code
		) AS sum_rating,
		(
			SELECT COUNT(*) FROM evaluation.criteria WHERE ay_code = vay_code
		) AS no_of_criteria,
		
		(
			#no of students in every course
		SELECT COUNT(*) FROM registrar_gadtc.tblsched202
		    JOIN registrar_gadtc.tblenrdtl202 ON registrar_gadtc.tblsched202.SchedCode = registrar_gadtc.tblenrdtl202.EnrSchedCode
		    WHERE registrar_gadtc.tblsched202.SchedCode = a.SchedCode
		) AS no_students,
		(
			#no of raters (student who submit ratings only)
			SELECT COUNT(*) FROM evaluation.ratings WHERE schedule_code = a.SchedCode
			
		) AS no_of_raters,
		
		a.SchedCode,
		(
			select ay_desc from evaluation.ay where ay.active = 1
		)as ay_desc,
    
		c.InsLName, c.InsFName, c.InsMName, c.InsDept
    
	#academic year
    
	FROM registrar_gadtc.tblsched202 a
	JOIN registrar_gadtc.`tblsubject` b ON a.SchedSubjCode  = b.SubjCode and a.SchedSubjSet = (select `set` from sets where active = 1)
	JOIN registrar_gadtc.`tblins` c ON a.SchedInsCode = c.InsCode
	WHERE a.SchedInsCode = vfaculty_code;
	
	
	
    END */$$
DELIMITER ;

/* Procedure structure for procedure `report_rating_per_category` */

/*!50003 DROP PROCEDURE IF EXISTS  `report_rating_per_category` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `report_rating_per_category`(vfaculty_code varchar(20), vay_code varchar(20))
BEGIN
set @total_avg = (
select round(sum(avrg)/count(*),2) as total_avrg from (
		SELECT *,
		round(ratings / no_criteria,2) AS avrg
		FROM (SELECT
		c.category_id,
		d.category,
		d.ay_code,
		COUNT(c.criterion_id) AS no_criteria,
		SUM(b.rate) AS ratings,
		e.InsCode, e.InsLName, e.InsFName, e.InsMName
		FROM registrar_gadtc.tblsched202 a
		JOIN evaluation.ratings_rate b ON a.SchedCode = b.schedule_code and a.SchedSubjSet = (select `set` from sets where active = 1)
		JOIN evaluation.criteria c ON b.criterion_id = c.criterion_id
		JOIN evaluation.categories d ON c.category_id = d.category_id
		JOIN registrar_gadtc.tblins e ON a.SchedInsCode = e.InsCode
		WHERE SchedInsCode = vfaculty_code AND d.ay_code = vay_code
		GROUP BY c.category_id 
		ORDER BY d.order_no ASC) AS tblrating
	)as tbl1
);



SELECT *,
round(ratings / no_criteria,2) AS avrg,
@total_avg as 'total_avg',
(
			SELECT legend FROM evaluation.legends
			WHERE 
			(SELECT total_avg)
			BETWEEN start_value AND end_value ORDER BY start_value DESC LIMIT 1
) AS legend
		
FROM (SELECT
c.category_id,
d.category,
d.ay_code,
COUNT(c.criterion_id) AS no_criteria,
SUM(b.rate) AS ratings,
e.InsCode, e.InsLName, e.InsFName, e.InsMName
FROM registrar_gadtc.tblsched202 a
JOIN evaluation.ratings_rate b ON a.SchedCode = b.schedule_code
JOIN evaluation.criteria c ON b.criterion_id = c.criterion_id
JOIN evaluation.categories d ON c.category_id = d.category_id
JOIN registrar_gadtc.tblins e ON a.SchedInsCode = e.InsCode
WHERE SchedInsCode = vfaculty_code AND d.ay_code = vay_code
GROUP BY c.category_id 
ORDER BY d.order_no ASC) AS tblrating;
END */$$
DELIMITER ;

/* Procedure structure for procedure `test` */

/*!50003 DROP PROCEDURE IF EXISTS  `test` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`eshen`@`%` PROCEDURE `test`()
BEGIN
	select 'test';
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
