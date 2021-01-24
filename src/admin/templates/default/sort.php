<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived, 2600);</script>
<?php if (isset($_GET['active_taxis'])): ?><div class="alert alert-success">排序更新成功</div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?><div class="alert alert-success">删除分类成功</div><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?><div class="alert alert-success">修改分类成功</div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?><div class="alert alert-success">添加分类成功</div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger">分类名称不能为空</div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?><div class="alert alert-danger">没有可排序的分类</div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?><div class="alert alert-danger">别名格式错误</div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?><div class="alert alert-danger">别名不能重复</div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?><div class="alert alert-danger">别名不得包含系统保留关键字</div><?php endif; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">分类管理</h1>
    <form  method="post" action="sort.php?action=taxis">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">管理文章的分类</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="adm_sort_list">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>排序</th><th>名称</th><th>描述</th><th>别名</th><th>模板</th><th>查看</th><th>文章</th><th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($sorts):
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                        ?>
                        <tr>
                            <td>
                                <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id" />
                                <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
                            </td>
                            <td class="sortname">
                                <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a>
                            </td>
                            <td><?php echo $value['description']; ?></td>
                            <td class="alias"><?php echo $value['alias']; ?></td>
                            <td class="alias"><?php echo $value['template']; ?></td>
                            <td class="tdcenter">
                                <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./templates/<?php echo ADMIN_TEMPLATE; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
                            </td>
                            <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                            <td>
                                <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                                <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
                            </td>
                        </tr>
                        <?php
                        $children = $value['children'];
                        foreach ($children as $key):
                            $value = $sorts[$key];
                            ?>
                            <tr>
                                <td>
                                    <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id" />
                                    <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
                                </td>
                                <td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></td>
                                <td><?php echo $value['description']; ?></td>
                                <td class="alias"><?php echo $value['alias']; ?></td>
                                <td class="alias"><?php echo $value['template']; ?></td>
                                <td class="tdcenter">
                                    <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./templates/<?php echo ADMIN_TEMPLATE; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
                                </td>
                                <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                <td>
                                    <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                                    <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach;
                else: ?>
                    <tr><td class="tdcenter" colspan="8">还没有添加分类</td></tr>
                <?php endif; ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="list_footer">
            <input type="submit" value="改变排序" class="btn btn-primary" /> 
            <a href="javascript:displayToggle('sort_new', 2);" class="btn btn-success">添加分类+</a>
        </div>
    </form>
    <form action="sort.php?action=add" method="post" id="sort_new" style="margin-top: 30px;">
        <div class="form-group">
            <label for="sortname">分类名</label>
            <input class="form-control" id="sortname" name="sortname">
        </div>
        <div class="form-group">
            <label for="alias">别名</label>
            <input class="form-control" id="alias" name="alias">
            <small class="form-text text-muted">用于URL的友好显示，可不填</small>
        </div>
        <div class="form-group">
            <label>父分类</label>
            <select name="pid" id="pid" class="form-control">
                <option value="0">无</option>
                <?php
                foreach ($sorts as $key => $value):
                    if ($value['pid'] != 0) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="template">模板</label>
            <input class="form-control" id="template" name="template">
            <small class="form-text text-muted">(用于自定义分类页面模板，对应模板目录下.php文件，默认：log_list.php，可不填)</small>
        </div>
        <div class="form-group">
            <label for="alias">分类描述</label>
            <textarea name="description" type="text" class="form-control"></textarea>
        </div>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <button type="submit" id="addsort" class="btn btn-primary">提交</button><span id="alias_msg_hook"></span>
    </form>
</div>
<!-- /.container-fluid -->
<script>
    $("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
    $("#alias").keyup(function() {
        checksortalias();
    });
    function issortalias(a) {
        var reg1 = /^[\w-]*$/;
        var reg2 = /^[\d]+$/;
        if (!reg1.test(a)) {
            return 1;
        } else if (reg2.test(a)) {
            return 2;
        } else if (a == 'post' || a == 'record' || a == 'sort' || a == 'tag' || a == 'author' || a == 'page') {
            return 3;
        } else {
            return 0;
        }
    }
    function checksortalias() {
        var a = $.trim($("#alias").val());
        if (1 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
        } else if (2 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
        } else if (3 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
        } else {
            $("#alias_msg_hook").html('');
            $("#msg").html('');
            $("#addsort").attr("disabled", false);
        }
    }
</script>
