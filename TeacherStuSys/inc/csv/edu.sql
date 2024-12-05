-- 创建数据库 2211270144
drop database if exists zhengxf_edu_sys;
create database zhengxf_edu_sys default charset utf8 collate utf8_general_ci;

-- 使用数据库
use zhengxf_edu_sys;

-- 系部表
create table zhengxf_dep (
	d_id int unsigned auto_increment primary key,
	d_name varchar(20) not null
) engine = innodb default charset utf8;

-- 专业表
create table zhengxf_major (
	m_id int unsigned auto_increment primary key,
	m_name varchar(30) not null,
	m_length int(1),
	m_dep int unsigned,
	foreign key (m_dep) references zhengxf_dep(d_id) on update cascade
) engine = innodb default charset utf8;

-- 教师表
create table zhengxf_te (
	te_id int(10) unsigned not null primary key,
	te_name varchar(10),
	te_pwd char(32),
	te_dep int unsigned,
	foreign key (te_dep) references zhengxf_dep(d_id) on update cascade
) engine = innodb default charset utf8;

-- 创建班级表
create table zhengxf_class (
	cl_id int unsigned auto_increment primary key,
	cl_name varchar(15),
	cl_year int(4) unsigned,
	cl_major int unsigned,
	foreign key (cl_major) references zhengxf_major(m_id) on update cascade
) engine = innodb default charset utf8;

-- 创建学生表
create table zhengxf_stu (
	stu_id bigint(10) unsigned not null primary key,
	stu_name varchar(10),
	stu_pwd char(32),
	stu_class int unsigned,
	foreign key (stu_class) references zhengxf_class(cl_id) on update cascade -- on delete cascade
) engine = innodb default charset utf8;

-- 课程表
create table zhengxf_course (
	c_id int auto_increment primary key,
	c_code int(8) unsigned,
	-- 编码
	c_name varchar(20),
	c_grade int(4) unsigned,
	-- 年级
	c_term int(1) unsigned,
	-- 学期
	c_point float(3, 1),
	-- 学分
	c_weekh float(3, 1),
	-- 周学时
	c_seweek char(5),
	-- 起始周
	c_totalh float(4, 1),
	-- 总学时
	c_type varchar(6),
	c_exam varchar(10),
	-- 考核方式
	c_dep int unsigned,
	foreign key (c_dep) references zhengxf_dep(d_id) on update cascade
) engine = innodb default charset utf8;

-- 教学任务
create table zhengxf_task (
	ta_id int unsigned auto_increment primary key,
	ta_teid int(10) unsigned,
	-- 工号
	ta_cid int,
	-- 课程自动编号
	ta_class int unsigned,
	ta_term int(10) unsigned,
	ta_time varchar(8),
	ta_room char(20),
	foreign key (ta_teid) references zhengxf_te(te_id) on update cascade,
	foreign key (ta_cid) references zhengxf_course(c_id) on update cascade,
	foreign key (ta_class) references zhengxf_class(cl_id) on update cascade
) engine = innodb default charset utf8;

-- 成绩表
create table zhengxf_score (
	sc_id int auto_increment primary key,
	sc_taskid int unsigned,
	sc_stuid bigint(10) unsigned,
	sc_normal float(5, 2),
	sc_lab float(5, 2),
	sc_midterm float(5, 2),
	sc_final float(5, 2),
	sc_overall float(5, 2),
	sc_makeup float(5, 2),
	sc_again float(5, 2),
	foreign key (sc_taskid) references zhengxf_task(ta_id) on update cascade,
	foreign key (sc_stuid) references zhengxf_stu(stu_id) on update cascade
) engine = innodb default charset utf8;

-- 添加字段
alter table zhengxf_te add te_pic char(27) default 'log-form01.png';
alter table zhengxf_stu add stu_pic char(27) default 'log-form01.png';