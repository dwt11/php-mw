<?php  exit();
/*
Page: /salary/salary_add.php
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '434,430 LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT salary_empid FROM `dede_salary` where salary_hy='2015-01-11' and salary_empid =419,434,430 LIMIT 0,1;</font>
Date: 2015-01-11 20:36:28
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='259') LIMIT 0,1;</font>
Date: 2015-01-30 10:32:28
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name,dep_topid,dep_id FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='259') LIMIT 0,1;</font>
Date: 2015-01-30 10:44:58
*/
?>
<?php  exit();
/*
Page: /integral/integral_guizhe.php?keyword=&integral_class=a&imageField=%CB%D1%CB%F7
Error: Unknown column 'integral_class' in 'where clause' <br />Error sql: <font color='red'>Select *  From `dede_integral_guizhe`   where 1=1  and  integral_class = 'a'   order by gz_class asc, gz_id asc   </font>
Date: 2015-01-30 11:17:39
*/
?>
<?php  exit();
/*
Page: /integral/integral_guizhe.php?keyword=&integral_class=a&imageField=%CB%D1%CB%F7
Error: Unknown column 'integral_class' in 'where clause' <br />Error sql: <font color='red'>Select *  From `dede_integral_guizhe`   where 1=1  and  integral_class = 'a'   order by gz_class asc, gz_id asc    LIMIT 0,25</font>
Date: 2015-01-30 11:17:39
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 0,20</font>
Date: 2015-01-30 11:48:43
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 20,20</font>
Date: 2015-01-30 11:48:48
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 40,20</font>
Date: 2015-01-30 11:48:53
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 60,20</font>
Date: 2015-01-30 11:48:58
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 80,20</font>
Date: 2015-01-30 11:49:03
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=$class
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
				' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = $class  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 100,20</font>
Date: 2015-01-30 11:49:08
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 0,20</font>
Date: 2015-01-30 11:49:13
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 20,20</font>
Date: 2015-01-30 11:49:18
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 40,20</font>
Date: 2015-01-30 11:49:23
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 60,20</font>
Date: 2015-01-30 11:49:28
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 80,20</font>
Date: 2015-01-30 11:49:33
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 100,20</font>
Date: 2015-01-30 11:49:38
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 120,20</font>
Date: 2015-01-30 11:49:43
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 140,20</font>
Date: 2015-01-30 11:49:48
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					tota' at line 26 <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
					inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 160,20</font>
Date: 2015-01-30 11:49:53
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: Unknown column 'a' in 'where clause' <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
				and 	inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 0,20</font>
Date: 2015-01-30 11:49:57
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: Unknown column 'a' in 'where clause' <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
				and 	inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 20,20</font>
Date: 2015-01-30 11:50:02
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=a
Error: Unknown column 'a' in 'where clause' <br />Error sql: <font color='red'>SELECT
	emp_code,
	emp_dep,
	emp_realname,
	emp_id,
	totalfz,
	rowno
FROM
	(#4 将前三步的查询结果 供此括号外的查询使用,查询当前部门合集的所有人
		SELECT
			*,@rownumb :=@rownumb + 1 AS ROWno  #3排序加1
		FROM
			(SELECT @rownumb := 0) rownumb, #2获取出积分排序后,使用此句将排序号归0
			(#1此括号内,联合查询获取所有的员工的积分合计(where处可加月份限制),以合计后的积分排序
				SELECT
					emp.emp_code,
					emp.emp_dep,
					emp.emp_realname,
					emp_id,
					IFNULL(SUM(inl.integral_fz), 0) AS totalfz
				FROM
					dede_emp emp
				LEFT JOIN dede_integral inl ON emp.emp_id = inl.integral_empid  and date_format(inl.integral_date, '%Y-%m') = '2015-01' 
				WHERE
					emp.emp_isdel = 0  
				and 	inl.integral_class = a  
				GROUP BY
					emp.emp_id
				ORDER BY
					totalfz DESC
			) allEmpInl

) b where emp_dep in (1,9,23,24,27,10,25,26,31,32,11,28,29,30,38,39,40,41,43,44,45,46) order by emp_dep LIMIT 40,20</font>
Date: 2015-01-30 11:50:07
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='626' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='626' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:08
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='645' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='645' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='425' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='425' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='429' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='429' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='412' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='412' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='423' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='423' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='638' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='638' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='409' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='409' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='420' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='420' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='431' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='431' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='417' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='417' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='433' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='433' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='427' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='427' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='424' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='424' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='428' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='428' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='410' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='410' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='415' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='415' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='416' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='416' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='629' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='629' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='418' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='418' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='458' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='458' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='421' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='421' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='414' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='414' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='419' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='419' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='430' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='430' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='434' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='434' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='432' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='432' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='442' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='442' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='457' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='457' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='460' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='460' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='438' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='438' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='435' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='435' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='455' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='455' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='459' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='459' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='453' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='453' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='447' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='447' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='443' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='443' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='439' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='439' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='445' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='445' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='440' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='440' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='451' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='451' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='437' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='437' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='454' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='454' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='436' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='436' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='456' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='456' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:11
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='446' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='446' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='449' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='449' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='450' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='450' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='426' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='426' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='452' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='452' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='569' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='569' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:12
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='444' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='444' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='448' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='448' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='599' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='599' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='598' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='598' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='588' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='588' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='593' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='593' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='597' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='597' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='596' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='596' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='589' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='589' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='586' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='586' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='603' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='603' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='591' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='591' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='600' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='600' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='601' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='601' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='643' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='643' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='590' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='590' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='594' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='594' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='587' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='587' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='592' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='592' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='604' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='604' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='602' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='602' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='387' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='387' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='386' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='386' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='407' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='407' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='385' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='385' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='404' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='404' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='394' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='394' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='631' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='631' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='402' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='402' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='396' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='396' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='401' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='401' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='389' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='389' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='390' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='390' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='392' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='392' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='397' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='397' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='384' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='384' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='398' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='398' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='405' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='405' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='406' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='406' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='408' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='408' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='403' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='403' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='391' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='391' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='395' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='395' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='399' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='399' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='388' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='388' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='393' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='393' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='473' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='473' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='479' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='479' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='461' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='461' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='483' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='483' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:21
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='495' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='495' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='500' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='500' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='630' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='630' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='506' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='506' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='493' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='493' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='492' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='492' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='504' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='504' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='505' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='505' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='508' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='508' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='486' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='486' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='490' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='490' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='499' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='499' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='488' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='488' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='503' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='503' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='496' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='496' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='497' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='497' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='485' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='485' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='494' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='494' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='553' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='553' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='566' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='566' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='555' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='555' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='558' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='558' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='632' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='632' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='562' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='562' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='564' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='564' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='561' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='561' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='567' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='567' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='557' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='557' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='639' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='639' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='559' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='559' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='563' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='563' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='635' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='635' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='565' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='565' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='552' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='552' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='554' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='554' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='560' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='560' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='568' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='568' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='549' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='549' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='536' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='536' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='546' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='546' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:31
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='550' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='550' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='543' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='543' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='540' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='540' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='548' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='548' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='535' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='535' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='551' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='551' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='533' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='533' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='547' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='547' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='542' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='542' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/trundle.php?class=
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and integral_empid='541' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT SUM(integral_fz) as totalfz FROM `dede_integral` where  and integral_empid='541' LIMIT 0,1;</font>
Date: 2015-01-31 10:01:32
*/
?>
<?php  exit();
/*
Page: /integral/integral_day.php
Error: Unknown column 'integral_yf' in 'where clause' <br />Error sql: <font color='red'>Select integral_empid  From `dede_integral`   where 1=1  and    date_format(integral_yf, '%Y-%m') = '2015-05'  and  integral_class = 'a'  group by integral_empid  order by integral_yf,integral_empid desc   </font>
Date: 2015-05-28 17:50:36
*/
?>
<?php  exit();
/*
Page: /integral/integral_day.php
Error: Unknown column 'integral_yf' in 'where clause' <br />Error sql: <font color='red'>Select integral_empid  From `dede_integral`   where 1=1  and    date_format(integral_yf, '%Y-%m') = '2015-05'  and  integral_class = 'a'  group by integral_empid  order by integral_yf,integral_empid desc    LIMIT 0,30</font>
Date: 2015-05-28 17:50:36
*/
?>
<?php  exit();
/*
Page: /integral/integral_day.php
Error: Unknown column 'integral_yf' in 'where clause' <br />Error sql: <font color='red'>Select integral_empid  From `dede_integral`   where 1=1  and    date_format(integral_yf, '%Y-%m') = '2015-05'  and  integral_class = 'a'  group by integral_empid  order by integral_yf,integral_empid desc   </font>
Date: 2015-05-28 17:58:46
*/
?>
<?php  exit();
/*
Page: /integral/integral_day.php
Error: Unknown column 'integral_yf' in 'where clause' <br />Error sql: <font color='red'>Select integral_empid  From `dede_integral`   where 1=1  and    date_format(integral_yf, '%Y-%m') = '2015-05'  and  integral_class = 'a'  group by integral_empid  order by integral_yf,integral_empid desc    LIMIT 0,30</font>
Date: 2015-05-28 17:58:46
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: Unknown column 'salary_empid' in 'field list' <br />Error sql: <font color='red'>Select salary_empid  From `dede_checkin`   where 1=1  and    date_format(kq_hw_emptime, '%Y-%m') = '2015-07'  group by kq_empid  order by kq_hw_emptime,kq_empid desc   </font>
Date: 2015-07-10 18:34:36
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: Unknown column 'salary_empid' in 'field list' <br />Error sql: <font color='red'>Select salary_empid  From `dede_checkin`   where 1=1  and    date_format(kq_hw_emptime, '%Y-%m') = '2015-07'  group by kq_empid  order by kq_hw_emptime,kq_empid desc    LIMIT 0,30</font>
Date: 2015-07-10 18:34:36
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1;</font>
Date: 2015-07-10 18:53:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where kq_zt=0 and  kq_empid= and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1;</font>
Date: 2015-07-10 18:54:32
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='314') LIMIT 0,1;</font>
Date: 2015-07-10 19:04:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='248') LIMIT 0,1;</font>
Date: 2015-07-10 19:04:43
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='105') LIMIT 0,1;</font>
Date: 2015-07-10 19:04:59
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='338') LIMIT 0,1;</font>
Date: 2015-07-10 19:05:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Subquery returns more than 1 row <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='223') LIMIT 0,1;</font>
Date: 2015-07-10 19:05:16
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='314') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='284') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='133') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='117') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='132') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='248') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='278') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='107') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='268') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='274') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='105') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='138') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='338') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='212') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='218') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='223') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='213') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='215') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='222') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='220') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='304') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='217') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='228') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:27
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='323') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:27
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='224') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:30
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='219') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:33
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='310') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:36
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='183') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:40
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='230') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:43
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: Unknown column 'emp_isdel' in 'where clause' <br />Error sql: <font color='red'>SELECT dep_name FROM `dede_emp_dep` where emp_isdel=0 and  dep_id=(SELECT emp_dep FROM `dede_emp` where emp_code='227') LIMIT 0,1;</font>
Date: 2015-07-10 19:07:46
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:02
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=314 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:05
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-10' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-11' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:06
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-12' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-13' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-14' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-15' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-16' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-17' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-18' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-19' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-20' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-21' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-22' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-23' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-24' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-25' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-26' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-27' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-28' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:08
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-29' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=284 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-30' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-01' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-02' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-03' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-04' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-05' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-06' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:09
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-07' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:10
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-08' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:10
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMI' at line 1 <br />Error sql: <font color='red'>SELECT count(*) as numb  FROM `dede_checkin` where  kq_zt=100   kq_hw_empcode=133 and date_format(kq_hw_emptime, '%Y-%m-%d') = '2015-06-09' LIMIT 0,1;</font>
Date: 2015-07-10 19:12:10
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: Server shutdown in progress <br />Error sql: <font color='red'>Select kq_hw_empcode  From `dede_checkin`   where 1=1  and  kq_hw_empcode in (select emp_code from dede_emp where emp_dep in (9,23,58,59,60,61,24,54,55,56,57,27,50,51,52,53))  and    date_format(kq_hw_emptime, '%Y-%m') = '2015-06'  group by kq_hw_empcode  order by kq_hw_emptime,kq_hw_empcode desc    LIMIT 0,30</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=58&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=58&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=58&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=58&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-06&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php?keyword=&date=2015-06&emp_dep=0&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /salary/salary_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:52:26
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: Server shutdown in progress <br />Error sql: <font color='red'>Select kq_hw_empcode  From `dede_checkin`   where 1=1  and  kq_hw_empcode in (select emp_code from dede_emp where emp_dep in (9,23,58,59,60,61,24,54,55,56,57,27,50,51,52,53))  and    date_format(kq_hw_emptime, '%Y-%m') = '2015-07'  group by kq_hw_empcode  order by kq_hw_emptime,kq_hw_empcode desc   </font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT * FROM `dede_emp_dep` WHERE dep_id='9' LIMIT 0,1;</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role,department_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role,department_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'> SELECT * FROM `dede_emp_dep`  WHERE 1=1  and dep_topid=0 ORDER BY dep_id ASC </font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>Select kq_hw_empcode  From `dede_checkin`   where 1=1  and  kq_hw_empcode in (select emp_code from dede_emp where emp_dep in (9,23,58,59,60,61,24,54,55,56,57,27,50,51,52,53))  and    date_format(kq_hw_emptime, '%Y-%m') = '2015-07'  group by kq_hw_empcode  order by kq_hw_emptime,kq_hw_empcode desc    LIMIT 0,30</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-10 19:55:39
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 20:26:30
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 20:26:30
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 20:26:35
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 20:26:35
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 20:27:03
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=9&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 20:27:04
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 20:27:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 20:27:07
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 21:28:47
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 21:28:47
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 21:28:48
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=27&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 21:28:48
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=1&imageField=%CB%D1%CB%F7
Error: Query was empty <br />Error sql: <font color='red'></font>
Date: 2015-07-10 21:28:56
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php?keyword=&date=2015-07&emp_dep=1&imageField=%CB%D1%CB%F7
Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIMIT 0,30' at line 1 <br />Error sql: <font color='red'> LIMIT 0,30</font>
Date: 2015-07-10 21:28:56
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: Server shutdown in progress <br />Error sql: <font color='red'>Select *  From `dede_checkin`   where 1=1  and  kq_hw_empcode in (select emp_code from dede_emp where emp_isdel=0 and emp_dep in (9,23,58,59,60,61,24,54,55,56,57,27,50,51,52,53))  order by kq_hw_emptime desc </font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT * FROM `dede_emp_dep` WHERE dep_id='9' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role,department_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role,department_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'> SELECT * FROM `dede_emp_dep`  WHERE 1=1  and dep_topid=0 ORDER BY dep_id ASC </font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php?keyword=&date=&emp_dep=9&imageField=%CB%D1%CB%F7
Error: MySQL server has gone away <br />Error sql: <font color='red'>Select *  From `dede_checkin`   where 1=1  and  kq_hw_empcode in (select emp_code from dede_emp where emp_isdel=0 and emp_dep in (9,23,58,59,60,61,24,54,55,56,57,27,50,51,52,53))  order by kq_hw_emptime desc  LIMIT 0,30</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_list.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='1001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2001'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT value FROM `dede_sys_sysconfig`  WHERE aid='2000'</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_day.php
Error: MySQL server has gone away <br />Error sql: <font color='red'>SELECT web_role FROM `dede_sys_admintype` WHERE CONCAT(`rank`)='10' LIMIT 0,1;</font>
Date: 2015-07-16 20:58:12
*/
?>
<?php  exit();
/*
Page: /checkin/c_input_1.php
Error: Table 'hwatt.kqz_card' doesn't exist <br />Error sql: <font color='red'>SELECT
	 count(*) as dd
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '2020-10'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID LIMIT 0,1;</font>
Date: 2020-10-27 15:41:19
*/
?>
<?php  exit();
/*
Page: /checkin/c_input_1.php
Error: Table 'hwatt.kqz_card' doesn't exist <br />Error sql: <font color='red'>SELECT
	count(*) AS dd
FROM
	dede_checkin
WHERE
	kq_hw_CARDID IN (
		SELECT
			c.Cardid
		FROM
			hwatt.kqz_card AS c,
			hwatt.kqz_employee AS e,
			hwatt.kqz_devinfo AS d
		WHERE
			date_format(CardTime, '%Y-%m') = '2020-10'
		AND c.EmployeeID = e.EmployeeID
		AND c.DevID = d.DevID
	) LIMIT 0,1;</font>
Date: 2020-10-27 15:41:19
*/
?>
<?php  exit();
/*
Page: /checkin/c_input_1.php
Error: Table 'hwatt.kqz_card' doesn't exist <br />Error sql: <font color='red'>SELECT
	c.Cardid,
	c.employeeid,
	c.cardtime,
	c.devid,
	e.employeecode,
	e.employeename,
	d.devname,
	d.ipaddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '2020-10'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID</font>
Date: 2020-10-27 15:41:19
*/
?>
<?php  exit();
/*
Page: /checkin/c_input_1.php
Error: Table 'hwatt.kqz_card' doesn't exist <br />Error sql: <font color='red'>SELECT
	c.Cardid,
	c.employeeid,
	c.cardtime,
	c.devid,
	e.employeecode,
	e.employeename,
	d.devname,
	d.ipaddress
FROM
	hwatt.kqz_card AS c,
	hwatt.kqz_employee AS e,
	hwatt.kqz_devinfo AS d
WHERE
	date_format(CardTime, '%Y-%m') = '2020-10'
AND c.EmployeeID = e.EmployeeID
AND c.DevID = d.DevID LIMIT 0,30</font>
Date: 2020-10-27 15:41:19
*/
?>
