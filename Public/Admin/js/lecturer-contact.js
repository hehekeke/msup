/**
 * 联系讲师点击事件
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */

function lecturerContact(lid){
    if ( !lid ) {
        alert("错误的请求");
        return false;
    }

    if ($(".lecturer-contact-modal").length == 0) {
        $("body").append('<div class="modal fade lecturer-contact-modal" id="myModal"  tabindex="-1"  > <div class="modal-dialog modal-lg"><div class="modal-content" ></div></div></div>');
    }
    $(".lecturer-contact-modal").removeData();
    $(".lecturer-contact-modal").modal(
            {
                remote:"/admin.php/contact-notes/contact?toModel=1&iframe=1&toId="+lid
            }
    
        );
}

     
