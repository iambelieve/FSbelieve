<?php
    include 'config/title.php';
    if(!isset($_GET['mod']) or $_GET['mod'] == 'list'){ 
        $ibtitle = 'ประกาศ';
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
          if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
          $page_count = 10;
          $start_page = ($page-1) * $page_count;
    $tpo = mysqli_query($conn, "SELECT * FROM  ib_fansub_topic WHERE topic_type = 1 ORDER BY date DESC");
    $tpo2 = mysqli_query($conn, "SELECT * FROM  ib_fansub_topic WHERE topic_type = 2 ORDER BY date DESC LIMIT ".$start_page.", ".$page_count);
?>
    <div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>FS Announcement </h4>
            </div>
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">ประกาศจากทีมงาน</th>
                                        <th width="15%">โดย</th>
                                        <th>อ่าน/ตอบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($t = mysqli_fetch_array($tpo)) {?>
                                    <tr>
                                        <td><a class="ib-link" href="topic.php?mod=read&tid=<?=$t['tid'];?>"><?=$t['topic'];?></a></td>
                                        <td><?=$t['author'];?></td>
                                        <td><?=$t['tread'];?> / <?=$t['topic_reply'];?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
            </div>
            <div class="pull-right"><a href="topic.php?mod=create" class="btn btn-success btn-xs"><i class="fa fa-plus-circle" aria-hidden="true"></i> ตั้งกระทู้</a></div>
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">กระทู้ทั่วไป</th>
                                        <th width="15%"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($t2 = mysqli_fetch_array($tpo2)) {?>
                                    <tr>
                                        <td><a class="ib-link" href="topic.php?mod=read&tid=<?=$t2['tid'];?>"><?=$t2['topic'];?></a></td>
                                        <td><?=$t2['author'];?></td>
                                        <td><?=$t2['tread'];?> / <?=$t2['topic_reply'];?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
<?php }elseif($_GET['mod'] == 'read' and isset($_GET['tid'])){
        $navtitle = mysqli_fetch_array(mysqli_query($titleconn, "SELECT topic FROM ib_fansub_topic WHERE tid = ".$_GET['tid']));
        $ibtitle = 'ประกาศ - '.$navtitle['topic'];
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
          if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
          $page_count = 10;
          $start_page = ($page-1) * $page_count;
    $data_tp = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ib_fansub_topic WHERE tid = ".$_GET['tid']));
    mysqli_query($conn, "UPDATE ib_fansub_topic SET tread = tread+1 WHERE tid = ".$_GET['tid']);
    $data_reply = mysqli_query($conn, "SELECT * FROM ib_fansub_reply WHERE topic_id = ".$_GET['tid']." ORDER BY reply_date ASC LIMIT ".$start_page.", ".$page_count);
?>  
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4><?=$data_tp['topic'];?> <div class="pull-right"><h6>อ่าน <?=($data_tp['tread']+1);?></h6></div></h4>
            </div>
            <div class="panel <?php echo ($data_tp['topic_type']==1)?'panel-success':'panel-default'; ?>">
                <div class="panel-body">
                    <?=$data_tp['message'];?>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6"><a href="topic.php?mod=reply&tid=<?=$data_tp['tid'];?>" class="btn btn-primary btn-xs">ตอบกระทู้</a></div>
                        <div class="col-sm-6">
                        <div class="text-right <?php echo ($data_tp['topic_type']==1)?'text-success':'text-default'; ?>"><b>โดย :</b> <?=$data_tp['author'];?></div>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
            <?php while ($reply = mysqli_fetch_array($data_reply)) { ?>
            <div class="panel <?php echo ($reply['reply_type']==1)?'panel-success':'panel-default'; ?>">
                <div class="panel-body">
                    <?=$reply['reply_message'];?>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                        <div class="text-right <?php echo ($reply['reply_type']==1)?'text-success':'text-default'; ?>"><b>#</b><?=$reply['reply_auther'];?> เมื่อ <?=date('H:i d-m-Y',$reply['reply_date']);?></div>
                        </div>
                    
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php echo pagination($conn,$page_count,$page,$url='topic.php?mod=read&tid='.$_GET['tid'].'&page=',$queryPage="SELECT COUNT(reply_id) FROM ib_fansub_reply"); ?>
            </div>
            </div>
        </div>
<?php }elseif($_GET['mod'] == 'create'){
        $ibtitle = 'ประกาศ - ตั้งกระทู่';
        include 'include/header_common.php';
        include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea',
                        height: 300,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table contextmenu paste code'
                          ],
                        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
});</script>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>ตั้งกระทู้ใหม่</h4>
            </div>
            <div class="panel panel-default" style="border:none !important;">
                        <?php if (isset($_GET['error']) and $_GET['error'] == 1) {
                            echo '<center><span style="color:#F00;"><b>'.$_GET['message'].'</b></span></center>';
                        } ?>
            <form role="form" method="POST" action="include/create_topic.php">
                <div class="form-group">
                    <label>ชื่อกระทู้</label>
                    <input class="form-control" name="tpname" value="">
                </div>
                <div class="form-group">
                    <label>เนื้อหา</label>
                    <textarea class="form-control" name="tpdata"></textarea>
                </div>
                <div class="form-group">
                    <label>โดย</label>
                    <input class="form-control" name="tpauther" value="">
                </div>
                <div class="g-recaptcha" data-sitekey="6Ldn5SUTAAAAAKkRVMzzStilPrH2HAZhV71kMetl"></div>
                <button type="submit" class="btn btn-primary btn-lg">ตั้งกระทู้ใหม่</button>
            </form>
            </div>
        </div>
<?php }elseif($_GET['mod'] == 'reply'){
        $ibtitle = 'ประกาศ - ตอบกระทู้';
        include 'include/header_common.php';
        include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
?>  
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>ตอบกระทู้</h4>
            </div>
            <div class="panel panel-default" style="border:none !important;">
                        <?php if (isset($_GET['error']) and $_GET['error'] == 1) {
                            echo '<center><span style="color:#F00;"><b>'.$_GET['message'].'</b></span></center>';
                        } ?>
            <form role="form" method="POST" action="include/reply_topic.php">
                <input type="hidden" name="tid" value="<?php echo $_GET['tid'];?>">
                <div class="form-group">
                    <label>เนื้อหา</label>
                    <textarea style="height:200px;" class="form-control" name="tpdata"></textarea>
                </div>
                <div class="form-group">
                    <label>โดย</label>
                    <input class="form-control" name="tpauther">
                </div>
                <div class="g-recaptcha" data-sitekey="6Ldn5SUTAAAAAKkRVMzzStilPrH2HAZhV71kMetl"></div>
                <button type="submit" class="btn btn-primary btn-lg">ตอบกระทู้</button>
            </form>
            </div>
        </div>
<?php } ?>
            <div class="col-sm-4 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>Search</h4>
            </div>
            <?php include 'template/'.$data_setting_fatch['sitetheme'].'/side.php'; ?>
        </div>
    </div>    
</div>
<?php
    include 'template/'.$data_setting_fatch['sitetheme'].'/footer.php';
?>