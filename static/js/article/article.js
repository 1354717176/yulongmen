/**
 * Created by Administrator on 2017/10/22.
 */
$(function () {
    var operate = {
        errorHtml:'<label class="col-sm-3 col-md-2 control-label"></label><p class="col-sm-9 col-md-6 help-block"><i class="icon wb-close" aria-hidden="true" style="font-size:12px"></i>%s</p>',
        check: function () {
            //表单验证
            $('#articleForm').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'icon wb-check',
                    invalid: 'icon wb-close',
                    validating: 'icon wb-refresh'
                },

                // List of fields and their validation rules
                fields: {
                    catid: {
                        validators: {
                            notEmpty: {
                                message: '分类必选'
                            }
                        }
                    },
                    title: {
                        validators: {
                            notEmpty: {
                                message: '文章标题不能为空'
                            }
                        }
                    }
                }
            })
            .on('success.form.fv', function(e) {
                var $form = $(e.target);
                $form.ajaxSubmit({
                    url: $form.attr('action'),
                    type:'post',
                    dataType: 'json',
                    success: function(responseText, statusText, xhr, $form) {
                        if(responseText.code == 0){
                            $(".article-list").trigger('click');
                        }else{
                            $(".has-error").html(operate.errorHtml.replace('%s',responseText.msg));
                        }
                    }
                });
                return false;
            })
        },
        ueditor:function () {
            var ue = UE.getEditor('content',{
                toolbars: [
                    [ 'source', 'bold', 'italic', 'underline', 'fontborder','insertimage','simpleupload', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','fontfamily','fontsize']
                ],
            });
            ue.ready(function() {
                ue.setHeight(400);
            })
        },
        file:function () {
            $("#img").on('change',function (e) {
                var name = e.currentTarget.files[0].name;
                $('#img-name').val(name);
            })
        },
        status:function (othis) {
            var status = othis.data('status'),id=othis.data('id');
            layui.use('layer', function() {
                var $ = layui.jquery, layer = layui.layer;
                layer.confirm('确定要执行这个操作吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    $.post('/article/detail/status',{status:status,id:id},function (data) {
                        layer.close();
                        if(data.code==0){
                            layer.msg('操作成功');
                        }else{
                            layer.msg('操作失败');
                        }
                    })
                });
            })
        }
    }

    //初始化表单验证

    if(module!='lists'){
        operate.check();
        operate.ueditor();
        operate.file();
    }

    $(".delete").on('click',function () {
        operate.status($(this));
    })

})
