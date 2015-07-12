<?php 
return [
	'modelMap' => [
                      'jiangshi' => 'lecturer',
                      'jiaolian' => 'lecturer',
                      'jiangshifenpei' => 'lecturerAssignment',
                      'jiaolianfenpei' => 'lecturerAssignment',
                      'kecheng' => 'course',
                      'kechengshijian' => 'courseUsedtime',
                      'kechengjiangshi' => 'courseLecturer',
                      'kechengjiaolian' => 'courseLecturer',
                      'jiaoliankecheng' => 'lecturerCourse',
                      'jiangshikecheng' => 'lecturerCourse',
                      'paike' => 'scheduling',
                      'lanmu' => 'categorys',
                      'paikehuichang' => 'schedulingVenue',
                      'huichangkecheng' => 'schedulingVenueCourse', 
                      'youxiang' => 'email',
                      'dizhi' => 'address',
                      'shouji' => 'directory',
                      'fujian' => 'attachment',
                      'lanmu' => 'categorys',
                      'biaoqian' => 'tags',
                      'biaoqianguanlian' => 'tagRelation',
                      'yuyue' => 'appoint',
                      'huiyuan' => 'userMember',
                      'huiyuanxinxi' => 'memberInfo',
                      'anlitijiao' => "caseSubmit",
                      "shenpiyijian"=>'yijian'

    ]
];
?>