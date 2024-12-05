-- 使用数据库  2211270144
use zhengxf_edu_sys;

-- 添加教师数据
insert into
    zhengxf_te (te_id, te_name, te_pwd, te_dep)
values
    (2005100046, '桂荣枝', md5('sziit'), 3),
    (2005100031, '李媛媛', md5('sziit'), 3),
    (2005100221, '秦文', md5('sziit'), 3),
    (2005100057, '刘星明', md5('sziit'), 3);

-- stu 学生信息
-- insert into
--     zhengxf_stu (stu_id, stu_name, stu_pwd, stu_class)
-- values
--     (2011210142, '张嘉峰', md5('123456'), 2),
--     (2203010201, '陈可云', md5('123456'), 2),
--     (2203010202, '陈伟豪', md5('123456'), 2),
--     (2203010204, '代桂红', md5('123456'), 2),
--     (2203010206, '郭凯嘉', md5('123456'), 2),
--     (2203010207, '侯健聪', md5('123456'), 2),
--     (2203010208, '胡咏鑫', md5('123456'), 2),
--     (2203010209, '黄妙屏', md5('123456'), 2),
--     (2203010210, '黄颂茹', md5('123456'), 2),
--     (2203010211, '黄芷娜', md5('123456'), 2),
--     (2203010212, '黄志翔', md5('123456'), 2),
--     (2203010213, '赖有彬', md5('123456'), 2),
--     (2203010214, '李洁莹', md5('123456'), 2),
--     (2203010216, '梁景华', md5('123456'), 2),
--     (2203010217, '梁少锋', md5('123456'), 2),
--     (2203010218, '林家熙', md5('123456'), 2),
--     (2203010219, '林俊红', md5('123456'), 2),
--     (2203010220, '刘林添', md5('123456'), 2),
--     (2203010221, '刘婉敏', md5('123456'), 2),
--     (2203010223, '罗文欣', md5('123456'), 2),
--     (2203010224, '潘鑫鹏', md5('123456'), 2),
--     (2203010225, '庞鸿宇', md5('123456'), 2),
--     (2203010226, '邱日堯', md5('123456'), 2),
--     (2203010227, '苏思仰', md5('123456'), 2),
--     (2203010228, '覃慧玲', md5('123456'), 2),
--     (2203010229, '滕林生', md5('123456'), 2),
--     (2203010230, '王炯烁', md5('123456'), 2),
--     (2203010231, '王铠伟', md5('123456'), 2),
--     (2203010233, '王应安', md5('123456'), 2),
--     (2203010234, '伟鲁予', md5('123456'), 2),
--     (2203010235, '文佳晟', md5('123456'), 2),
--     (2203010237, '谢腾琪', md5('123456'), 2),
--     (2203010238, '谢宇宏', md5('123456'), 2),
--     (2203010239, '徐怡亮', md5('123456'), 2),
--     (2203010240, '杨家琪', md5('123456'), 2),
--     (2203010241, '杨先钊', md5('123456'), 2),
--     (2203010242, '杨紫涵', md5('123456'), 2),
--     (2203010244, '张桂瑞', md5('123456'), 2),
--     (2203010245, '张伊楠', md5('123456'), 2),
--     (2203010246, '张子瑶', md5('123456'), 2),
--     (2203010247, '郑楚欣', md5('123456'), 2),
--     (2203010248, '郑秀芳', md5('123456'), 2),
--     (2203010249, '钟映乐', md5('123456'), 2),
--     (2211270142, '张和', md5('123456'), 2),
--     (2211270144, '郑鑫峰', md5('123456'), 2),
--     (2212040328, '邱依纯', md5('123456'), 2),
--     (2212130211, '邓淑贤', md5('123456'), 2),
--     (2213040234, '杨嘉详', md5('123456'), 2);