/**
 * Created by Administrator on 2017/10/22.
 */
$(function () {
    var operate = {
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
                    cate: {
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
                    }
                });
                return false;
            })
        }
    }

    //初始化表单验证
    operate.check();

})
