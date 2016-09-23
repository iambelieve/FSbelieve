<?php
    include 'config/title.php';
    $navtitle = mysqli_fetch_array(mysqli_query($titleconn, "SELECT season FROM ib_fansub_season WHERE sid = ".$_GET['sid']));
    $ibtitle = 'Season - '.$navtitle['season'];
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
          if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
          $page_count = 10;
          $start_page = ($page-1) * $page_count;
?>
<div class="container">
    <div class="row">
<?php if(!isset($_GET['mod']) or $_GET['mod'] == 'list'){ 
    $ssq = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ib_fansub_season WHERE sid = ".$_GET['sid']));
    $sso = mysqli_query($conn, "SELECT * FROM  ib_fansub_project WHERE sid = ".$_GET['sid']." ORDER BY dateline DESC LIMIT ".$start_page.", ".$page_count);
?>
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4><?=$ssq['season'];?></h4>
            </div>
            <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">Topic</th>
                                        <th width="20%">Co-work</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($ss = mysqli_fetch_array($sso)) {?>
                                    <tr>
                                        <td><a href="project.php?pid=<?=$ss['pid'];?>"><?=$ss['title'];?></a></td>
                                        <td><?=$ss['co_work'];?></td>
                                        <td><?=$ss['pjviews'];?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                <?php echo pagination($conn,$page_count,$page,$url='season.php?mod=list&sid='.$_GET['sid'].'&page=',$queryPage="SELECT COUNT(pid) FROM ib_fansub_project WHERE sid = ".$_GET['sid']); ?>
                    </div>
        </div>
<?php }elseif($_GET['mod'] == 'read' and isset($_GET['tid'])){ 
    $data_tp = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ib_fansub_topic WHERE tid = ".$_GET['tid']));
?>  
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4><?=$data_tp['topic'];?> <div class="pull-right"><h6>อ่าน <?=($data_tp['tread']+1);?></h6></div></h4>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=$data_tp['message'];?>
                </div>
                <div class="panel-footer text-right"><b>Author :</b> <?=$data_tp['author'];?></div>
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