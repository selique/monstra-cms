<h2><?php echo __('Pages', 'pages'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    echo ( 
            Html::anchor(__('Create New Page', 'pages'), 'index.php?id=pages&action=add_page', array('title' => __('Create new page', 'pages'), 'class' => 'btn btn-small')). Html::nbsp(3).
            Html::anchor(__('Edit 404 Page', 'pages'), 'index.php?id=pages&action=edit_page&name=error404', array('title' => __('Create new page', 'pages'), 'class' => 'btn btn-small')) 
        ); 
?>

<br /><br />

<table class="table table-bordered">
    <thead>
        <tr>
            <td width="3%"></td>
            <td><?php echo __('Name', 'pages'); ?></td>
            <td class="hidden-phone"><?php echo __('Author', 'pages'); ?></td>
            <td class="hidden-phone"><?php echo __('Status', 'pages'); ?></td>
            <td class="hidden-phone"><?php echo __('Access', 'pages'); ?></td>
            <td class="hidden-phone"><?php echo __('Date', 'pages'); ?></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
    <?php
        if (count($pages) != 0) { 
                foreach ($pages as $page) {
                    if ($page['parent'] != '') { $dash = Html::arrow('right').'&nbsp;&nbsp;'; } else { $dash = ""; }
     ?>
     <?php if ($page['slug'] != 'error404') { ?>
     <?php
        $expand = PagesAdmin::$pages->select('[slug="'.(string)$page['parent'].'"]', null);
        if ($page['parent'] !== '' && isset($expand['expand']) && $expand['expand'] == '1') { $visibility = 'style="display:none;"'; } else { $visibility = ''; }
     ?>
     <tr <?php echo $visibility; ?> <?php if(trim($page['parent']) !== '') {?> rel="children_<?php echo $page['parent']; ?>" <?php } ?>>  
        <td> 
        <?php                    
            if (count(PagesAdmin::$pages->select('[parent="'.(string)$page['slug'].'"]', 'all')) > 0) {
                if (isset($page['expand']) && $page['expand'] == '1') {
                    echo '<a href="javascript:;" class="btn-expand parent" token="'.Security::token().'" rel="'.$page['slug'].'">+</a>';
                } else {
                    echo '<a href="javascript:;" class="btn-expand parent" token="'.Security::token().'" rel="'.$page['slug'].'">-</a>';
                }
            }
        ?>    
        </td> 
        <td>
            <?php
                $_parent = (trim($page['parent']) == '') ? '' : $page['parent'];
                $parent  = (trim($page['parent']) == '') ? '' : $page['parent'].'/';
                echo (trim($page['parent']) == '') ? '' : '&nbsp;';
                echo $dash.Html::anchor(Html::toText($page['title']), $site_url.$parent.$page['slug'], array('target' => '_blank', 'rel' => 'children_'.$_parent)); 
            ?>
        </td>
        <td class="hidden-phone">
            <?php echo $page['author']; ?>
        </td>
        <td class="hidden-phone">
            <?php echo $page['status']; ?>
        </td>
        <td class="hidden-phone">
            <?php echo $page['access']; ?>
        </td>
        <td class="hidden-phone">
            <?php echo Date::format($page['date'], "j.n.Y"); ?>
        </td>
        <td>            
            <div class="pull-right">
            <div class="btn-group">
                <?php echo Html::anchor(__('Edit', 'pages'), 'index.php?id=pages&action=edit_page&name='.$page['slug'], array('class' => 'btn btn-small')); ?>
                <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php if ($page['parent'] == '') { ?>
                        <li><a href="index.php?id=pages&action=add_page&parent_page=<?php echo $page['slug']; ?>" title="<?php echo __('Create new page', 'pages'); ?>"><?php echo __('Add', 'pages'); ?></a></li>
                    <?php } ?>
                    <li><?php echo Html::anchor(__('Clone', 'pages'), 'index.php?id=pages&action=clone_page&name='.$page['slug'].'&token='.Security::token(), array('title' => __('Clone', 'pages'))); ?></li>
                </ul>    
                <?php echo Html::anchor(__('Delete', 'pages'),
                           'index.php?id=pages&action=delete_page&name='.$page['slug'].'&token='.Security::token(),
                           array('class' => 'btn btn-actions btn-small btn-actions-default', 'onclick' => "return confirmDelete('".__("Delete page: :page", 'pages', array(':page' => Html::toText($page['title'])))."')"));
                ?>
            </div>  
            </div>           
        </td>
     </tr> 

     <?php } ?>
    <?php
            } 
        }
    ?>
    </tbody>
</table>

<form>
    <input type="hidden" name="url" value="<?php echo Option::get('siteurl'); ?>admin/index.php?id=pages">
</form>
