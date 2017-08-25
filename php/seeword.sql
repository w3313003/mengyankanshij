-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-29 01:05:02
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seeword`
--

-- --------------------------------------------------------

--
-- 表的结构 `see_apply`
--

CREATE TABLE `see_apply` (
  `id` int(255) NOT NULL,
  `videoid` int(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `videoname` varchar(255) NOT NULL,
  `ordersum` varchar(255) NOT NULL,
  `videoprice` double NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `time` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_apply`
--

INSERT INTO `see_apply` (`id`, `videoid`, `phone`, `videoname`, `ordersum`, `videoprice`, `status`, `time`) VALUES
(1, 2, '15665438551', '齐天大圣', '144267070220170726150242', 1, 1, ''),
(2, 7, '15665438551', '齐天大圣', '144267070220170726150243', 1, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `see_banner`
--

CREATE TABLE `see_banner` (
  `id` int(255) NOT NULL,
  `bannerurl` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_banner`
--

INSERT INTO `see_banner` (`id`, `bannerurl`, `status`) VALUES
(1, 'http://www.test.com/uploads/20170728/267f6e5df75c21981ee0e150bbfaff92.gif', 1),
(2, 'http://www.test.com/uploads/20170728/ddbc81c7acddcb05bce5ade928682a9d.png', 1),
(3, 'http://www.test.com/static/admin/images/banner.png', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_barrage`
--

CREATE TABLE `see_barrage` (
  `id` int(32) NOT NULL,
  `barrage` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '0:免费视频1:收费',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1显示0不显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_barrage`
--

INSERT INTO `see_barrage` (`id`, `barrage`, `type`, `status`) VALUES
(1, '很抱歉，课程类视频只能免费观看前30秒,剩余时长需要您购买才能观看1', 1, 1),
(2, '您的免费观看视频次数已用完，再邀请好友获得观看次数', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_free`
--

CREATE TABLE `see_free` (
  `id` int(12) NOT NULL,
  `base` double NOT NULL,
  `givefree` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赠送金额';

--
-- 转存表中的数据 `see_free`
--

INSERT INTO `see_free` (`id`, `base`, `givefree`) VALUES
(1, 100, 20),
(2, 200, 30),
(3, 300, 50);

-- --------------------------------------------------------

--
-- 表的结构 `see_manage`
--

CREATE TABLE `see_manage` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_manage`
--

INSERT INTO `see_manage` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_rebate`
--

CREATE TABLE `see_rebate` (
  `first` int(10) NOT NULL,
  `second` int(10) NOT NULL,
  `id` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='返利';

--
-- 转存表中的数据 `see_rebate`
--

INSERT INTO `see_rebate` (`first`, `second`, `id`) VALUES
(20, 10, 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_recharge`
--

CREATE TABLE `see_recharge` (
  `id` int(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `ordernum` varchar(255) NOT NULL,
  `videoprice` double NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `time` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `see_series`
--

CREATE TABLE `see_series` (
  `id` int(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_series`
--

INSERT INTO `see_series` (`id`, `sname`, `status`) VALUES
(1, '神话局', 1),
(2, '神话', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_service`
--

CREATE TABLE `see_service` (
  `id` int(20) NOT NULL,
  `spic` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1:显示,0:不显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_service`
--

INSERT INTO `see_service` (`id`, `spic`, `status`) VALUES
(1, 'http://www.test.com/uploads/20170728/d38e206e6820e775d0bc139a0283ea0c.png', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_user`
--

CREATE TABLE `see_user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `age` int(10) NOT NULL,
  `phone` char(32) NOT NULL,
  `mycode` varchar(255) NOT NULL,
  `yourscode` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `news` int(255) NOT NULL DEFAULT '0',
  `picesum` double NOT NULL DEFAULT '0',
  `givefree` double NOT NULL DEFAULT '0' COMMENT '赠送金额',
  `rebate` double DEFAULT '0' COMMENT '返利金额',
  `collec` varchar(255) DEFAULT NULL COMMENT '收藏视频',
  `lookvideo` varchar(255) DEFAULT NULL COMMENT '可观看视频',
  `oppor` int(255) NOT NULL COMMENT '观看机会',
  `purchase` varchar(255) DEFAULT NULL COMMENT '购买视频',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_user`
--

INSERT INTO `see_user` (`id`, `username`, `sex`, `age`, `phone`, `mycode`, `yourscode`, `password`, `time`, `pic`, `news`, `picesum`, `givefree`, `rebate`, `collec`, `lookvideo`, `oppor`, `purchase`, `status`) VALUES
(1, 'eyes_1500688777', '男', 545, '15665438551', '150068877791', '150068877785', '5690dddfa28ae085d23518a035707282', '1500688777', '/static/index/images/moren.png', 0, 0, 0, 1.1, '2,5', NULL, 965, '2,7', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_video`
--

CREATE TABLE `see_video` (
  `id` int(255) NOT NULL,
  `videoname` varchar(255) NOT NULL,
  `videocont` text NOT NULL,
  `videourl` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `looks` int(255) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `pid` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '0:免费视频，1:付费视频',
  `pic` varchar(255) NOT NULL,
  `collecnum` int(255) DEFAULT '0',
  `thusum` int(255) DEFAULT '0',
  `series` varchar(255) DEFAULT NULL,
  `single` double DEFAULT '0',
  `pack` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_video`
--

INSERT INTO `see_video` (`id`, `videoname`, `videocont`, `videourl`, `time`, `looks`, `status`, `pid`, `type`, `pic`, `collecnum`, `thusum`, `series`, `single`, `pack`) VALUES
(2, '齐天大圣', '<p>正如楼上所述<br/>在mutation的state的自定义set change方法的时候 根据使用场景的不同 <br/>储存到Session Storage和Local Storage或者其他本地储存中<br/>把对应state的初始化改成从本地储存中获取 <br/>另外本地储存 如果是存储JSON字符串 一定要做好相应的容错处理</p><p><br/><br/>作者：Deboy<br/>链接：https://www.zhihu.com/question/54164220/answer/138274945<br/>来源：知乎<br/>著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。</p><p><br/></p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500431524', 279, 1, '古生物', 0, 'http://www.test.com/uploads/20170719/682cbf88977bd745f3862a650d33a49d.png', 1, 21, '神话', 0, 0),
(3, '调试', '<p>调试调试调试调试调试调试调试</p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500692104', 323, 1, '海洋生物', 0, 'http://www.test.com/uploads/20170722/e6b4829284bb5cdd126377c04393ea35.png', 0, 1, '神话', 0, 0),
(5, '调试二', '<p>调试2<br/></p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500692477', 3673, 1, '陆地生物', 1, 'http://www.test.com/uploads/20170722/279665097f1663744376fb0078d320ea.png', 5, 33, '', 9.9, 0),
(6, '调试三', '<p>调试2<br/></p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500692477', 3391, 1, '陆地生物', 1, 'http://www.test.com/uploads/20170722/279665097f1663744376fb0078d320ea.png', 4, 32, '', 9.9, 0),
(7, '齐天大圣', '<p>正如楼上所述<br/>在mutation的state的自定义set change方法的时候 根据使用场景的不同 <br/>储存到Session Storage和Local Storage或者其他本地储存中<br/>把对应state的初始化改成从本地储存中获取 <br/>另外本地储存 如果是存储JSON字符串 一定要做好相应的容错处理</p><p><br/><br/>作者：Deboy<br/>链接：https://www.zhihu.com/question/54164220/answer/138274945<br/>来源：知乎<br/>著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。</p><p><br/></p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500431524', 266, 1, '古生物', 0, 'http://www.test.com/uploads/20170719/682cbf88977bd745f3862a650d33a49d.png', 1, 21, '神话局', 0, 0),
(8, '调试', '<p>调试调试调试调试调试调试调试</p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500692104', 316, 1, '海洋生物', 0, 'http://www.test.com/uploads/20170722/e6b4829284bb5cdd126377c04393ea35.png', 0, 0, '神话局', 0, 0),
(9, '测试5', '<p>测试5555555<br/></p>', 'http://movie.ks.js.cn/flv/other/1_0.mp4', '1500887434', 22, 1, '沙漠探险', 0, 'http://www.test.com/uploads/20170724/f70886b6af8b89acfa26cb19ce5c4115.png', 0, 1, '神话', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `see_videoclass`
--

CREATE TABLE `see_videoclass` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_videoclass`
--

INSERT INTO `see_videoclass` (`id`, `name`, `status`) VALUES
(1, '古生物', 1),
(2, '海洋生物', 1),
(3, '陆地生物', 1),
(4, '飞行动物', 1),
(5, '普通植物', 1),
(6, '溶洞探险', 1),
(7, '沙漠探险', 1),
(8, '地球的力量', 1),
(9, '两级', 1),
(10, '生产科技', 1),
(11, '天文科技', 1),
(12, '气候环境', 1),
(13, '考古', 1);

-- --------------------------------------------------------

--
-- 表的结构 `see_videomessage`
--

CREATE TABLE `see_videomessage` (
  `id` int(255) NOT NULL,
  `aid` int(255) NOT NULL COMMENT '视频id',
  `u_nickname` varchar(255) NOT NULL COMMENT '留言姓名',
  `u_pic` varchar(255) NOT NULL COMMENT '留言头像',
  `u_message` text NOT NULL COMMENT '留言内容',
  `time` varchar(255) NOT NULL COMMENT '留言时间',
  `name` varchar(255) NOT NULL COMMENT '给谁留言',
  `pid` int(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `see_videomessage`
--

INSERT INTO `see_videomessage` (`id`, `aid`, `u_nickname`, `u_pic`, `u_message`, `time`, `name`, `pid`) VALUES
(1, 2, 'eyes_1500688777', '/static/index/images/moren.png', '3123', '1500874187', '齐天大圣', 0),
(2, 2, 'eyes_1500688777', '/static/index/images/moren.png', '213123', '1500874752', '齐天大圣', 0),
(3, 2, 'eyes_1500688777', '/static/index/images/moren.png', '21312', '1500874784', '齐天大圣', 0),
(4, 2, 'eyes_1500688777', '/static/index/images/moren.png', 'aaa', '1500874813', '齐天大圣', 0),
(5, 2, 'eyes_1500688777', '/static/index/images/moren.png', '阿萨德', '1500874829', '齐天大圣', 0),
(6, 2, 'eyes_1500688777', '/static/index/images/moren.png', '312312', '1500875270', '齐天大圣', 0),
(7, 2, 'eyes_1500688777', '/static/index/images/moren.png', '3123啊', '1500875357', '齐天大圣', 0),
(8, 2, 'eyes_1500688777', '/static/index/images/moren.png', '3123啊', '1500875386', '齐天大圣', 0),
(9, 2, 'eyes_1500688777', '/static/index/images/moren.png', '11啊', '1500875413', '齐天大圣', 0),
(10, 2, 'eyes_1500688777', '/static/index/images/moren.png', '6666', '1500875456', '齐天大圣', 0),
(11, 2, 'eyes_1500688777', '/static/index/images/moren.png', '3123123123123', '1500875478', '齐天大圣', 0),
(12, 2, 'eyes_1500688777', '/static/index/images/moren.png', '@eyes_1500688777:覇', '1500876372', '齐天大圣', 0),
(13, 3, 'eyes_1500688777', '/static/index/images/moren.png', '213', '1500876485', '调试', 0),
(14, 5, 'eyes_1500688777', '/static/index/images/moren.png', '123', '1500876490', '调试二', 0),
(15, 5, 'eyes_1500688777', '/static/index/images/moren.png', '123', '1500890106', '调试二', 0),
(16, 5, 'eyes_1500688777', '/static/index/images/moren.png', '312312', '1500890235', '调试二', 0),
(17, 9, 'eyes_1500688777', '/static/index/images/moren.png', '312312', '1500890276', '测试5', 0),
(18, 9, 'eyes_1500688777', '/static/index/images/moren.png', '无情二七', '1500891037', '测试5', 0),
(19, 9, 'eyes_1500688777', '/static/index/images/moren.png', '@eyes_1500688777:萨达', '1500891095', '测试5', 18),
(20, 5, 'eyes_1500688777', '/static/index/images/moren.png', '@eyes_1500688777:', '1501141660', '调试二', 14);

-- --------------------------------------------------------

--
-- 表的结构 `see_withd`
--

CREATE TABLE `see_withd` (
  `id` int(255) NOT NULL,
  `truename` varchar(255) NOT NULL,
  `card` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `wprice` double NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0:未确认；1:已确认'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `see_apply`
--
ALTER TABLE `see_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_banner`
--
ALTER TABLE `see_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_barrage`
--
ALTER TABLE `see_barrage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_free`
--
ALTER TABLE `see_free`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_manage`
--
ALTER TABLE `see_manage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_rebate`
--
ALTER TABLE `see_rebate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_recharge`
--
ALTER TABLE `see_recharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_series`
--
ALTER TABLE `see_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_service`
--
ALTER TABLE `see_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_user`
--
ALTER TABLE `see_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_video`
--
ALTER TABLE `see_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_videoclass`
--
ALTER TABLE `see_videoclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_videomessage`
--
ALTER TABLE `see_videomessage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `see_withd`
--
ALTER TABLE `see_withd`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `see_apply`
--
ALTER TABLE `see_apply`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `see_banner`
--
ALTER TABLE `see_banner`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `see_barrage`
--
ALTER TABLE `see_barrage`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `see_free`
--
ALTER TABLE `see_free`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `see_manage`
--
ALTER TABLE `see_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `see_rebate`
--
ALTER TABLE `see_rebate`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `see_recharge`
--
ALTER TABLE `see_recharge`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `see_series`
--
ALTER TABLE `see_series`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `see_service`
--
ALTER TABLE `see_service`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `see_user`
--
ALTER TABLE `see_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `see_video`
--
ALTER TABLE `see_video`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `see_videoclass`
--
ALTER TABLE `see_videoclass`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `see_videomessage`
--
ALTER TABLE `see_videomessage`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `see_withd`
--
ALTER TABLE `see_withd`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
