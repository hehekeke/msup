                $("body").on("click",".selectByRole", function(){
                    var roleId = $("select[name='roleTag']").val();
                    loadUrl('select-lecturer-by-tag?tagId='+roleId);
                })  
                $("body").on("click", ".searchLecturer", function(){
                    var name = $("input[name='search']").val();
                    if ( !(name == '') ) {
                        loadUrl('relationteacher?q='+name)
                    }
                })
                function loadUrl(action){
                    var url = '/admin.php/taskrecord/'+action;
                    var pageParent =  $("#relationapp-page").parent();
                    pageParent.remove("#relationapp-page");
                    pageParent.load(url);
                }
                function sureSelectLecturer() {
                    var lecturerName = '';
                    var aids = '';
                    $("#relationapp-page input:checked[name=aids]").each(function(){
                         tr = $(this).parents("tr");
                        if (aids != '') {
                            aids += ',';
                            lecturerName +=  ',';
                        }
                        aids += $(this).val();
                        lecturerName += tr.find("td").eq(3).text();
                    })
                    if(aids != ''){

                        $("#relationapp").removeAttr("readonly").val(lecturerName).attr("readonly", "readonly");
                         $("#relationapp").parent().next("input").remove();
                         $("#relationapp").next('input').remove();
                        $("<input type='hidden' name='"+$("#relationapp").attr("name")+"' value='"+aids+"' />").insertAfter($("#relationapp"));
                    }else{
                        alert("请选择讲师");
                    }
                }

                $("body").on("click", '.sure-select-lecturer',function(){
                    sureSelectLecturer();
                });