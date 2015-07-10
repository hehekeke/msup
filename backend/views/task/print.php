<?php $this->registerCss('table,tr,td{border:none;}body{margin:0px;}');?>

<?php foreach($list as $k=>$v):?>

<table style="margin:0px;border:none;">
    <tbody>
    <tr style="height:2.2cm">
        <td></td>
    </tr>
    <tr class="gradeA even" style="height:1.2cm;text-align:left;">
            <td class="sorting_1" style="width:4.6cm;"></td>
           <!--2.8cm <td class="sorting_1" style="width:3.4cm;"></td> --> 
            <td class="" colspan="2">麦思博（北京）111</td>
            <td class=" " style="width:3cm;">天津市1</td>
            <td class="sorting_1" style="width:3cm;"></td>
            <td class="sorting_1" colspan="2" style="width:3cm;"><?php echo $v['lecturername'];?>1</td>
            <td class=" " style="width:3cm;"><?php echo $v['lectureraddress'][1];?>1</td>
        </tr>
        <tr class="gradeA even" style="height:0.9cm;">
            <td class="sorting_1" style="width:0cm;"></td>
            <td class="" style="width:2.6cm;">天津市1</td>
            <td class="" style="width:2cm;">天津市1</td>
            <td class=" " style="width:2cm;">西青区1</td>
            <td class="sorting_1"></td>
            <td class="" style="width:2.6cm;"><?php echo $v['lectureraddress'][0];?>1</td>
            <td class="" style="width:2cm;"><?php echo $v['lectureraddress'][1];?>1</td>
            <td class=" " style="width:2cm;"><?php echo $v['lectureraddress'][2];?>1</td>
        </tr>
         <tr class="gradeA even" style="height:0.8cm;">
            <td class="sorting_1" ></td>
            <td class=" " colspan="3">海泰信息广场H座402室1</td>
            <td class="sorting_1"></td>
            <td class="" colspan="3"><?php echo $v['lecturerdetail'];?>1</td>
        </tr>
        <tr class="gradeA even" style="height:0.7cm;">
            <td class="sorting_1"></td>
            <td class="" colspan="3">麦思博(北京)软件技术有限公司1</td>
            <td class=""></td>
            <td class=" " colspan="3"><?php echo $v['lecturercompany'];?>1</td>
       </tr>
       <tr class="gradeA even" style="height:0.7cm;">
            <td class="sorting_1"></td>
            <td class=""  colspan="3">022-837181051</td>
            <td class=""></td>
            <td class=" "  colspan="3"><?php echo $v['lecturerphone'];?>1</td>
       </tr>
       <tr class="gradeA even" style="height:4.9cm;">
            <td class="sorting_1" colspan="8"></td>
       </tr>
   
        
    </tbody>
</table>

<?php endforeach;?>
                                
        
        
        

