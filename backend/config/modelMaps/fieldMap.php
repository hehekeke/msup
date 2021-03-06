<?php

return [
	'fieldMap' => [
            // 教练
            'lecturer' => [
                'id' =>  'ml_id',
                'name' =>  'ml_name',
                'phone' => 'ml_phone',
                'email' => 'ml_email',
                'qq' =>    'ml_qq',
                'wecat' => 'ml_wecat',
                'company' => 'ml_company',
                'position' => 'ml_position',
                'office' => 'ml_office',
                'referee' =>  'ml_referee',
                'penName' => 'ml_penName',
                'leadSource' => 'ml_leadSource',
                'thumbs' =>  'ml_thumbs',
                'signature' => 'ml_signature',
                'created_at' => 'ml_createdAt',
                'updated_at' => 'ml_updatedAt',
                'create_admin' => 'ml_createAdmin',
                'update_admin' => 'ml_updateAdmin',
                'status' => 'ml_status',
                'idNumber' => 'ml_idNumber',
                'content' => 'ml_content',
                'description' =>  'ml_description',
                'hits' => 'ml_hits',
                'collects' => 'ml_collects',
                'comments' => 'ml_comments',
                'praises' => 'ml_praises',
            ],
            // 教练分配
            'lecturerAssignment' => [
            	'id' => 'mla_id',
				'lecturer_id' => "mla_lecturerId",
				'user_id' => 'mla_userId',
				'status' => 'mla_status',
            ],
            // 课程
            'course' => [
                'title' => 'mc_title',
                'type' => 'mc_type',
                'courseid' => 'mc_courseid',
                'sponsor' =>  'mc_sponsor',
                'lecturer_id' =>  'mc_lecturerId',
                'usedtimeid' =>  'mc_usedtimeId',
                'price' =>  'mc_price',
                'num' =>  'mc_num',
                'desc' =>  'mc_desc',
                'character' =>  'mc_character',
                'profit' =>  'mc_profit',
                'target' =>  'mc_target',
                'trainees' =>  'mc_trainees',
                'teacher' =>  'mc_teacher',
                'training'=> 'mc_training',
                'relation' =>  'mc_relation',
                'appointment' =>  'mc_appointment',
                'file' =>  'mc_file',
                'media' => 'mc_media',
                'thumbs' =>  'mc_thumbs',
                'other' =>  'mc_other',
                'auditionvideo' =>  'mc_auditionvideo',
                'auditiondesc' =>  'mc_auditiondesc',
                'praises' => 'mc_praises',
                'collects' => 'mc_collects',
                'comments' => 'mc_comments',
                'hits' => 'mc_hits',
                'create_admin' => 'mct_createAdmin',
                'update_admin' => 'mct_updateAdmin',
                'level' => 'mc_level',
                'courseNumber' => 'mc_courseNumber',
                'lead_source' => 'mc_leadSource',
                'created_at' => 'mc_createdAt',
                'updated_at' => 'mc_updatedAt',
                'content' => 'mc_content',
                'assignToMpd' => 'mc_assignToMpd',
                'assignToTop100'  => 'mc_assignToTop100',
                'assignToOready' => 'mc_assignToOready',
                'assignToMsup' => 'mc_assignToMsup',
                'assignToSalon' => 'mc_assignToSalon',

            ],
            // 课程讲师
            'courseLecturer' => [
                'id' =>'mcl_id',
                'lid' => 'mcl_lid',
                'cid' => 'mcl_cid',
            ],
            //排课
            'scheduling' => [
                'id' => 'ms_id',
                'title' => 'ms_title',
                'startTime' => 'ms_startTime',
                'endTime' => 'ms_endTime',
                'prices' => 'ms_prices',
                'video' => 'ms_video',
                'address' =>'ms_address',
                'catid' => 'ms_catid',
                'type' => 'ms_type',
                'content' => 'ms_content',
                'applicans' => 'ms_applicans',
                'clicks' => 'ms_clicks',
                'comments' => 'ms_comments',
                'praises' => 'ms_praises',
                'celling' => 'ms_celling',
                'created_at' => 'ms_createdAt',
                'updated_at' => 'ms_updatedAt',
                'create_admin' => 'ms_createAdmin',
                'update_admin' => 'ms_updateAdmin',
                'poster' => 'ms_poster',
                'attachment' => 'ms_attachment',
                'recommendToBuzz' => 'ms_recommendToBuzz',
            ],
            //排课会场
            'schedulingVenue' => [
                'id' => 'msv_id',   
                'sid' => 'msv_sid',
                'venueName' => 'msv_venueName',
            ],
            // 排课会场课程
            'schedulingVenueCourse' => [
                'id' => 'msvc_id',
                'sid' => 'msvc_sid',
                'snid' => 'msvc_snid',
                'courseid' => 'msvc_courseId',
                'startTime' => 'msvc_startTime',
                'endTime' => 'msvc_endTime',
                'date' => 'msvc_date',
            ],
            // 邮箱
            'email' => [
                'id' => 'me_id',
                'lecturer_id' => 'me_lecturerId',
                'email' => 'me_email',
                'status' => 'me_status',
            ],
            //地址簿
            'address' => [
                'id' =>  'ma_id',
                'lecturer_id' => 'ma_lecturerId',
                'address' =>  'ma_address',
                'detail' =>  'ma_detail',
                'status' =>'ma_status',
            ],
            // 通讯簿
            'directory' => [
                'id' => 'md_id',
                'lecturer_id' => 'md_lecturerId',
                'phone' => 'md_phone',
                'status' => 'md_status',
            ],
            // 标签
            'tags' => [
                     'id' => 'mtags_id',
                     'tagName' => 'mtags_name',
                     'catid' => 'mtags_catid',
                     'hits' => 'mtags_hits',
                     'citations' => 'mtags_citations',
                     'modelId' => 'mtags_modelId',

            ],
            // 标签关联
            'tagRelation' => [
            	'id' => 'mtr_id',
                    'modelId' => 'mtr_modelId',
                    'pkId' => 'mtr_pkId',
                    'tagId' =>'mtr_tagId',
            ],
            // 课程时长
            'courseUsedtime' => [
                'usedtimeid' => 'mct_usedtimeId',
                'title' => 'mct_title',
                'desc' => 'mct_desc',
                'created_at' => 'mct_createdAt',
                'updated_at' => 'mct_updatedAt',
                'create_admin' => 'mct_createAdmin',
                'update_admin' => 'mct_updateAdmin',
            ],
           'appoint' => [
                'id' => 'map_id',
                'name' => 'map_name',
                'phone' => 'map_phone',
                'email' => 'map_email',
                'address' => 'map_address',
                'company' => 'map_company',
                'company_address'  => 'map_companyAddress',
                'position' => 'map_position', 
                'description' => 'map_description',
                'type' => 'map_type',
                'state' => 'map_state',
                'time' => 'map_time',
                'lid' => 'map_lid',
                'cid' => 'map_cid',
                'sid' => 'map_sid',
           ],
           'categorys' => [

                'id' =>  'mcate_id',
                'catName' => 'mcate_cateName',
                'parentId' => 'mcate_parentId',
                'childrenId' => 'mcate_childrenId',
                'parentId' => 'mcate_parentId',
           ],
           'userMember' => [
                'username' => 'mu_userName',
                'password' => 'mu_password',
                'phone' => 'mu_phone',
                'email' => 'mu_email',
                'role' => 'mu_role',
                'confirmed_at' => 'mu_confirmedAt',
           ],
           'memberInfo' => [
                    'name' => 'mmi_name',
                    'company' => 'mmi_company',
                    'position' => 'mmi_position',
                    'thumbs' => 'mmi_thumbs',
                    'userId' => 'mmi_userId'
           ],
           'caseSubmit' => [
                    'id' => 'mcs_id',
                    'courseTitle' => 'mcs_courseTitle',
                    'lecturerName' => 'mcs_lecturerName',
                    'lecturerDescription' => 'mcs_lecturerDescription',
                    'lecturerThumbs' => 'mcs_lecturerThumbs',
                    'courseTag' => 'mcs_courseTag',
                    'companyThumbs' => 'mcs_companyThumbs',
                    'courseDescription' => 'mcs_courseDescription',
                    'lecturerPosition' => 'mcs_lecturerPosition',
                    'companyDescription' => 'mcs_companyDescription',
                    'companyName' => 'mcs_companyName',
                    'courseThumbs' => 'mcs_courseThumbs',
                    'companySize' => 'mcs_companySize',
                    'companyPosition' => 'mcs_ccompanyPosition',
                    'courseContent' => 'mcs_courseContent',
                    'user_id'=>'mcs_userid',
                    'caseStatus'=>'mcs_caseStatus',
                    'caseAdvice'=>'mcs_caseAdvice'

           ],
           'yijian'=>[
                    'id'=>'myj_id',
                    'case_id'=>'myj_case_id',
                    'user_id'=>'myj_user_id',
                    'content'=>'myj_content',
                    'advice_date'=>'myj_advice_date'
           ]

        ]
];

?>