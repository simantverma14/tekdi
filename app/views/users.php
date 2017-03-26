<?php
/* 
 * List/view App Users 
 */

if (isset($_GET['action']) && $_GET['action'] != "") { 
    $action = $_GET['action']; ?>

    <?php //check if valid action
    if($action == "list" || $action == "add" || $action == "edit"){ 
        $countries = $tbox_obj->list_countries(); ?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <?php if($action == "list"){ ?>
                <h1>Users</h1>
            <?php } else if($action == "add"){ ?>
                <h1>Add new</h1>
            <?php } else if($action == "edit"){ ?>
                <h1>Edit</h1>
            <?php } ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <?php if($action == "list"){
                    $users_list = $tbox_obj->list_users(); ?>
                    <div class="col-xs-12 top_desc">
                        <div class="col-xs-10 no-padding">
                            List of all the users available.
                        </div>
                        <div class="col-xs-2">
                            <a class="btn bg-navy btn-block" href="<?php echo SITE_URL; ?>index.php?page=users&action=add">Add User</a>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Total Users: <b><?php echo count($users_list); ?></b></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="users_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>Mobile</th>
                                            <th>Birthday</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tr id="filterrow">
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>Mobile</th>
                                            <th>Birthday</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users_list as $user) { ?>
                                            <tr>
                                                <td><?php echo $user['name']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['country']; ?></td>
                                                <td><?php echo $user['mobile_number']; ?></td>
                                                <td><?php echo $user['birthday']; ?></td>
                                                <td class='text-center'>
                                                    <a href="<?php echo SITE_URL.'index.php?page=users&action=edit&post='.$user['id']; ?>" class="btn btn-sm btn-social btn-bitbucket"><i class="fa fa-edit"></i> Edit</a>
                                                    <a class="btn btn-sm btn-danger btn-social" data-href="<?php echo SITE_URL; ?>app/delete-record.php?post=<?php echo $user['id']; ?>&type=user" data-toggle="modal" data-target="#confirmDelete"><i class="fa fa-trash" title="Delete user"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                <?php } else if($action == "add"){ ?>
                    <?php if($countries){ ?>
                        <div class="col-xs-12 top_desc">
                            <div class="col-xs-10 no-padding">
                                Add a new user
                            </div>
                            <div class="col-xs-2">
                                <a class="btn bg-navy btn-block" href="<?php echo SITE_URL; ?>index.php?page=users&action=list">List Users</a>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <!-- Add user form -->
                                <form id="adduser" class="form-horizontal" role="form" method="post" action="<?=utils::safeEcho($_SERVER['PHP_SELF'], 1);?>">
                                    <input type="hidden" name="CSRF_token" value="<?=security::$CSRF_token;?>" />

                                    <div class="mainbox col-md-10">
                                        <div class="box-body">
                                            <div id="useralert" style="display:none" class="alert alert-danger col-sm-12">
                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                <p></p>
                                            </div>
                                            <div id="usersuccess" style="display:none" class="alert alert-success col-sm-12">
                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                <p></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-md-3 control-label">Name <span class="text-red">*</span></label>
                                                <div class="col-md-9">
                                                    <input id="name" type="text" class="form-control" name="name" placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-md-3 control-label">Email <span class="text-red">*</span></label>
                                                <div class="col-md-9">
                                                    <input id="email" type="text" class="form-control" name="email" placeholder="Enter email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="country_id" class="col-md-3 control-label">Select Country <span class="text-red">*</span></label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="country_id" id="country_id">
                                                        <option value="">Please Select</option>
                                                        <?php foreach($countries as $country){ ?>
                                                            <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile_number" class="col-md-3 control-label">Mobile Number <span class="text-red">*</span></label>
                                                <div class="col-md-9">
                                                    <input id="mobile_number" type="text" class="form-control" name="mobile_number" placeholder="Enter mobile number">
                                                </div>
                                            </div>
                                            <div class="form-group date_field">
                                                <label for="birthday" class="col-md-3 control-label">Birthday <span class="text-red">*</span></label>
                                                <div class="input-group col-md-9" id='birthdaypicker'>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="birthday" name="birthday" placeholder="Enter birthday">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="about_you" class="col-md-3 control-label">About user <span class="text-red">*</span></label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" placeholder="About user" name="about_you" id="about_you"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">                                   
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button id="btn-adduser" type="submit" class="btn btn-primary" name="btn-adduser">Submit</button> 
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    <?php } else { ?>
                        <p> No countries available to add user </p>
                    <?php } ?>
                <?php } else if($action == "edit"){
                    if (!isset($_GET['post']) || $_GET['post'] == "") {
                        utils::redirect(LAYOUT.'/?page=users');
                    } else {
                        if($countries){
                            $post = $_GET['post'];
                            $user_info = $tbox_obj->get_user_info($post);
                            
                            if($user_info){ ?>
                                <div class="col-xs-12 top_desc">
                                    <div class="col-xs-10 no-padding">
                                        Edit User data
                                    </div>
                                    <div class="col-xs-2">
                                        <a class="btn bg-navy btn-block" href="<?php echo SITE_URL; ?>index.php?page=users&action=list">List Users</a>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="box box-primary">
                                        <!-- Edit User -->
                                        <form id="edituser" class="form-horizontal" role="form" method="post" action="<?=utils::safeEcho($_SERVER['PHP_SELF'], 1);?>">
                                            <input type="hidden" name="CSRF_token" value="<?=security::$CSRF_token;?>" />
                                            <input type="hidden" name="user_id" value="<?php echo $user_info['id']; ?>" />

                                            <div class="mainbox col-md-10">
                                                <div id="editalert" style="display:none" class="alert alert-danger col-sm-12">
                                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                    <p></p>
                                                </div>
                                                <div id="editsuccess" style="display:none" class="alert alert-success col-sm-12">
                                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                    <p></p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-md-3 control-label">Name <span class="text-red">*</span></label>
                                                    <div class="col-md-9">
                                                        <input id="name" type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $user_info['name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="col-md-3 control-label">Email <span class="text-red">*</span></label>
                                                    <div class="col-md-9">
                                                        <input id="email" type="text" class="form-control" name="email" placeholder="Enter email" value="<?php echo $user_info['email']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country_id" class="col-md-3 control-label">Select Country <span class="text-red">*</span></label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="country_id" id="country_id">
                                                            <option value="">Please Select</option>
                                                            <?php foreach($countries as $country){ ?>
                                                                <option value="<?php echo $country['id']; ?>" <?php echo (($country['id'] == $user_info['country'])?"selected":""); ?>><?php echo $country['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobile_number" class="col-md-3 control-label">Mobile Number <span class="text-red">*</span></label>
                                                    <div class="col-md-9">
                                                        <input id="mobile_number" type="text" class="form-control" name="mobile_number" placeholder="Enter mobile number" value="<?php echo $user_info['mobile_number']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group date_field">
                                                    <label for="birthday" class="col-md-3 control-label">Birthday <span class="text-red">*</span></label>
                                                    <div class="input-group col-md-9" id='birthdaypicker'>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="birthday" name="birthday" placeholder="Enter birthday" value="<?php echo $user_info['birthday']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="about_you" class="col-md-3 control-label">About user <span class="text-red">*</span></label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control" rows="3" placeholder="About user" name="about_you" id="about_you"><?php echo $user_info['about_you']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">                                   
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button id="btn-edituser" type="submit" class="btn btn-primary" name="btn-edituser">Submit</button> 
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            <?php } else { ?>
                                <p>Invalid User ID</p>
                            <?php } ?>
                        <?php } else { ?>
                            <p>No countries available to add record</p>
                        <?php } ?>
                    <?php }
                } ?>
            </div><!-- /.row -->
        </section><!-- /.content -->
    <?php } else { ?>
        <p>Invalid value for action.</p>
    <?php } ?>
<?php } else {
    utils::redirect(LAYOUT.'?page=users&action=list');
}
?>

<!-- Delete user Modal-->
<div class="modal modal-danger fade" id="confirmDelete" role="dialog" aria-labelledby="delete_user" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete User Permanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user permanently?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-outline" id="confirm">Delete</a>
            </div>
        </div>
    </div>
</div>