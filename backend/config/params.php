<?php
return [
    'adminEmail' => 'admin@example.com',
    'contactNotes' => [ //联系目的
    	'安排最新课程排期',
    	'日常交流',
    ],
    'contactTypes' => [ //联系方式
    	'电话','邮件','QQ','微博','微信'
    ],
    // 是否开启审核 默认为False,数组每一项对应每一个模型
    'review' => [
    	'lecturer' => False, //讲师
    	'course' => False, //课程
    	'scheduling' => False, //排课
    ],
    // 排课的类型
    'schedulingType' => [
        1 => '公开课', 2 => '内训', 3 => 'mpd', 4 => 'Top100Summit',5 => '沙龙活动'
    ],

];
